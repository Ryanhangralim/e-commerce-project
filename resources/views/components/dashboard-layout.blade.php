<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Custom title for every page --}}
    <title>{{ $title ?? 'Dashboard' }}</title>

    @include('includes.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="bi bi-basket2 text-white"></i>
                </div>
                <div class="brand-text mx-3 text-white" style="font-weight: bold">e-comm</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            @role('admin')
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin-dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            @endrole
            @role('seller')
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('seller-dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            @endrole

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Tools
            </div>

            @role('admin')
            <!-- Nav Item - User Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                    aria-expanded="true" aria-controls="collapseUser">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User</span>
                </a>
                <div id="collapseUser" class="collapse" aria-labelledby="headingUser"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">User Utilities:</h6>
                        <a class="collapse-item" href="{{ route('dashboard.user') }}">User List</a>
                        <a class="collapse-item" href="{{ route('dashboard.seller-application') }}">Seller Application</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - User Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('dashboard.business') }}">
                    <i class="fa fa-building"></i>
                    <span>Business</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('dashboard.view-category') }}">
                    <i class="bi bi-tags"></i>
                    <span>Category</span>
                </a>
            </li>
            @endrole

            @role('seller')
                <!-- Nav Item - User Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('view-product') }}">
                        <i class="fa fa-store"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('transaction-dashboard.view') }}">
                        <i class="bi bi-card-checklist"></i>
                        <span>Transactions</span>
                    </a>
                </li>
            @endrole

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth()->user()->username }}</span>
                                @if( Auth()->user()->profile_picture )
                                    <img class="img-profile rounded-circle" src="{{ asset(env('PROFILE_PICTURE_PATH') . Auth()->user()->profile_picture ) }}" alt="Profile Picture">
                                @else 
                                    <img class="img-profile rounded-circle" src="{{ asset(env('PROFILE_PICTURE_PATH') . '/default.jpg') }}" alt="Default profile picture">
                                @endif
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('view-profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                @role('admin')
                                <a class="dropdown-item" href="{{ route('admin-dashboard') }}">
                                    <i class="fas fa-fw fa-tachometer-alt mr-2 text-gray-400"></i>
                                    Dashboard
                                </a>
                                @endrole
                                @role('seller')
                                <a class="dropdown-item" href="{{ route('seller-dashboard') }}">
                                    <i class="fas fa-fw fa-tachometer-alt mr-2 text-gray-400"></i>
                                    Dashboard
                                </a>
                                <a class="dropdown-item" href="{{ route('business-profile.view') }}">
                                    <i class="bi bi-shop mr-2 text-gray-400"></i>
                                    Business Profile
                                </a>
                                @endrole
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    {{ $slot }}

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('includes.script')
</body>

</html>