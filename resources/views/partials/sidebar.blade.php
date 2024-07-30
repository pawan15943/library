<!-- Sidebar -->
<ul class="navbar-nav bg-custom-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    @php
    $current_route = Route::currentRouteName();
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
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Manage Students -->
    <li class="nav-item @if ($current_route == 'student.index') @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManageStudents" aria-expanded="true" aria-controls="collapseManageStudents">
            <i class="fa fa-fw fa-user-graduate"></i>
            <span>Manage Students</span>
        </a>
        <div id="collapseManageStudents" class="collapse" aria-labelledby="headingManageStudents" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="{{ route('student.index') }}" class="collapse-item @if ($current_route == 'student.index') active @endif">
                    Student List
                </a>
                <a href="{{ route('admin.accounts') }}" class="collapse-item @if ($current_route == 'admin.accounts') active @endif">
                    Payment List
                </a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Manage Seats -->
    <li class="nav-item @if ($current_route == 'seats') @endif">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManageSeats" aria-expanded="true" aria-controls="collapseManageSeats">
            <i class="fa fa-fw fa-chair"></i>
            <span>Manage Seats</span>
        </a>
        <div id="collapseManageSeats" class="collapse" aria-labelledby="headingManageSeats" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="{{ route('seats') }}" class="collapse-item @if ($current_route == 'seats') active @endif">
                    Library Sitting
                </a>
                <a href="{{ route('customers.list') }}" class="collapse-item @if ($current_route == 'customers.list') active @endif">
                    Users Allotment
                </a>
                <a href="{{ route('history.seat.list') }}" class="collapse-item @if ($current_route == 'history.seat.list') active @endif">
                    Seat Booking History
                </a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Manage Masters -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManageMasters" aria-expanded="true" aria-controls="collapseManageMasters">
            <i class="fa fa-fw fa-cog"></i>
            <span>Manage Masters</span>
        </a>
        <div id="collapseManageMasters" class="collapse" aria-labelledby="headingManageMasters" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a href="{{ route('plan.create') }}" class="collapse-item @if ($current_route == 'plan.create') active @endif">
                    Manage Plans
                </a>
                <a href="{{ route('planType.create') }}" class="collapse-item @if ($current_route == 'planType.create') active @endif">
                    Manage Plans Type
                </a>
                <a href="{{ route('planPrice.create') }}" class="collapse-item @if ($current_route == 'planPrice.create') active @endif">
                    Manage Plans Price
                </a>
                <a href="{{ route('state') }}" class="collapse-item @if ($current_route == 'state') active @endif">State Master</a>
                <a href="{{ route('city') }}" class="collapse-item @if ($current_route == 'city') active @endif">City Master</a>
                <a href="{{ route('course') }}" class="collapse-item @if ($current_route == 'course') active @endif">Course Master</a>
                <a href="{{ route('class') }}" class="collapse-item @if ($current_route == 'class') active @endif">Class Master</a>
                <a href="{{ route('courseType') }}" class="collapse-item @if ($current_route == 'courseType') active @endif">Course Type Master</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
