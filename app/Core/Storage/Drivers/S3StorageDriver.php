<?php

namespace App\Core\Storage\Drivers;

use App\Core\Storage\Interfaces\StorageDriverInterface;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3StorageDriver implements StorageDriverInterface
{
    protected S3Client $client;
    protected string $bucket;
    protected ?string $url;


    public function __construct(array $config)
    {
        $this->client = new S3Client([
            'version'     => 'latest',
            'region'      => $config['region'],
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'],
            ],
            'endpoint'    => $config['endpoint'] ?? null,
            'use_path_style_endpoint' => $config['use_path_style_endpoint'] ?? false,
        ]);
    }

    public function get(string $path): ?string
    {
        try {
            $result = $this->client->getObject([
                'Bucket' => $this->bucket,
                'Key' => $path
            ]);

            return (string) $result['Body'];
        }catch (S3Exception $e) {
            return null;
        }
    }

    public function put(string $path, mixed $contents, array $options = []): bool
    {
        try {
            $this->client->putObject([
                'Bucket' => $this->bucket,
                'path' => $path,
                'body' => $contents,
                'ACL'    => $options['acl'] ?? 'private',
            ]);
            return true;
        }catch (S3Exception $e){
            return false;
        }
    }

    public function delete(string $path): bool
    {
        try {
            $this->client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $path,
            ]);
            return true;
        }catch (S3Exception $e){
            return false;
        }
    }

    public function exists(string $path): bool
    {
        return $this->client->doesObjectExist($this->bucket, $path);
    }

    public function download(string $path, string $localPath): mixed
    {
        try {
            $this->client->getObject([
                'Bucket' => $this->bucket,
                'Key'    => $path,
                'SaveAs' => $localPath,
            ]);
            return true;
        } catch (S3Exception $e) {
            return false;
        }
    }
}
