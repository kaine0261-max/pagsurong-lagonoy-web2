<?php
// [file name]: Attraction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $table = 'tourist_spots';

    protected $fillable = [
        'name',
        'location',
        'short_info',
        'full_info',
        'cover_photo',
        'gallery_images',
        'has_entrance_fee',
        'entrance_fee',
        'additional_info',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'has_entrance_fee' => 'boolean',
    ];
}