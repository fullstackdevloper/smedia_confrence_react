<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Aws\S3\S3Client;

class AwsServiceProvider extends ServiceProvider
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
    public function upload($UserGuid, $profileImage)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'scheme' =>'https',
            'credentials' => [
                'key'    => 'AKIAVWJGL2M5VR5XFJFY',
                'secret' => '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',
            ],
        ]);

        try {
            $file = $s3->putObject([
                'Bucket' => 'smedia-callapp',
                'Key'    => $UserGuid,
                'Body'   => fopen($profileImage, 'r'),
                'ACL'    => 'private',
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
    }


}
