<!-- Sidebar -->
<ul class="navbar-nav bg-custom-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    @php
    $current_route = Route::currentRouteName();
    $menu = App\Models\Menu::where('name', '!=', 'Dashboard')->get();
    $submenu = App\Models\SubMenu::where('name', '!=', 'Dashboard')->get();
    $i = 1;
    @endphp
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text sideBar_logo mx-3">
            <img src="{{ asset('public/img/logo.png') }}" class="full_img" alt="logo" />
            <img src="{{ asset('public/img/logo-fav.png') }}" class="fav_img" alt="logo" />
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $current_route == 'home' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @foreach($menu as $key => $value)
        @php
            $is_active_menu = false;
        @endphp
        <li class="nav-item">
            <a class="nav-link collapsed {{ $submenu->where('parent_id', $value->id)->pluck('url')->contains($current_route) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseManageMasters{{$i}}" aria-expanded="true" aria-controls="collapseManageMasters">
                <i class="fa fa-fw fa-cog"></i>
                <span>{{$value->name}}</span>
            </a>
            <div id="collapseManageMasters{{$i}}" class="collapse {{ $submenu->where('parent_id', $value->id)->pluck('url')->contains($current_route) ? 'show' : '' }}" aria-labelledby="headingManageMasters" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @foreach($submenu as $subvalue)
                        @if($value->id == $subvalue->parent_id)
                            <a href="{{ route($subvalue->url) }}" class="collapse-item {{ $current_route == $subvalue->url ? 'active' : '' }}">{{$subvalue->name}}</a>
                            @php
                                if ($current_route == $subvalue->url) {
                                    $is_active_menu = true;
                                }
                            @endphp
                        @endif
                    @endforeach
                </div>
            </div>
        </li>
        @php
            $i++;
        @endphp
    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
