<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <div class="last-login">Last login : <br>
        {{ Auth::user()->updated_at->format('d-m-Y H:i:s') }}</div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline">Welcome, {{Auth::user()->name}}</span>
                <img class="img-profile rounded-circle" src="{{ asset('public/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                {{-- <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log --}}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

</nav>
@php
$current_route = Route::currentRouteName();

$submenu=App\Models\SubMenu::all();
use App\Helpers\HelperService;
$value='List';
$breadcrumbs = HelperService::generateBreadcrumbs();
$title = HelperService::generateTitle();

@endphp

<!-- Content Header (Page header) -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex align-items-center justify-content-between">
                <h4>
                    @if($title!='Home')
                    {{ $title }}
                    @endif
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if($value == 'Dashboard')
                        <li class="breadcrumb-item">Dashboard</li>
                        @else
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        @endif
                        @if($value != 'Dashboard')
                        @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                        </li>
                        @endforeach
                        
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Success Message --}}
        <div class="col-lg-12">
            @if (session('success'))
            <div class="alert alert-success">
                <p class="m-0"><i class="fa fa-check"></i> {{ session('success') }}</p>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">
            <p class="text text-danger err-msg"> {{ session('error') }}</p>
            </div>
            @endif
        </div>
    </div> 
   
    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @if($current_route=='planType.index')
        <a href="{{ route('planType.create') }}"><i class="fa fa-plus"></i> Add Plan Type</a>
        @elseif($current_route=='planPrice.index')
        <a href="{{ route('planPrice.create') }}"><i class="fa fa-plus"></i> Add Plan Price</a>
        @elseif($current_route=='seats')
        <a href="{{ route('seats.create') }}"><i class="fa fa-plus"></i> Add seats</a>
        @elseif($current_route=='plan.index')
        <a href="{{ route('plan.create') }}"><i class="fa fa-plus"></i> Add Plan Name</a> 
        @endif
    </div> -->
</div>

<!-- End of Topbar -->
