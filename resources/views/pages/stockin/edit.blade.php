@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>Update Data Stok Masuk</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('stockin.update', $data['parse']->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="container wrap mb-5">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="date">Tanggal</label>
                                        <input type="date"
                                        name="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date') ? old('date') : $data['parse']->date }}">
                                        @error('date') <div class="text-muted">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="check" class="col-sm-2 col-form-label">Status</label>
                                        <select name="check" class="form-control @error('check') is-invalid @enderror" required>
                                            <option value="F" {{$data['parse']->check == 'F' ? 'selected':''}}>GAGAL</option>
                                            <option value="P" {{$data['parse']->check == 'P' ? 'selected':''}}>PROSES</option>
                                            <option value="OP" {{$data['parse']->check == 'OP' ? 'selected':''}}>OPNAME</option>
                                            <option value="S" {{$data['parse']->check == 'S' ? 'selected':''}}>SELESAI</option>
                                        </select>
                                        @error('check') <div class="text-muted">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="clone">
                                    <div id="clone1">
                                        <div class="row input_fields_wrap">
                                            <div class="col-md-7 mb-3">
                                                <label for="">Pilih Barang</label>
                                                <select name="id_product" id="id_product" class="form-control @error('id_product') is-invalid @enderror" disabled>
                                                    @if ($data['product']->count() == 0)
                                                        <option value="">Belum Ada Produk</option>
                                                    @else
                                                        @foreach ($data['product'] as $product)
                                                            <option value="{{$product->id}}" {{$product->id == $data['parse']->id_product ? 'selected' : ''}}>{{$product->nama_produk}} | Rp. {{$product->harga_jual}} | Supplier : {{$product->supplier->nama_supplier}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('id_product') <div class="text-muted">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="">Stok Produk</label>
                                                <input
                                                type="number"
                                                name="stock" min="1" id="stock"
                                                class="form-control @error('stock') is-invalid @enderror"
                                                value="{{ old('stock') ? old('stock') : $data['parse']->stock }}">
                                                @error('stock') <div class="text-muted">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Harga Produk</label>
                                                <input
                                                type="number"
                                                name="harga_jual" id="harga_jual"
                                                class="form-control @error('stock') is-invalid @enderror"
                                                value="{{ old('harga_jual') ? old('harga_jual') : $data['parse']->product->harga_jual }}" disabled>
                                                @error('harga_jual') <div class="text-muted">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-12">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('stockin') }}">Cancel</a></button>
                                        <button id="proses_button" class="btn btn-success">Save Changes</button>
                                    </div>
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

@section('script-custom')

<script type="text/javascript">

</script>
@endsection
