@extends('layouts.app')

@section('content')




<div class="row"> 
@foreach($expertAll as $expertkey => $expertvalue)
<?php
$s3 = new  Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'scheme' =>'https',
            'credentials' => [
                'key'    => 'AKIAVWJGL2M5VR5XFJFY',
                'secret' => '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',
            ],
        ]);

$cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'smedia-callapp',
            'Key'    => $expertvalue->guid
        ]);

        //The period of availability
        $request = $s3->createPresignedRequest($cmd, '+10 minutes');
        $signedUrl = (string) $request->getUri();
?>
  <div class="media col-md-12">
    <div class="media-left media-middle">
        <a href="{{url('expert/view')}}/{{ $expertvalue->id }}" style="padding:0 10px;">
          <img class="media-object" src="<?php echo $signedUrl ?>" style="max-width:200px;" alt="...">
        </a>
    </div>
    <div class="media-body" style="padding:0 10px;">
     
      <h4 class="media-heading"></h4>
      <a href="{{url('expert/view')}}/{{ $expertvalue->id }}" style="padding:0 10px;">
          <h4 class="media-heading"><?php echo App\Models\UserMeta::getUserMeta($expertvalue->id, 'title'); ?></h4></a>
          <span>{{$expertvalue->name}}</span>
          <br>
          <span>Bio</span>
          <p><?php echo App\Models\UserMeta::getUserMeta($expertvalue->id, 'bio'); ?></p>           
      
    </div>
  </div>
@endforeach
</div>
@endsection
