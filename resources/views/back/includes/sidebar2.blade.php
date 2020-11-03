<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      {{-- <img src="{{asset('admin/images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">eChapaa</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin/images/logo.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @auth
          <li class="nav-item has-treeview {{Route::currentRouteName()=='listleads' ? 'menu-open':'' }}">
            <a href="#" class="nav-link {{Route::currentRouteName()=='listleads' ? 'active':'' }}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Leads
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('listleads')}}" class="nav-link {{Route::currentRouteName()=='listleads' ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lead list</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('adminlogout')}}" class="nav-link">
              
               <i class="far fa-circle nav-icon"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          @endauth
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>