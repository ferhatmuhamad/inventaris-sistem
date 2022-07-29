@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>Tambah Data Supplier</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('suppliers.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="nama_supplier" class="col-sm-2 col-form-label">Nama Supplier</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_supplier"
                                        value="{{ old('nama_supplier') }}"
                                        class="form-control @error('nama_supplier') is-invalid @enderror" required>
                                        @error('nama_supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat_supplier" class="col-sm-2 col-form-label">Alamat Supplier</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="alamat_supplier"
                                        value="{{ old('alamat_supplier') }}"
                                        class="form-control @error('alamat_supplier') is-invalid @enderror" required>
                                        @error('alamat_supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email_supplier" class="col-sm-2 col-form-label">E-mail Supplier</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="email_supplier"
                                        value="{{ old('email_supplier') }}"
                                        class="form-control @error('email_supplier') is-invalid @enderror" required>
                                        @error('email_supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon_supplier" class="col-sm-2 col-form-label">Kontak Supplier</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="telepon_supplier"
                                        value="{{ old('telepon_supplier') }}"
                                        class="form-control @error('telepon_supplier') is-invalid @enderror" required>
                                        @error('telepon_supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('suppliers') }}">Cancel</a></button>
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
