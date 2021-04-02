@extends('layouts.app')

@section('content')




<div class="row"> 
@foreach($expertAll as $expertkey => $expertvalue)

<?php 
$imageView = new App\Providers\AwsServiceProvider();
$guidData = $expertvalue->guid;
$imageUrl = $imageView->viewImage($guidData);
?>

  <div class="media col-md-12">
    <div class="media-left media-middle">
        <a href="{{url('expert/view')}}/{{ $expertvalue->id }}" style="padding:0 10px;">
          <img class="media-object" src="<?php echo $imageUrl ?>" style="max-width:200px;" alt="...">
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
