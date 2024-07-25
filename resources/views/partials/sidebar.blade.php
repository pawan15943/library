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

     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item @if ($current_route == 'seats') @endif">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fa fa-fw fa-chair"></i>
             <span>Manage Seats</span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
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


     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManageMasters" aria-expanded="true" aria-controls="collapseManageMasters">
             <i class="fa fa-fw fa-cog"></i>
             <span>Manage Masters</span>
         </a>
         <div id="collapseManageMasters" class="collapse" aria-labelledby="headingManageMasters" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a href="{{ route('plan.index') }}" class="collapse-item @if ($current_route == 'plan.index') active @endif">
                     Manage Plans
                 </a>
                 <a href="{{ route('planType.index') }}" class="collapse-item @if ($current_route == 'planType.index') active @endif">
                     Manage Plans Type
                 </a>
                 <a href="{{ route('planPrice.index') }}" class="collapse-item @if ($current_route == 'planPrice.index') active @endif">
                     Manage Plans Price
                 </a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Tables -->

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

 </ul>
 <!-- End of Sidebar -->