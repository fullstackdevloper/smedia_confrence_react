<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @section('htmlheader')
            @include('layouts.admin_partials.htmlheader')
    @show
    <body class="skin-blue sidebar-mini" bsurl="{{ url('') }}">
        <div class="wrapper">
            @include('layouts.admin_partials.mainheader')
            @include('layouts.admin_partials.sidebar')
            <div class="content-wrapper">
		<!--<div class="container"> -->
		@if(!isset($no_header))
			@include('layouts.admin_partials.contentheader')
		@endif
		
		<!-- Main content -->
		<section class="content">
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->

		<!--</div>-->
            </div><!-- /.content-wrapper -->
            @include('layouts.admin_partials.footer')
        </div>
    </body>    
    @stack('scripts')
</html>