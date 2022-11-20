<?php

namespace App\Providers;

use Aws\S3\S3Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        File::macro('streamUpload', function($path, $fileName, $file, $overWrite = true) {

            // Set up S3 connection.
            $resource = fopen($file->getRealPath(), 'r+');
            $config = Config::get('filesystems.disks.s3');
            $client = new S3Client([
                'credentials' => [
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                ],
                'region' => $config['region'],
                'version' => 'latest',
            ]);

            $adapter = new AwsS3Adapter($client, $config['bucket'], $path);
            $filesystem = new Filesystem($adapter);

            return $overWrite
                    ? $filesystem->putStream($fileName, $resource)
                    : $filesystem->writeStream($fileName, $resource);
        });

        File::macro('streamDownload', function($path, $fileName) {
            $config = Config::get('filesystems.disks.s3');
            $client = new S3Client([
                'credentials' => [
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                ],
                'region' => $config['region'],
                'version' => 'latest',
            ]);

            $adapter = new AwsS3Adapter($client, $config['bucket'], $path);
            $disk = Storage::disk('s3');
            $fileName = utf8_encode($fileName);
            // $fileName = "some.zip";
            if ($disk->exists($path)) {
                $command = $adapter->getClient()->getCommand('GetObject', [
                    'Bucket'                     => $config['bucket'],
                    'Key'                        => $path,
                    // 'ResponseContentDisposition' => 'attachment; filename="'.$fileName.'"; filename*="UTF-8'.$filename_utf8_url_encoded.'"'
                    'ResponseContentDisposition' => 'attachment; filename="'.$fileName.'";'
                ]);
                $request = $adapter->getClient()->createPresignedRequest($command, '+30 minutes');
                return (string) $request->getUri();
            }
            return $path;
        });
    }
}
