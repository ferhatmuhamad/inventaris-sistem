<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    {{-- <img alt="image" class="rounded-circle" src="{{asset("/assets/img/profile_small.jpg")}}"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">Ferhat Muhamad</span>
                        <span class="text-muted text-xs block">ferhatmuhamad221@gmail.com</span>
                    </a> --}}
                    <!-- Sidebar - Brand -->
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/')}}">
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fa fa-user-circle fa-2x"></i>
                        </div>
                        <div class="sidebar-brand-text mx-3">
                            <strong>{{ Auth::user()->nama }}</strong>
                            <br>
                            {{ Auth::user()->role }}
                        </div>
                    </a>
                </div>
            </li>
            {{-- DASHBOARD --}}
            <li class="
            {{ Request::path() === '/' ? 'active' : '' }}
            {{ Request::path() === 'profile/'. Auth::user()->id ? 'active' : '' }}
            {{ Request::path() === 'alluser' ? 'active' : '' }}
            {{ Request::path() === 'grafik' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-tachometer"></i> <span class="nav-label">Admin Panel</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li class="{{ Request::path() === '/' ? 'active' : '' }}"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  <li class="{{ Request::path() === 'profile/'. Auth::user()->id ? 'active' : '' }}"><a href="{{ route('profile', Auth::user()->id) }}">Profile User</a></li>
                  @if (Auth::user()->can('read-all-profile'))
                  <li class="{{ Request::path() === 'alluser' ? 'active' : '' }}"><a href="{{ route('alluser') }}">Data User</a></li>
                  @endif
                  <li class="{{ Request::path() === 'grafik' ? 'active' : '' }}"><a href="{{ route('graph') }}">Data Grafik</a></li>
              </ul>
            </li>
            {{-- PERIODE --}}
            <li class="
            {{ Request::path() === 'periode' ? 'active' : '' }}
            {{-- {{ Request::path() === 'profile' ? 'active' : '' }} --}}
            {{ Request::path() === 'month' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-calendar"></i> <span class="nav-label">Periode Sales</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li class="{{ Request::path() === 'periode' ? 'active' : '' }}"><a href="{{ route('periode') }}">Periode Tahun</a></li>
                  <li class="{{ Request::path() === 'month' ? 'active' : '' }}"><a href="{{ route('month') }}">Periode Bulan</a></li>
              </ul>
            </li>
            {{-- STOCK --}}
            <li class="
            {{ Request::path() === 'stockreport' ? 'active' : '' }}
            {{ Request::path() === 'stockopname' ? 'active' : '' }}
            {{ Request::path() === 'stockin' ? 'active' : '' }}
            {{ Request::path() === 'stockout' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Manajemen Stok</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li class="{{ Request::path() === 'stockreport' ? 'active' : '' }}"><a href="{{ route('stockreport') }}">Laporan Stok</a></li>
                  <li class="{{ Request::path() === 'stockopname' ? 'active' : '' }}"><a href="{{ route('stockopname') }}">Stock Opname</a></li>
                  <li class="{{ Request::path() === 'stockin' ? 'active' : '' }}"><a href="{{ route('stockin') }}">Stock Masuk</a></li>
                  <li class="{{ Request::path() === 'stockout' ? 'active' : '' }}"><a href="{{ route('stockout') }}">Stock Keluar</a></li>
              </ul>
            </li>
            {{-- PRODUCT --}}
            <li class="
            {{ Request::path() === 'products' ? 'active' : '' }}
            {{ Request::path() === 'products/create' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Data Produk</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li class="{{ Request::path() === 'products' ? 'active' : '' }}"><a href="{{ route('products') }}">List Produk</a></li>
                  @if (Auth::user()->can('create-product'))
                  <li class="{{ Request::path() === 'products/create' ? 'active' : '' }}"><a href="{{ route('products.create') }}">Tambah Produk</a></li>
                  @endif
              </ul>
            </li>
            {{-- CATEGORY --}}
            <li class="
            {{ Request::path() === 'productcategory' ? 'active' : '' }}
            {{ Request::path() === 'productcategory/create' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Data Kategori Produk</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li class="{{ Request::path() === 'productcategory' ? 'active' : '' }}"><a href="{{ route('productcategory') }}">List Kategori</a></li>
                  @if (Auth::user()->can('create-product'))
                  <li class="{{ Request::path() === 'productcategory/create' ? 'active' : '' }}"><a href="{{ route('productcategory.create') }}">Tambah Kategori</a></li>
                  @endif
              </ul>
            </li>
            {{-- SUPPLIER --}}
            <li class="
            {{ Request::path() === 'suppliers' ? 'active' : '' }}
            {{ Request::path() === 'suppliers/create' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-industry""></i> <span class="nav-label">Data Supplier</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li class="{{ Request::path() === 'suppliers' ? 'active' : '' }}"><a href="{{ route('suppliers') }}">List Supplier</a></li>
                @if (Auth::user()->can('create-product-category'))
                <li class="{{ Request::path() === 'suppliers/create' ? 'active' : '' }}"><a href="{{ route('suppliers.create') }}">Tambah Supplier</a></li>
                @endif
              </ul>
            </li>
            {{-- GUDANG --}}
            <li class="
            {{ Request::path() === 'warehouses' ? 'active' : '' }}
            {{ Request::path() === 'warehouses/create' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-home"></i> <span class="nav-label">Data Gudang</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li class="{{ Request::path() === 'warehouses' ? 'active' : '' }}"><a href="{{ route('warehouses') }}">List Gudang</a></li>
                @if (Auth::user()->can('create-warehouse'))
                <li class="{{ Request::path() === 'warehouses/create' ? 'active' : '' }}"><a href="{{ route('warehouses.create') }}">Tambah Gudang</a></li>
                @endif
              </ul>
            </li>
            {{-- CUSTOMER --}}
            <li class="
            {{ Request::path() === 'customers' ? 'active' : '' }}
            {{ Request::path() === 'customers/create' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Data Customer</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                <li class="{{ Request::path() === 'customers' ? 'active' : '' }}"><a href="{{ route('customers') }}">List Customer</a></li>
                @if (Auth::user()->can('create-customer'))
                <li class="{{ Request::path() === 'customers/create' ? 'active' : '' }}"><a href="{{ route('customers.create') }}">Tambah Customer</a></li>
                @endif
              </ul>
            </li>
        </ul>

    </div>
</nav>
