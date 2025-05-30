<?php

namespace App\Core\Storage\Drivers;

use App\Core\Storage\Interfaces\StorageDriverInterface;

class LocalStorageDriver implements StorageDriverInterface
{
    private string $rootPath;

    public function __construct(array $config)
    {
        $this->rootPath = $config['root'];
    }

    public function get(string $path): ?string
    {
        $fullPath = $this->rootPath . DIRECTORY_SEPARATOR . $path;
        if (file_exists($fullPath)) {
            return file_get_contents($fullPath);
        }
        return null;
    }

    public function put(string $path, mixed $contents, array $options = []): bool
    {
        $fullPath = $this->rootPath . DIRECTORY_SEPARATOR . $path;

        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if(is_resource($contents)) {
            $stream = fopen($fullPath, 'w');
            stream_copy_to_stream($contents, $stream);
            fclose($stream);
            return true;
        }

        return file_put_contents($fullPath, $contents);
    }

    public function delete(string $path): bool
    {
        $fullPath = $this->rootPath . DIRECTORY_SEPARATOR . $path;
        return file_exists($fullPath) && unlink($fullPath);
    }

    public function exists(string $path): bool
    {
        $fullPath = $this->rootPath . DIRECTORY_SEPARATOR . $path;
        return file_exists($fullPath);
    }

    public function download(string $path, string $localPath): mixed
    {
        // TODO
    }
}
