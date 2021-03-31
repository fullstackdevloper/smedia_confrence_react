<!-- Content Header (Page header) -->
<section class="content-header d-flex">
    <h1 class="col-md-2">
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description')</small>
    </h1>
    <div class="col-md-8">
        @include('layouts.partials.alerts')
    </div>
    @hasSection('headerElems')
        <span class="headerElems col-md-2">
        @yield('headerElems')
        </span>
    @else 
        @hasSection('section')
        <ol class="breadcrumb">
            <li><a href="@yield('section_url')"><i class="fa fa-dashboard"></i> @yield('section')</a></li>
            @hasSection('sub_section')<li class="active"> @yield('sub_section') </li>@endif
        </ol>
        @endif
    @endif
</section>