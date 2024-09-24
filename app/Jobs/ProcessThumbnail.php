<?php

namespace App\Jobs;

use App\Models\Img;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
// use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Queue\SerializesModels;
// use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class ProcessThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Img $image,
        public string $final_thumb,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $img_path = storage_path("app/{$this->image->path}/{$this->image->file_name}");
        $thumb_path = storage_path("app/{$this->image->path}/{$this->final_thumb}");

        // $img = Image::make($img_path)->resize(162, 162)->save($thumb_path);
        // $img = Image::make($img_path)->cover(162, 162)->save($thumb_path);

        $manager = new ImageManager(new Driver);
        $img = $manager->read($img_path)->coverDown(162, 162)->save($thumb_path);

        // now update the image record
        $this->image->update([
            'thumbnail_name' => $this->final_thumb,
        ]);
    }
}
