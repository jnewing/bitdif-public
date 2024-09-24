<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessThumbnail;
use App\Models\Img;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use lib\BitDif\BitDif;
use Ramsey\Uuid\Uuid;

class APIController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,gif,jpeg',
        ]);

        if ($request->hasHeader('Authorization')) {

            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);

            // get the user
            $user = User::where('api_token', $token)->firstOrFail();

            // upload the image
            $image = $request->file('image');

            // gen a new filename
            $files = BitDif::genFileName($image->getClientOriginalExtension());

            // sort out the path
            $relative_path = ['public', 'uploads', $user->id, date('Y'), date('m'), date('d')];
            $public_path = ['storage', 'uploads', $user->id, date('Y'), date('m'), date('d')];

            // make the directory
            Storage::makeDirectory(implode(DIRECTORY_SEPARATOR, $relative_path));

            // upload the origional file
            $final_loc = $image->storeAs(implode(DIRECTORY_SEPARATOR, $relative_path), $files['name']);
            // $final_thumb = storage_path(implode(DIRECTORY_SEPARATOR, array_merge(['app', 'public'], array_slice($relative_path, 1)) )) . DIRECTORY_SEPARATOR .  $files['thumb'];

            // first add the image to the db
            $i = Img::create([
                'oid' => explode('-', (string) Uuid::uuid4())[0],
                'user_id' => $user->id,
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

            return [
                'status' => 200,
                'data' => [
                    'link' => route('img', ['id' => $i->oid]),
                ],
            ];

        }

    }
}
