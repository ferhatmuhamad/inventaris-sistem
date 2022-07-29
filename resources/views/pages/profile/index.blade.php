@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Data User {{$data['profile']->name}}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama Staff</label>
                            <div class="col-sm-10">
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') ? old('name') : $data['profile']->nama }}"
                                    class="form-control @error('name') is-invalid @enderror" readonly>
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
                                    class="form-control @error('email') is-invalid @enderror" readonly>
                                    @error('email') <div class="text-muted">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    {{-- <button class="btn btn-primary btn-sm" type="submit">Edit Data</button> --}}
                                    <a href="{{ route('profile.edit', $data['profile']->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil"></i> Edit Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
