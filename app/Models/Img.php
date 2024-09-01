<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Img extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'oid',
        'user_id',
        'original_name',
        'original_extension',
        'file_name',
        'thumbnail_name',
        'path',
        'public_path',
        'mime_type',
        'file_size',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    public function views()
    {
        return $this->hasMany(ImgView::class);
    }

    // public function getThumbNail()
    // {

    // }

    // public function getImage()
    // {

    // }

}
