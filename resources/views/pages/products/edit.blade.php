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
                        <h5>Edit Data Produk</h5>
                        <h5><strong>({{ $data['parse']->nama_produk }})</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('products.update', $data['parse']->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label for="kode" class="col-sm-2 col-form-label">Kode Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="kode"
                                        value="{{ old('kode') ? old('kode') : $data['parse']->kode }}"
                                        class="form-control @error('kode') is-invalid @enderror"
                                        disabled>
                                        @error('kode') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Kategori</label>
                                <div class="col-sm-10">
                                    <select name="id_kategori"
                                    class="form-control @error('products_id') is-invalid @enderror" data-live-search="true" required>
                                    @if ($data['category']->count() == 0)
                                        <option value="">Belum Ada Gudang</option>
                                    @else
                                    @foreach ($data['category'] as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $data['parse']->id_kategori ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('id_kategori') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_produk"
                                        value="{{ old('nama_produk') ? old('nama_produk') : $data['parse']->nama_produk }}"
                                        class="form-control @error('nama_produk') is-invalid @enderror">
                                        @error('nama_produk') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="spesifikasi" class="col-sm-2 col-form-label">Deskripsi Produk</label>
                                <div class="col-sm-10">
                                    <textarea
                                    name="spesifikasi"
                                    class="ckeditor form-control @error('spesifikasi') is-invalid @enderror"
                                    >{{ old('spesifikasi') ? old('spesifikasi') : $data['parse']->spesifikasi }}</textarea>
                                    @error('spesifikasi') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="stock_min" class="col-sm-2 col-form-label">Stok Minimal</label>
                                <div class="col-sm-10">
                                    <input
                                        type="number"
                                        name="stock_min"
                                        value="{{ old('stock_min') ? old('stock_min') : $data['parse']->stock_min }}"
                                        class="form-control @error('stock_min') is-invalid @enderror">
                                        @error('stock_min') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="stock" class="col-sm-2 col-form-label">Stok Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="number"
                                        name="stock"
                                        value="{{ old('stock') ? old('stock') : $data['parse']->stock }}"
                                        class="form-control @error('stock') is-invalid @enderror">
                                        @error('stock') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="letak" class="col-sm-2 col-form-label">Letak Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="letak"
                                        value="{{ old('letak') ? old('letak') : $data['parse']->letak }}"
                                        class="form-control @error('letak') is-invalid @enderror">
                                        @error('letak') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Pilih Supplier</label>
                                <div class="col-sm-10">
                                    <select name="id_supplier"
                                    class="form-control @error('products_id') is-invalid @enderror" data-live-search="true" required>
                                    @if ($data['supplier']->count() == 0)
                                        <option value="">Belum Ada Supplier</option>
                                    @else
                                    @foreach ($data['supplier'] as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $supplier->id == $data['parse']->id_supplier ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('id_supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="barang_masuk" class="col-sm-2 col-form-label">Barang Masuk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="date"
                                        name="barang_masuk"
                                        value="{{ old('barang_masuk') ? old('barang_masuk') : $data['parse']->barang_masuk }}"
                                        class="form-control @error('barang_masuk') is-invalid @enderror">
                                        @error('barang_masuk') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="harga_jual" class="col-sm-2 col-form-label">Harga Jual</label>
                                <div class="col-sm-10">
                                    <input
                                        type="number"
                                        name="harga_jual"
                                        value="{{ old('harga_jual') ? old('harga_jual') : $data['parse']->harga_jual }}"
                                        class="form-control @error('harga_jual') is-invalid @enderror">
                                        @error('harga_jual') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="harga_beli" class="col-sm-2 col-form-label">Harga Beli</label>
                                <div class="col-sm-10">
                                    <input
                                        type="number"
                                        name="harga_beli"
                                        value="{{ old('harga_beli') ? old('harga_beli') : $data['parse']->harga_beli }}"
                                        class="form-control @error('harga_beli') is-invalid @enderror">
                                        @error('harga_beli') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="photo" class="col-sm-2 col-form-label">Foto Produk (MAX : 1 Photo)</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="oldImage" value="{{ $data['parse']->photo }}">
                                    @if ($data['parse']->photo)
                                    <img src="{{ $data['parse']->photo }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                    @else
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    @endif
                                    <input
                                    type="file"
                                    name="photo"
                                    id="photo"
                                    {{-- src="{{ $data['parse']->photo }}" --}}
                                    {{-- value="{{ asset($data['parse']->photo) }}" --}}
                                    {{-- accept="image/*" --}}
                                    class="form-control @error('photo') is-invalid @enderror"
                                    onchange="previewImage()">
                                    @error('photo') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="submit"><a style="color: #000" href="{{ route('products') }}">Cancel</a></button>
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
{{-- SELECT LIVE SEARCH --}}
<script src="{{asset("https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js")}}"></script>

<script>
    $(document).ready(function() {
        $('select').selectpicker();
    })
</script>

<script>
    function previewImage()
    {
        const image = document.querySelector('#photo');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection
