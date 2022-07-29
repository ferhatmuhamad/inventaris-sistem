<div class="row">
    <div class="col-4">
        <div class="d-block">
            <img class="img-fluid" src="{{ $data['parse']->photo }}">
        </div>
        <div class="hr-line-dashed"></div>
        <div class="d-block mt-3">
            <h4>Kode QR</h4>
            <img style="width: 100px" src="{{ $data['parse']->kodeqr }}" alt="">
        </div>
    </div>
    <div class="col-8">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="col-4">Nama Produk</th>
                    <td>{{ $data['parse']->nama_produk }}</td>
                </tr>
                <tr>
                    <th>Kategori Produk</th>
                    <td>{{ $data['parse']->productcategory->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Spesifikasi</th>
                    <td>{!! $data['parse']->spesifikasi !!}</td>
                </tr>
                <tr>
                    <th>Stok Min</th>
                    <td>{{ $data['parse']->stock_min }}</td>
                </tr>
                <tr>
                    <th>Posisi Produk</th>
                    <td>{{ $data['parse']->letak }}</td>
                </tr>
                <tr>
                    <th>Supplier Produk</th>
                    <td>{{ $data['parse']->supplier->nama_supplier }}</td>
                </tr>
                <tr>
                    <th>Barang Masuk</th>
                    <td>{{ $data['parse']->barang_masuk }}</td>
                </tr>
                <tr>
                    <th>Harga Produk</th>
                    <td>
                        <table class="table table-bordered w-100">
                            <tr style="background-color: #18A689; color: white; ">
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                            </tr>
                            <tr>
                                <td>Rp. {{ $data['parse']->harga_beli }}</td>
                                <td>Rp. {{ $data['parse']->harga_jual }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="row">
    @if (Auth::user()->can(['update-product','delete-product']))
    <div class="col-4">
        <a href="{{ route('products.download', $data['parse']->id) }}" class="btn btn-success btn-block">
            <i class="fa fa-download"></i> Download QR Code
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('products.edit', $data['parse']->id) }}" class="btn btn-primary btn-block">
            <i class="fa fa-pencil"></i> Edit Produk
        </a>
    </div>
    <div class="col-4">
        <form action="{{ route('products.destroy', $data['parse']->id) }}"
            method="POST"
            class="d-inline"
            onclick="return confirm('Apa anda yakin?');">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-block">
                <i class="fa fa-trash"></i>Hapus Produk
            </button>
        </form>
    </div>
    @else
    <div class="col-12">
        <a href="{{ route('products.download', $data['parse']->id) }}" class="btn btn-success btn-block">
            <i class="fa fa-download"></i> Download QR Code
        </a>
    </div>
    @endif
</div>
