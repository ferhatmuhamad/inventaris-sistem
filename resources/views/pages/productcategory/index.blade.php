@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
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
                        <h4 class="box-title">Daftar Kategori Produk</h4>
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
                                                    {{-- <input type="text" id="product_name" name="product_name" value="" placeholder="Cari Kategori" class="form-control form-control-sm m-b-xs mt-2 mb-2"> --}}
                                                    <input type="text" style="padding: 20px;" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Cari">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            {{-- <table class="table table-striped"> --}}
                                            <table ref="myFooTable" id="table-content" class="mt-4 footable table table-hover table-stripped" data-page-size="10" data-filter=#filter>
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Nama Kategori</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($items as $item)
                                                        <tr>
                                                            <td>{{ $item->id }}</td>
                                                            <td>{{ $item->nama_kategori }}</td>
                                                            <td>
                                                                <a href="{{ route('productcategory.edit', $item->id) }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('productcategory.destroy', $item->id) }}"
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
                                                            <td colspan="6" class="text-center p-5">
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
