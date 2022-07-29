@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Edit Data Customer</h5>
                        <h5><strong>({{ $item->nama_customer }})</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('customers.update', $item->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="nama_customer" class="col-sm-2 col-form-label">Nama Customer</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_customer"
                                        value="{{ old('nama_customer') ? old('nama_customer') : $item->nama_customer }}"
                                        class="form-control @error('nama_customer') is-invalid @enderror">
                                        @error('nama_customer') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat_customer" class="col-sm-2 col-form-label">Alamat Customer</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="alamat_customer"
                                        value="{{ old('alamat_customer') ? old('alamat_customer') : $item->alamat_customer }}"
                                        class="form-control @error('alamat_customer') is-invalid @enderror">
                                        @error('alamat_customer') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email_customer" class="col-sm-2 col-form-label">E-mail Customer</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="email_customer"
                                        value="{{ old('email_customer') ? old('email_customer') : $item->email_customer }}"
                                        class="form-control @error('email_customer') is-invalid @enderror">
                                        @error('email_customer') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon_customer" class="col-sm-2 col-form-label">Kontak Customer</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="telepon_customer"
                                        value="{{ old('telepon_customer') ? old('telepon_customer') : $item->telepon_customer }}"
                                        class="form-control @error('telepon_customer') is-invalid @enderror">
                                        @error('telepon_customer') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('customers') }}">Cancel</a></button>
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
