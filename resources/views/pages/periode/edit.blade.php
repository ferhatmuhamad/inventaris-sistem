@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Edit Data Periode Tahun</h5>
                        <h5><strong>({{ $data->nama_periode }})</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('periode.update', $data->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="nama_periode" class="col-sm-2 col-form-label">Nama Periode</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_periode"
                                        value="{{ old('nama_periode') ? old('nama_periode') : $data->nama_periode }}"
                                        class="form-control @error('nama_periode') is-invalid @enderror">
                                        @error('nama_periode') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="active" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="active" class="form-control @error('active') is-invalid @enderror" required>
                                        <option value="N" {{$data->active == 'N' ? 'selected':''}}>Nonaktif</option>
                                        <option value="Y" {{$data->active == 'Y' ? 'selected':''}}>Aktif</option>
                                    </select>
                                    @error('active') <div class="text-muted">{{ $message }}</div> @enderror
                                    {{-- <input
                                        type="text"
                                        name="active"
                                        value="{{ old('active') ? old('active') : $data->active }}"
                                        class="form-control @error('active') is-invalid @enderror">
                                        @error('active') <div class="text-muted">{{ $message }}</div> @enderror --}}
                                </div>
                            </div>

                            {{-- <div class="col-md-12 mb-4">
                                <label for="cc-name">Status</label>
                                <select name="active" class="form-control" required>
                                    <option value="N" {{$data->active == 'N' ? 'selected':''}}>Nonaktif</option>
                                    <option value="Y" {{$data->active == 'Y' ? 'selected':''}}>Aktif</option>
                                </select>
                            </div> --}}

                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('periode') }}">Cancel</a></button>
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
