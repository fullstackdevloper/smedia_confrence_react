@extends('layouts.app')

@section('content')
<section id="home" name="home"></section>
<div id="headerwrap">
    <div class="container">
        <div class="row text-center text-white">
            <div class="col-lg-12">
                <h1><b><a>Smedia</a></b></h1>
                <h3>A video conference application</h3>
                <h3><a href="{{ url('/login') }}" class="btn btn-lg btn-success">Get Started!</a></h3><br>
            </div>
        </div>
    </div> <!--/ .container -->
</div><!--/ #headerwrap -->


<section id="about" name="about"></section>
<!-- INTRO WRAP -->
<div id="intro">
    <div class="container">
        <div class="row text-center">
            <h1 class="col-md-12 py-5">Now video conference and scheduling is easy</h1>
            <br>
            <br>
            <div class="col-lg-12">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
        </div>
        <br>
        <hr>
    </div> <!--/ .container -->
</div><!--/ #introwrap -->
@endsection
