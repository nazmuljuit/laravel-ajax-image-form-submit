<!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">

        <img src="{{ asset('images/1637560976DLWluZ7.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

        ShampanIT
    </a>

<!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(isset(auth()->user()->image) && !empty(auth()->user()->image))
                    <img src="{{ asset('images/'.auth()->user()->image)}}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ asset('img/avatar-1577909_1280.png')}}" class="img-circle elevation-2" alt="User Image">
                @endif



            </div>
            <div class="info">

                <a href="#" class="d-block">{{auth()->user()->name}}</a>

            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'aregister.list' ? 'active' : '' }}">
                    <a href="{{ route('aregister.list') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Registration List</p>
                    </a>
                </li>

                <li class="nav-item {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'admin.list' ? 'active' : '' }}">
                    <a href="{{ route('admin.list') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Admin List</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
