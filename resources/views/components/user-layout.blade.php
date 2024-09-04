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

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand bg-primary topbar mb-4 static-top shadow">
                    <div class="container">

                    <!-- Topbar - Brand -->
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="bi bi-basket2 text-white"></i>
                        </div>
                        <div class="brand-text mx-3 text-white" style="font-weight: bold">e-comm</div>
                    </a>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                        action="/" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2" name="search" autocomplete="off" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit">
                                    <i class="fas fa-search fa-sm text-white"></i>
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
                                                <i class="fas fa-search fa-sm text-white" ></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        {{-- Chat icon --}}
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="{{ route('chat.list') }}">
                                <i class="bi bi-chat-fill text-white"></i>                               
                                <!-- Counter - chat -->
                                @role('customer')
                                    <span class="badge badge-danger badge-counter" id="chat-badge">{{ count(Auth::user()->chats) }}</span>
                                @endrole
                                @role('seller')
                                    <span class="badge badge-danger badge-counter" id="chat-badge">{{ count(Auth::user()->business->chats) }}</span>
                                @endrole
                            </a>
                        </li>

                        <!-- Nav Item - Cart -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="{{ route('cart.view') }}" id="cartDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-cart-fill text-white"></i>                                
                                <!-- Counter - Cart -->
                                <span class="badge badge-danger badge-counter" id="cart-badge">{{ count(Auth()->user()->carts) }}</span>
                            </a>
                            <!-- Dropdown - Cart -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="cartDropdown">
                                <h6 class="dropdown-header">
                                    Cart
                                </h6>
                                @if(count(Auth()->user()->carts) > 0)
                                    @foreach(Auth()->user()->carts as $cart)
                                        <a class="dropdown-item d-flex align-items-center cart-product-{{ $cart->id }}" href="{{ route('cart.view') }}">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-primary">
                                                    @if($cart->product->image)
                                                        <img class="img-profile rounded-circle" src="{{ asset(env('PRODUCT_PICTURE_PATH') . $cart->product->image) }}" alt="{{ $cart->product->name }} image" width="50">
                                                    @else
                                                        <img class="img-profile rounded-circle" src="{{ asset(env('PRODUCT_PICTURE_PATH') . 'default.jpg') }}" alt="{{ $cart->product->name }} image" width="50">
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{ $cart->product->business->name }} - {{ $cart->product->name }}</div>
                                                Rp. {{ formatNumber(calculateDiscount($cart->product) * $cart->quantity) }}
                                                <br>
                                                <div id="alert-quantity-{{ $cart->id }}">Quantity : {{ $cart->quantity }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('cart.view') }}">
                                        <div>
                                            <span class="font-weight-bold">No Items In Cart</span>
                                        </div>
                                    </a>
                                    
                                @endif
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('cart.view') }}">View Cart</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white small">{{ Auth()->user()->username }}</span>
                                @if( Auth()->user()->profile_picture )
                                    <img class="img-profile rounded-circle" src="{{ asset(env('PROFILE_PICTURE_PATH') . Auth()->user()->profile_picture ) }}" alt="Profile Picture">
                                @else 
                                    <img class="img-profile rounded-circle" src="{{ asset(env('PROFILE_PICTURE_PATH') . 'default.jpg') }}" alt="Default profile picture">
                                @endif
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('view-profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                {{-- Transaction --}}
                                <a class="dropdown-item" href="{{ route('transaction.view') }}">
                                    <i class="bi bi-card-checklist mr-2 text-gray-400"></i></i>
                                    Transaction List
                                </a>
                                @role('customer')
                                <a class="dropdown-item" href="{{ route('apply-seller') }}">
                                    <i class="bi bi-shop mr-2 text-gray-400"></i>
                                    Apply Seller
                                </a>
                                @endrole
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
                </div>
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
            {{-- <footer class="sticky-footer bg-white">
                <div class="container my-3">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer> --}}
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