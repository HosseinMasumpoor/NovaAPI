<?php

namespace App\Core\Storage\Interfaces;

interface StorageDriverInterface
{
    public function get(string $path) : ?string;
    public function put(string $path, mixed $contents, array $options = []) : bool;
    public function delete(string $path): bool;
    public function exists(string $path) : bool;
    public function download(string $path, string $localPath) : mixed;
}
