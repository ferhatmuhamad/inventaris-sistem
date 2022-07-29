@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Edit Data Gudang</h5>
                        <h5><strong>({{ $data['parse']->product->nama_produk }})</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('stockopname.update', $data['parse']->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Produk</label>
                                <div class="col-sm-10">
                                    <select name="id_product"
                                    class="form-control @error('products_id') is-invalid @enderror" disabled>
                                    @if ($data['product']->count() == 0)
                                        <option value="">Belum Ada Produk</option>
                                    @else
                                    @foreach ($data['product'] as $product)
                                        <option value="{{ $product->id }}" {{ $product->id == $data['parse']->id_product ? 'selected' : '' }}>{{ $product->nama_produk }}</option>
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
                                    <select name="id_supplier"
                                    class="form-control @error('products_id') is-invalid @enderror">
                                    @if ($data['supplier']->count() == 0)
                                        <option value="">Belum Ada Supplier</option>
                                    @else
                                    @foreach ($data['supplier'] as $sup)
                                        <option value="{{ $sup->id }}" {{ $sup->id == $data['parse']->id_supplier ? 'selected' : '' }}>{{ $sup->nama_supplier }}</option>
                                    @endforeach
                                    @endif
                                    </select>
                                @error('id_supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="date" class="col-sm-2 col-form-label">Tanggal Opname</label>
                                <div class="col-sm-10">
                                    <input
                                        type="date"
                                        name="date"
                                        value="{{ old('date') ? old('date') : $data['parse']->date }}"
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
                                        value="{{ old('stock') ? old('stock') : $data['parse']->stock }}"
                                        class="form-control @error('stock') is-invalid @enderror">
                                        @error('stock') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Gudang</label>
                                <div class="col-sm-10">
                                    <select name="id_warehouse"
                                    class="form-control @error('products_id') is-invalid @enderror">
                                    @if ($data['warehouse']->count() == 0)
                                        <option value="">Belum Ada Gudang</option>
                                    @else
                                    @foreach ($data['warehouse'] as $wh)
                                        <option value="{{ $wh->id }}" {{ $wh->id == $data['parse']->id_warehouse ? 'selected' : '' }}>{{ $wh->nama_gudang }}</option>
                                    @endforeach
                                    @endif
                                    </select>
                                @error('id_warehouse') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('stockopname') }}">Cancel</a></button>
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
