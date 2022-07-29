@extends('layouts.default')

@section('style-custom')
<link rel="stylesheet" href="{{asset("https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css")}}">
@endsection

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>Tambah Data Stok Opname</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('stockopname.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Produk</label>
                                <div class="col-sm-10">
                                    <select name="id_product" id="id_product"
                                    class="selectpicker form-control @error('id_product') is-invalid @enderror" data-live-search="true">
                                    @if ($data['product']->count() == 0)
                                        <option value="">Belum Ada Produk</option>
                                    @else
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach ($data['product'] as $product)
                                        @if ($product->supplier)
                                        @php($kodeBlade = explode('-', $product->kode))
                                        <option value="{{ $product->id }}" {{ old('id_product') == $product->id ? 'selected':'' }}>{{ $kodeBlade[0] }} | {{ $product->nama_produk }} | Nama Supplier : {{$product->supplier->nama_supplier}}</option>
                                        @endif
                                        @endforeach
                                    @endif
                                </select>
                                @error('id_product') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Supplier</label>
                                <div class="col-sm-10">
                                    {{-- <input type="text" name="id_supplier" id="id_supplier" class="form-control" disabled> --}}
                                    <select name="id_supplier" id="id_supplier" class="form-control" readonly>
                                        <option value="" selected></option>
                                    </select>
                                @error('id_supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="date" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="date"
                                        name="date"
                                        value="{{ old('date') }}"
                                        class="form-control @error('date') is-invalid @enderror">
                                        @error('date') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="stock" class="col-sm-2 col-form-label">Stok Gudang</label>
                                <div class="col-sm-10">
                                    <input
                                        type="number"
                                        name="stock"
                                        min="0"
                                        value="{{ old('stock') }}"
                                        class="form-control @error('stock') is-invalid @enderror">
                                        @error('stock') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Gudang</label>
                                <div class="col-sm-10">
                                    <select name="id_warehouse"
                                    class="selectpicker form-control @error('id_product') is-invalid @enderror" data-live-search="true">
                                    @if ($data['warehouse']->count() == 0)
                                        <option value="">Belum Ada Gudang</option>
                                    @else
                                    <option value="">-- Pilih Gudang --</option>
                                    @foreach ($data['warehouse'] as $wh)
                                        <option value="{{ $wh->id }}" {{ old('id_warehouse') == $wh->id ? 'selected' : '' }}>{{ $wh->nama_gudang }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('id_warehouse') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="cancel"><a style="color: #000" href="{{ route('stockopname') }}">Cancel</a></button>
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

@section('script-custom')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
{{-- SELECT LIVE SEARCH --}}
<script src="{{asset("https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js")}}"></script>

<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    })
</script>

<script>

    $(document).ready(function() {
        $("#id_product").change(function(){
            getProduk(event.target.value).then(product => {
                $('#id_supplier').val(product.supplier.nama_supplier);
                // console.log(product.supplier.nama_supplier);

                var mySecondDiv=$(`<option selected value=${product.id_supplier}> ${product.supplier.nama_supplier} </option>`);
                $('#id_supplier').html(mySecondDiv);
            });
        });

    })

    async function getProduk(id) {
        let response = await fetch('/stockopname/data/' + id)
        let data = await response.json();

        return data;
    }


</script>
@endsection

