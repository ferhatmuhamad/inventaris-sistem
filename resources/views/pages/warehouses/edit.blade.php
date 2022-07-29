@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Edit Data Gudang</h5>
                        <h5><strong>({{ $item->nama_gudang }})</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('warehouses.update', $item->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="nama_gudang" class="col-sm-2 col-form-label">Nama Gudang</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_gudang"
                                        value="{{ old('nama_gudang') ? old('nama_gudang') : $item->nama_gudang }}"
                                        class="form-control @error('nama_gudang') is-invalid @enderror">
                                        @error('nama_gudang') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat_gudang" class="col-sm-2 col-form-label">Alamat Gudang</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="alamat_gudang"
                                        value="{{ old('alamat_gudang') ? old('alamat_gudang') : $item->alamat_gudang }}"
                                        class="form-control @error('alamat_gudang') is-invalid @enderror">
                                        @error('alamat_gudang') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('warehouses') }}">Cancel</a></button>
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
