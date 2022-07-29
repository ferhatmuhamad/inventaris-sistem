@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>Tambah Data Kategori Produk</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('productcategory.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="nama_kategori" class="col-sm-2 col-form-label">Kategori Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_kategori"
                                        value="{{ old('nama_kategori') }}"
                                        class="form-control @error('nama_kategori') is-invalid @enderror" required>
                                        @error('nama_kategori') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('productcategory') }}">Cancel</a></button>
                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                    </div>
                                </div>
                        </form>
                        {{-- =============== END FORM =============== --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
