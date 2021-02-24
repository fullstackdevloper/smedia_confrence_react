<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
	        <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Request::segment(2) === 'dashboard' || Request::segment(2) === null ? 'active' : null }}">
                <a href="{{ url('/admin/dashboard') }}"><i class='fa fa-home'></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::segment(2) === 'users' ? 'active' : null }}">
                <a href="{{ url('/admin/users') }}"><i class="fa fa-group"></i> <span>Users</span> </a>
            </li>
            <li class="{{ Request::segment(2) === 'meetings' ? 'active' : null }}">
                <a href="{{ url('/admin/meetings') }}"><i class="fa fa-calendar"></i> <span>Meetings</span> </a>
            </li>
            
            <li class="treeview {{ Request::segment(2) === 'settings' ? 'active' : null }}">
                <a href="http://localhost/smedia_video_confrencing/public/admin/employees">
                    <i class="fa fa-cogs"></i> <span>Configurations</span> 
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ Request::segment(2) === 'settings' ? 'menu-open' : null }}">
                    <li class="{{ Request::segment(2) === 'settings' && Request::segment(3) === null ? 'active' : null }}">
                        <a href="{{ url('/admin/settings') }}"><i class='fa fa-cog'></i> <span>General</span></a>
                    </li>
                    <li class="{{ Request::segment(3) === 'apisettings' ? 'active' : null }}">
                        <a href="{{ url('/admin/settings/apisettings') }}"><i class='fa fa-cog'></i> <span>API Settings</span></a>
                    </li>
                </ul>
            </li>
            <!-- LAMenus -->
            
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
