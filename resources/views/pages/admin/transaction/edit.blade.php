@extends('layout.admin')

@section('content')

<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin6">
        <nav class="navbar top-navbar navbar-expand-md">
            <div class="navbar-header" data-logobg="skin6">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                        class="ti-menu ti-close"></i></a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-brand">
                    <!-- Logo icon -->
                    <a href="{{ route('dashboard')}}">
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="{{url('adm_dashboard/assets/images/big/logocv.png')}}" alt="homepage"
                                class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{url('adm_dashboard/assets/images/big/logocv.png')}}" alt="homepage"
                                class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        {{-- <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{url('adm_dashboard/assets/images/logo-text.png')}}" alt="homepage"
                        class="dark-logo" />
                        <!-- Light Logo text -->
                        <img src="{{url('adm_dashboard/assets/images/logo-light-text.png')}}" class="light-logo"
                            alt="homepage" />
                        </span> --}}
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                    data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right ">
                    <!-- ============================================================== -->
                    <!-- Search -->
                    <!-- ============================================================== -->
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link" href="javascript:void(0)">
                            <form>
                                <div class="customize-input">
                                    <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                        type="search" placeholder="Search" aria-label="Search">
                                    <i class="form-control-icon" data-feather="search"></i>
                                </div>
                            </form>
                        </a>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img src="{{url('adm_dashboard/assets/images/users/d1.jpg')}}" alt="user"
                                class="rounded-circle" width="40">
                            <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span class="text-dark">
                                    {{ Auth::user()->name }}
                                </span> <i data-feather="chevron-down" class="svg-icon"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">

                            <form action="{{ url('logout')}}" method="post">
                                @csrf
                                <button class="dropdown-item" type="submit"> <i data-feather="power"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Logout</button>
                            </form>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('dashboard')}}"
                            aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                class="hide-menu">Dashboard</span></a></li>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Applications</span></li>

                    <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('travel-package.index')}}"
                            aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                class="hide-menu">Paket Photo
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('gallery.index')}}"
                            aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                class="hide-menu">Gallery
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="{{ route('transaction.index')}}" aria-expanded="false"><i data-feather="calendar"
                                class="feather-icon"></i><span class="hide-menu">Transaksi</span></a></li>


                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->

    <!-- Page wrapper  -->
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Table Edit Data Transaksi
                    </h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item"><a href="{{ route('transaction.index')}}"
                                        class="text-muted">Home</a></li>
                                <li class="breadcrumb-item text-muted active" aria-current="page">Transaksi</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                    <strong>Error - {{ $error }}</strong>

                    @endforeach
                </ul>
            </div>
            @endif
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Transaksi</h4>

                            <form action="{{ route('transaction.update', $item->id)}}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="transaction_status" class="text-info">Transaksi</label>
                                    <select name="transaction_status" class="form-control">
                                        <option value="">{{$item->transaction_status}}
                                        </option>
                                        <option value="IN_CART">IN_CART</option>
                                        <option value="PENDING">PENDING</option>
                                        <option value="SUCCESS">SUCCESS</option>
                                        <option value="CANCEL">CANCEL</option>
                                        <option value="FAILED">FAILED</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-block btn-info">Update</button>

                            </form>
                        </div>
                    </div>
                    <!-- End Container fluid  -->
                    <!-- footer -->
                    <!-- ============================================================== -->
                    @include('includes.admin.footer')
                    <!-- ============================================================== -->
                    <!-- End footer -->
                </div>
            </div>
        </div>
    </div>
    @endsection
