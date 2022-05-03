@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>Tambah Data Produk</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="kode" class="col-sm-2 col-form-label">Kode Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="kode"
                                        value="{{ old('kode') }}"
                                        class="form-control @error('kode') is-invalid @enderror">
                                        @error('kode') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kategori Produk</label>
                                <div class="col-sm-10">
                                    <select name="id_kategori"
                                    class="form-control @error('products_id') is-invalid @enderror">
                                    @foreach ($productcategory as $pcategory)
                                        <option value="{{ $pcategory->id }}">{{ $pcategory->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            @error('id_kategoru') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="nama_produk"
                                        value="{{ old('nama_produk') }}"
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
                                    >{{ old('spesifikasi') }}</textarea>
                                    @error('spesifikasi') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="stok" class="col-sm-2 col-form-label">Stok Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="number"
                                        name="stok"
                                        value="{{ old('stok') }}"
                                        class="form-control @error('stok') is-invalid @enderror">
                                        @error('stok') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="letak" class="col-sm-2 col-form-label">Letak Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="letak"
                                        value="{{ old('letak') }}"
                                        class="form-control @error('letak') is-invalid @enderror">
                                        @error('letak') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="supplier" class="col-sm-2 col-form-label">Supplier Produk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        name="supplier"
                                        value="{{ old('supplier') }}"
                                        class="form-control @error('supplier') is-invalid @enderror">
                                        @error('supplier') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="barang_masuk" class="col-sm-2 col-form-label">Barang Masuk</label>
                                <div class="col-sm-10">
                                    <input
                                        type="date"
                                        name="barang_masuk"
                                        value="{{ old('barang_masuk') }}"
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
                                        value="{{ old('harga_jual') }}"
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
                                        value="{{ old('harga_beli') }}"
                                        class="form-control @error('harga_beli') is-invalid @enderror">
                                        @error('harga_beli') <div class="text-muted">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label for="photo" class="col-sm-2 col-form-label">Foto Produk (MAX : 1 Photo)</label>
                                <div class="col-sm-10">
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <input
                                    type="file"
                                    name="photo"
                                    id="photo"
                                    value="{{ old('photo') }}"
                                    accept="image/*"
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
