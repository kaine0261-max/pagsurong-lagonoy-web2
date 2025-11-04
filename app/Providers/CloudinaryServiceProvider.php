<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Storage::extend('cloudinary', function ($app, $config) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => $config['cloud_name'],
                    'api_key' => $config['api_key'],
                    'api_secret' => $config['api_secret'],
                ],
                'url' => [
                    'secure' => true
                ]
            ]);

            $adapter = new \App\Support\CloudinaryAdapter($cloudinary);
            
            return new Filesystem($adapter, ['url' => $config['url']]);
        });
    }
}
