@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>Update Data Stok Keluar</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('stockout.update', $data['parse']->id) }}" method="POST">
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
                                        <label for="status_bill" class="col-sm-2 col-form-label">Status</label>
                                        <select name="status_bill" class="form-control @error('status_bill') is-invalid @enderror" required>
                                            <option value="F" {{$data['parse']->status_bill == 'F' ? 'selected':''}}>GAGAL</option>
                                            <option value="P" {{$data['parse']->status_bill == 'P' ? 'selected':''}}>PROSES</option>
                                            <option value="S" {{$data['parse']->status_bill == 'S' ? 'selected':''}}>SELESAI</option>
                                        </select>
                                        @error('status_bill') <div class="text-muted">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="clone">
                                    <div id="clone1">

                                        {{-- PRODUCT DATA --}}

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
                                                name="stock" id="stock"
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

                                        {{-- CUSTOMER DATA --}}

                                        <div class="row input_fields_wrap">
                                            <div class="col-md-7 mb-3">
                                                <label for="">Nama Customer</label>
                                                <select name="id_customer" id="id_customer" class="form-control @error('id_customer') is-invalid @enderror" disabled>
                                                    @if ($data['customer']->count() == 0)
                                                        <option value="">Belum Ada Customer</option>
                                                    @else
                                                        @foreach ($data['customer'] as $customer)
                                                            <option value="{{$customer->id}}" {{$customer->id == $data['parse']->id_customer ? 'selected' : ''}}>{{$customer->nama_customer}} | {{$customer->telepon_customer}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('id_customer') <div class="text-muted">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="">Total Tagihan</label>
                                                <input
                                                type="number"
                                                name="totalPrice" id="totalPrice"
                                                class="form-control @error('totalPrice') is-invalid @enderror"
                                                @php
                                                    $totalPrice = $data['parse']->stock * $data['parse']->product->harga_jual*-1;
                                                @endphp
                                                value="{{ $totalPrice }}" disabled>
                                                @error('totalPrice') <div class="text-muted">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label for="">Tagihan Customer</label>
                                                <input
                                                type="number"
                                                name="bill" min="1" id="bill"
                                                class="form-control @error('stock') is-invalid @enderror"
                                                value="{{ $data['parse']->bill }}">
                                                @error('bill') <div class="text-muted">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-12">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('stockout') }}">Cancel</a></button>
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
