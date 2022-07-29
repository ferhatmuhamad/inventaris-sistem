@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Edit Data Periode Bulan</h5>
                        <h5><strong>({{ $data->nama_bulan }})</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('month.update', $data->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="nama_bulan" class="col-sm-2 col-form-label">Nama Bulan</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_bulan"
                                        value="{{ old('nama_bulan') ? old('nama_bulan') : $data->nama_bulan }}"
                                        class="form-control @error('nama_bulan') is-invalid @enderror">
                                        @error('nama_bulan') <div class="text-muted">{{ $message }}</div> @enderror
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
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('month') }}">Cancel</a></button>
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
