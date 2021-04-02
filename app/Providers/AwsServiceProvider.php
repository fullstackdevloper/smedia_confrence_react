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
    private $aws_key;
    private $aws_secret;
    
      public function __construct() {
        $this->aws_key = env('AWS_ACCESS_KEY_ID');
        $this->aws_secret = env('AWS_SECRET_ACCESS_KEY');
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
                'key'    => $this->aws_key,
                'secret' => $this->aws_secret,
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


    public function viewImage($guid)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'scheme' =>'https',
            'credentials' => [
                'key'    => $this->aws_key,
                'secret' => $this->aws_secret,
            ],
        ]);

        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'smedia-callapp',
            'Key'    => $guid
        ]);

//The period of availability
        $request = $s3->createPresignedRequest($cmd, '+10 minutes');
        $signedUrl = (string) $request->getUri();

        return $signedUrl;
    }


}
