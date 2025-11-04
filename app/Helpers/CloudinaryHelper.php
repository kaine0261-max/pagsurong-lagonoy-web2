<?php

namespace App\Helpers;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryHelper
{
    protected static $cloudinary;

    protected static function getCloudinary()
    {
        if (!self::$cloudinary) {
            self::$cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('filesystems.disks.cloudinary.cloud_name'),
                    'api_key' => config('filesystems.disks.cloudinary.api_key'),
                    'api_secret' => config('filesystems.disks.cloudinary.api_secret'),
                ],
                'url' => [
                    'secure' => true
                ]
            ]);
        }
        return self::$cloudinary;
    }

    public static function upload(UploadedFile $file, string $folder = 'uploads'): string
    {
        $cloudinary = self::getCloudinary();
        
        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'auto',
        ]);

        return $result['public_id'];
    }

    public static function url(string $publicId): string
    {
        $cloudinary = self::getCloudinary();
        return $cloudinary->image($publicId)->toUrl();
    }

    public static function delete(string $publicId): void
    {
        $cloudinary = self::getCloudinary();
        $cloudinary->uploadApi()->destroy($publicId);
    }
}
