<?php

namespace App\Support;

use Cloudinary\Cloudinary;
use League\Flysystem\Config;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToWriteFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToDeleteFile;

class CloudinaryAdapter implements FilesystemAdapter
{
    protected $cloudinary;

    public function __construct(Cloudinary $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    public function fileExists(string $path): bool
    {
        try {
            $this->cloudinary->adminApi()->asset($path);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function directoryExists(string $path): bool
    {
        return false;
    }

    public function write(string $path, string $contents, Config $config): void
    {
        try {
            $stream = fopen('php://temp', 'r+');
            fwrite($stream, $contents);
            rewind($stream);
            
            $this->writeStream($path, $stream, $config);
            
            if (is_resource($stream)) {
                fclose($stream);
            }
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage());
        }
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        try {
            $resource = $contents;
            
            if (!is_resource($resource)) {
                throw new \InvalidArgumentException('Contents must be a resource');
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'cloudinary');
            file_put_contents($tempFile, stream_get_contents($resource));

            $result = $this->cloudinary->uploadApi()->upload($tempFile, [
                'public_id' => $path,
                'resource_type' => 'auto',
                'folder' => dirname($path) !== '.' ? dirname($path) : null,
            ]);

            unlink($tempFile);
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($path, $e->getMessage());
        }
    }

    public function read(string $path): string
    {
        try {
            $url = $this->cloudinary->image($path)->toUrl();
            $contents = file_get_contents($url);
            
            if ($contents === false) {
                throw new \Exception('Unable to read file');
            }
            
            return $contents;
        } catch (\Exception $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage());
        }
    }

    public function readStream(string $path)
    {
        try {
            $url = $this->cloudinary->image($path)->toUrl();
            $stream = fopen($url, 'r');
            
            if ($stream === false) {
                throw new \Exception('Unable to read file stream');
            }
            
            return $stream;
        } catch (\Exception $e) {
            throw UnableToReadFile::fromLocation($path, $e->getMessage());
        }
    }

    public function delete(string $path): void
    {
        try {
            $this->cloudinary->uploadApi()->destroy($path);
        } catch (\Exception $e) {
            throw UnableToDeleteFile::atLocation($path, $e->getMessage());
        }
    }

    public function deleteDirectory(string $path): void
    {
        try {
            $this->cloudinary->adminApi()->deleteFolder($path);
        } catch (\Exception $e) {
            // Silently fail for directory deletion
        }
    }

    public function createDirectory(string $path, Config $config): void
    {
        // Cloudinary doesn't require explicit directory creation
    }

    public function setVisibility(string $path, string $visibility): void
    {
        // Cloudinary handles visibility automatically
    }

    public function visibility(string $path): array
    {
        return ['visibility' => 'public'];
    }

    public function mimeType(string $path): array
    {
        try {
            $resource = $this->cloudinary->adminApi()->asset($path);
            return ['mime_type' => $resource['resource_type'] ?? 'application/octet-stream'];
        } catch (\Exception $e) {
            return ['mime_type' => 'application/octet-stream'];
        }
    }

    public function lastModified(string $path): array
    {
        try {
            $resource = $this->cloudinary->adminApi()->asset($path);
            $timestamp = strtotime($resource['created_at'] ?? 'now');
            return ['last_modified' => $timestamp];
        } catch (\Exception $e) {
            return ['last_modified' => time()];
        }
    }

    public function fileSize(string $path): array
    {
        try {
            $resource = $this->cloudinary->adminApi()->asset($path);
            return ['file_size' => $resource['bytes'] ?? 0];
        } catch (\Exception $e) {
            return ['file_size' => 0];
        }
    }

    public function listContents(string $path, bool $deep): iterable
    {
        return [];
    }

    public function move(string $source, string $destination, Config $config): void
    {
        try {
            $this->copy($source, $destination, $config);
            $this->delete($source);
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($destination, $e->getMessage());
        }
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        try {
            $contents = $this->read($source);
            $this->write($destination, $contents, $config);
        } catch (\Exception $e) {
            throw UnableToWriteFile::atLocation($destination, $e->getMessage());
        }
    }

    public function publicUrl(string $path, Config $config): string
    {
        return $this->cloudinary->image($path)->toUrl();
    }
}
