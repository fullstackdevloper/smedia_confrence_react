@extends('layouts.app')

@section('content')
<!-- <?php

// echo "<pre>";
// print_r($User);
// die();

?> -->



<div class="media">
  <div class="media-left media-middle">
      <img class="media-object" src="<?php echo url("profile_images/".App\Models\UserMeta::getUserMeta($User->id, 'profile_image')); ?>" style="max-width:500px;" alt="...">
  </div>
  <div class="media-body">
    <h4 class="media-heading"><?php echo App\Models\UserMeta::getUserMeta($User->id, 'title');?></h4>
    <span>{{$User->name}}</span>
    <p><?php echo App\Models\UserMeta::getUserMeta($User->id, 'bio'); ?></p>   
  </div>
</div>
@endsection