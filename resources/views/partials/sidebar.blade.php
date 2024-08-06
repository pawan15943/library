@php
$current_route = Route::currentRouteName();
$menu = App\Models\Menu::orderBy('order','ASC')->get();
$submenu = App\Models\SubMenu::orderBy('order','ASC')->get();
$i = 1;
@endphp

<!-- Sidebar -->
<ul class="navbar-nav bg-custom-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text sideBar_logo mx-3">
           <div class="logo">
            <h1 class="d-none d-lg-block">Library<span>Pro</span></h1>
            <h1 class="d-block d-lg-none">LIB</h1>
           </div>
        </div>
    </a>

  
    @foreach($menu as $key => $value)
    @php
    $is_active_menu = false;
    @endphp
    @if($value->name=='Dashboard')

    <li class="nav-item {{ $current_route == $value->url ? 'active' : '' }}">
        <a class="nav-link" href="{{ route($value->url) }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{$value->name}}</span>
        </a>
    </li>

    @else
    <li class="nav-item {{ $submenu->where('parent_id', $value->id)->pluck('url')->contains($current_route) ? 'bg-active' : '' }}">
        <a class="nav-link collapsed {{ $submenu->where('parent_id', $value->id)->pluck('url')->contains($current_route) ? $value->url : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseManageMasters{{$i}}" aria-expanded="true" aria-controls="collapseManageMasters">
            <i class="{{$value->icon}}"></i>
            <span>{{$value->name}}</span>
        </a>
        <div id="collapseManageMasters{{$i}}" class="collapse {{ $submenu->where('parent_id', $value->id)->pluck('url')->contains($current_route) ? 'show' : '' }}" aria-labelledby="headingManageMasters" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @foreach($submenu as $subvalue)
                @if($value->id == $subvalue->parent_id)
                <a href="{{ route($subvalue->url) }}" class="collapse-item {{ $current_route == $subvalue->url ? 'active' : '' }}"><i class="{{$subvalue->icon}}"></i> {{$subvalue->name}}</a>
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
    @endif
    @php
    $i++;
    @endphp
    @endforeach

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->