<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessThumbnail;
use App\Models\Img;
use App\Models\ImgView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use lib\BitDif\BitDif;
use Ramsey\Uuid\Uuid;
use ZipArchive;

class ImgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        // get a list of images
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        $images = Img::where('user_id', Auth::id())->orderBy($sort, $order)->paginate(35)->onEachSide(1);

        return Inertia::render('Img/Index', [
            'images' => $images->appends(['sort' => $request->input('sort'), 'order' => $request->input('order')]),
            'sortOptions' => [
                'sort' => ['id' => $sort],
                'order' => ['id' => $order],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Img/Upload', [
            'maxSize' => BitDif::file_upload_max_size(),
            'maxFiles' => BitDif::get_max_files(),
            'canPaste' => config('app.allow_upload_via_paste'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // upload validation
        $request->validate([
            'images' => 'required',
            'images.*' => [
                'image',
                'mimes:jpg,png,gif',
                // 'dimensions:ratio=3/2',
                // 'max:2048',
            ],
        ]);

        // lets upload the images
        foreach ($request->file('images') as $image) {
            // gen a new filename
            $files = BitDif::genFileName($image->getClientOriginalExtension());

            // sort out the path
            $relative_path = ['public', 'uploads', Auth::id(), date('Y'), date('m'), date('d')];
            $public_path = ['storage', 'uploads', Auth::id(), date('Y'), date('m'), date('d')];

            // make the directory
            Storage::makeDirectory(implode(DIRECTORY_SEPARATOR, $relative_path));

            // upload the origional file
            $final_loc = $image->storeAs(implode(DIRECTORY_SEPARATOR, $relative_path), $files['name']);
            // $final_thumb = storage_path(implode(DIRECTORY_SEPARATOR, array_merge(['app', 'public'], array_slice($relative_path, 1)) )) . DIRECTORY_SEPARATOR .  $files['thumb'];

            // first add the image to the db
            $i = Img::create([
                'oid' => explode('-', (string) Uuid::uuid4())[0],
                'user_id' => Auth::id(),
                'original_name' => $image->getClientOriginalName(),
                'original_extension' => $image->getClientOriginalExtension(),
                'file_name' => $files['name'],
                'path' => implode(DIRECTORY_SEPARATOR, $relative_path),
                'public_path' => implode(DIRECTORY_SEPARATOR, $public_path),
                'mime_type' => $image->getMimeType(),
                'file_size' => $image->getSize(),
            ]);

            // pass off the thumbnail creation to a job
            if (config('app.gen_thumbnails')) {
                ProcessThumbnail::dispatch($i, $files['thumb']);
            }
        }

        // take the user back to the gallery
        return redirect()->route('gallery.index');
    }

    /**
     * Bulk uploading function, takes a zip file and extracts the images.
     *
     * @return void
     */
    public function bulk_upload(Request $request): RedirectResponse
    {
        // validation
        // upload validation
        $request->validate([
            'zipfile' => 'required|file|mimes:zip',
        ]);

        // temp zip upload path
        $path = 'zip/'.(string) Uuid::uuid4();

        // handel the uplaoded file
        $zipFile = $request->file('zipfile');
        $zipFilePath = $zipFile->storeAs($path, $zipFile->getClientOriginalName());

        $valid_files = $this->unzip_file(storage_path('/app/'.$zipFilePath));

        // lets upload the images
        foreach ($valid_files as $image) {
            // gen a new filename
            $files = BitDif::genFileName(pathinfo($image, PATHINFO_EXTENSION));

            // sort out the path
            $user_path = implode(DIRECTORY_SEPARATOR, [Auth::id(), date('Y'), date('m'), date('d')]);
            $relative_path = ['public', 'uploads', Auth::id(), date('Y'), date('m'), date('d')];
            $public_path = ['storage', 'uploads', Auth::id(), date('Y'), date('m'), date('d')];

            // make the directory
            Storage::disk('imgs')->makeDirectory($user_path);

            // move the file
            // Storage::disk('imgs')->move($image, $user_path . DIRECTORY_SEPARATOR . $files['name']);
            copy($image, storage_path(implode(DIRECTORY_SEPARATOR, ['app', 'public', 'uploads', $user_path, $files['name']])));

            // first add the image to the db
            $i = Img::create([
                'oid' => explode('-', (string) Uuid::uuid4())[0],
                'user_id' => Auth::id(),
                'original_name' => pathinfo($image, PATHINFO_FILENAME),
                'original_extension' => pathinfo($image, PATHINFO_EXTENSION),
                'file_name' => $files['name'],
                'path' => implode(DIRECTORY_SEPARATOR, $relative_path),
                'public_path' => implode(DIRECTORY_SEPARATOR, $public_path),
                'mime_type' => mime_content_type($image),
                'file_size' => filesize($image),
            ]);

            // pass off the thumbnail creation to a job
            if (config('app.gen_thumbnails')) {
                ProcessThumbnail::dispatch($i, $files['thumb']);
            }
        }

        // todo.. we need a better cleanup job.
        // maybe move this off to a job?
        self::rmrf(storage_path('app/'.$path));

        return redirect()->route('gallery.index');
    }

    /**
     * Display the specified resource on a page.
     */
    public function show(Request $request, Img $img): Response
    {
        // log the view
        $this->log_view($img->id, Auth::check() ? Auth::id() : null, $request->ip());

        return Inertia::render('View', [
            'image' => $img,
            'views' => $img->views()->count(),
            'size' => $img->file_size,
        ]);
    }

    public function proxy_image(Request $request)
    {
        $url = $request->query('url');

        if (! $url) {
            return response()->json(['error' => 'No URL provided.'], 400);
        }

        try {
            $response = Http::get($url);
            if ($response->successful()) {
                return response($response->body(), 200, [
                    'Content-Type' => $response->header('Content-Type'),
                ]);
            } else {
                return response()->json(['error' => 'Failed to fetch image.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch image.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_direct(Request $request, Img $img, string $ext = 'jpg'): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // log the view
        $this->log_view($img->id, Auth::check() ? Auth::id() : null, $request->ip());

        return response()->file(storage_path('app/'.$img->path.'/'.$img->file_name));
    }

    /**
     * Route to show an image, either direct or in-direct.
     *
     * @return void
     */
    public function show_img(Request $request, string $id)
    {
        // do we have an extension?
        // dd($request->all(), $request->route()->parameters(), $id);

        // do we have an extension here?
        if (strpos($id, '.') !== false) {
            $parts = explode('.', $id);
            $id = $parts[0];
            $ext = $parts[1];

            return $this->show_direct($request, Img::where('oid', $id)->firstOrFail(), $ext);
        } else {
            return $this->show($request, Img::where('oid', $id)->firstOrFail());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Img $img): RedirectResponse
    {
        // does the user own this image?
        if ($img->user_id == Auth::id()) {
            // delete the file
            Storage::delete(storage_path(storage_path('app/'.$img->path.'/'.$img->file_name)));

            // delete the thumb
            Storage::delete(storage_path(storage_path('app/'.$img->path.'/'.$img->thumbnail_name)));

            // delete the db entry
            $img->delete();

            return redirect()->route('gallery.index');
        }
    }

    /**
     * Remove many of the specified resources from storage.
     *
     * @param  array  $ids
     * @return void
     */
    public function selected_destroy(Request $request): RedirectResponse
    {
        $imgs = Img::whereIn('id', $request->input('ids'))
            ->where('user_id', Auth::user()->id)
            ->get();

        // delete files
        foreach ($imgs as $i) {
            // delete the file
            Storage::delete(storage_path(storage_path('app/'.$i->path.'/'.$i->file_name)));

            // delete the thumb
            Storage::delete(storage_path(storage_path('app/'.$i->path.'/'.$i->thumbnail_name)));

            // delete db entry
            $i->delete();
        }

        return redirect()->route('gallery.index');
    }

    /**
     * Logs the view to the image, be it direct or in-direct.
     */
    private function log_view(int $img_id, ?int $user_id = null, ?string $ip_address = null): void
    {
        // check if this view is counted or not
        // $userId = Auth::check() ? Auth::id() : null;
        // $ipAddress = $request->ip();

        if (! ImgView::where('img_id', $img_id)
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            }, function ($query) use ($ip_address) {
                return $query->where('ip_address', $ip_address);
            })
            ->exists()) {
            ImgView::create([
                'img_id' => $img_id,
                'user_id' => $user_id,
                'ip_address' => $ip_address,
            ]);
        }
    }

    /**
     * Unzip a given file and return an array of .png or .jpg files.
     */
    private function unzip_file(string $zip_file_path): array
    {
        $valid_files = [];
        $zip = new ZipArchive;

        if ($zip->open($zip_file_path) === true) {
            $extractPath = dirname($zip_file_path).'/ext/';
            $zip->extractTo($extractPath);
            $zip->close();

            // scan the directory for .jpg and .png files
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($extractPath));
            foreach ($files as $file) {
                if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png'])) {
                    $valid_files[] = $file->getPathname();
                }
            }
        }

        return $valid_files;
    }

    /**
     * Recursive function to delete everything in a directory.
     *
     * @return void
     */
    private static function rmrf(string $dir): bool
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $f) {
            (is_dir($dir.DIRECTORY_SEPARATOR.$f)) ? self::rmrf($dir.DIRECTORY_SEPARATOR.$f) : unlink($dir.DIRECTORY_SEPARATOR.$f);
        }

        return rmdir($dir);
    }
}
