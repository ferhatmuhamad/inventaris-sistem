@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Data User {{$data['profile']->name}}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('profile.update', $data['profile']->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Nama Staff</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') ? old('name') : $data['profile']->name }}"
                                        class="form-control @error('name') is-invalid @enderror">
                                        @error('name') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email Staff</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="email"
                                        value="{{ old('email') ? old('email') : $data['profile']->email }}"
                                        class="form-control @error('email') is-invalid @enderror">
                                        @error('email') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="role" class="col-sm-2 col-form-label">Jabatan Staff</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="role"
                                        value="{{ old('role') ? old('role') : $data['profile']->role }}"
                                        class="form-control @error('role') is-invalid @enderror">
                                        @error('role') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div> --}}
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('products') }}">Cancel</a></button>
                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
