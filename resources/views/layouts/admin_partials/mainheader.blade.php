<!-- Main Header -->
<header class="main-header">
	<!-- Logo -->
	<a href="{{ url('/admin') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{Config::getByKey('site_name')}}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{Config::getByKey('site_name')}}</b>
            </span>
	</a>
	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle b-l" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
            </a>
            @include('layouts.admin_partials.notifs')
	</nav>
</header>
