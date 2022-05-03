<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{asset("/assets/img/profile_small.jpg")}}"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">David Williams</span>
                        <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                        <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="{{ Request::path() === '/' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
            </li>
            <li class="
            {{ Request::path() === 'products' ? 'active' : '' }}
            {{ Request::path() === 'products/create' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Data Produk</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li class="{{ Request::path() === 'products' ? 'active' : '' }}"><a href="{{ route('products') }}">Lihat Produk</a></li>
                  <li class="{{ Request::path() === 'products/create' ? 'active' : '' }}"><a href="{{ route('products.create') }}">Tambah Produk</a></li>
              </ul>
            </li>
            <li class="
            {{ Request::path() === 'productcategory' ? 'active' : '' }}
            {{ Request::path() === 'productcategory/create' ? 'active' : '' }}
            ">
              <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Data Kategori Produk</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level collapse">
                  <li class="{{ Request::path() === 'productcategory' ? 'active' : '' }}"><a href="{{ route('productcategory') }}">Lihat Kategori</a></li>
                  <li class="{{ Request::path() === 'productcategory/create' ? 'active' : '' }}"><a href="{{ route('productcategory.create') }}">Tambah Kategori </a></li>
              </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-dollar"></i> <span class="nav-label">Data Transaksi</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="graph_flot.html">Data Transaksi</a></li>
                    <li><a href="graph_morris.html">Morris.js Charts</a></li>
                </ul>
            </li>
            <li>
              <a href="metrics.html"><i class="fa fa-pie-chart"></i> <span class="nav-label">Grafik Omset</span>  </a>
            </li>
            {{-- <li>
                <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
            </li> --}}
        </ul>

    </div>
</nav>
