<?php

use App\Helpers\CloudinaryHelper;

if (!function_exists('image_url')) {
    /**
     * Get image URL - uses Cloudinary in production, local storage in development
     */
    function image_url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // Check if it's already a full URL (Cloudinary)
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Check if it's a Cloudinary public_id (doesn't start with storage/)
        if (config('app.env') === 'production' && 
            config('filesystems.disks.cloudinary.cloud_name') &&
            !str_starts_with($path, 'storage/') &&
            !str_starts_with($path, 'products/') &&
            !str_starts_with($path, 'attractions/') &&
            !str_starts_with($path, 'business/')) {
            try {
                return CloudinaryHelper::url($path);
            } catch (\Exception $e) {
                // Fall back to storage URL
            }
        }

        // Use Laravel Storage for local paths
        return Storage::url($path);
    }
}
