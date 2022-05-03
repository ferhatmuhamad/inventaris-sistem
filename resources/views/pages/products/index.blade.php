@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ $message }}
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Daftar Produk</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-content">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    {{-- <input type="text" id="filter" name="cari_produk" value="" placeholder="Cari Produk" class="form-control form-control-sm m-b-xs mt-2 mb-2"> --}}
                                                    <input type="text" style="padding: 20px;" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Cari">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    {{-- <table class="table table-striped"> --}}
                                                    <table ref="myFooTable" id="table-content" class="mt-4 footable table table-hover table-stripped" data-page-size="10" data-filter=#filter>
                                                        <thead>
                                                            <tr>
                                                                <th>NO</th>
                                                                <th>Foto</th>
                                                                <th>Kode</th>
                                                                <th>Nama Produk</th>
                                                                <th>Kategori</th>
                                                                <th>Stok</th>
                                                                <th>Harga</th>
                                                                <th>Tanggal</th>
                                                                <th>Kode QR</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php($i=1)
                                                            @forelse ($items as $item)
                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td><img class="img-fluid" style="width: 50px" src="{{ $item->photo }}" alt=""></td>
                                                                    @php($kodeBlade = explode('-', $item->kode))
                                                                    <td>{{ $kodeBlade[0] }}</td>
                                                                    <td>{{ $item->nama_produk }}</td>
                                                                    <td>{{ $item->productcategory->nama_kategori }}</td>
                                                                    <td>{{ $item->stok }}</td>
                                                                    <td>{{ $item->harga_jual }}</td>
                                                                    <td>{{ $item->barang_masuk }}</td>
                                                                    <td><img style="width: 50px" src="{{ $item->kodeqr }}" alt=""></td>
                                                                    <td>
                                                                        <a href="#mymodal"
                                                                        data-remote = "{{ route('products.show', $item->id) }}"
                                                                        data-toggle = "modal"
                                                                        data-target = "#mymodal"
                                                                        data-title = "Detail Produk {{ $item->kode }}"
                                                                        class="btn btn-info btn-sm">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('products.download', $item->id) }}"
                                                                        class="btn btn-success btn-sm">
                                                                            <i class="fa fa-download"></i>
                                                                        </a>
                                                                        <a href="{{ route('products.edit', $item->id) }}"
                                                                            class="btn btn-primary btn-sm">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <form action="{{ route('products.destroy', $item->id) }}"
                                                                            method="POST"
                                                                            class="d-inline"
                                                                            onclick="return confirm('yakin?');">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <button class="btn btn-danger btn-sm">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="12" class="text-center p-5">
                                                                        Data Tidak Tersedia!
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-custom')
    <script src="{{asset('/assets/js/footable.js')}}"></script>
    {{-- <script src="{{asset('/assets/js/footable.js')}}"></script> --}}

    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();


        });
    </script>
@endsection
