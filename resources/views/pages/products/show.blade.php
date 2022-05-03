<div class="row">
    <div class="col-4">
        <div class="d-block">
            <img class="img-fluid" src="{{ $item->photo }}">
        </div>
        <div class="hr-line-dashed"></div>
        <div class="d-block mt-3">
            <h4>Kode QR</h4>
            <img style="width: 100px" src="{{ $item->kodeqr }}" alt="">
        </div>
    </div>
    <div class="col-8">
        <table class="table table-bordered">
            <tr>
                <th class="col-4">Nama Produk</th>
                <td>{{ $item->nama_produk }}</td>
            </tr>
            <tr>
                <th>Kategori Produk</th>
                <td>{{ $item->productcategory->nama_kategori }}</td>
            </tr>
            <tr>
                <th>Spesifikasi</th>
                <td>{!! $item->spesifikasi !!}</td>
            </tr>
            <tr>
                <th>Stok</th>
                <td>{{ $item->stok }}</td>
            </tr>
            <tr>
                <th>Posisi Produk</th>
                <td>{{ $item->letak }}</td>
            </tr>
            <tr>
                <th>Supplier</th>
                <td>{{ $item->supplier }}</td>
            </tr>
            <tr>
                <th>Barang Masuk</th>
                <td>{{ $item->barang_masuk }}</td>
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
                            <td>Rp. {{ $item->harga_beli }}</td>
                            <td>Rp. {{ $item->harga_jual }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="hr-line-dashed"></div>
<div class="row">
    <div class="col-4">
        <a href="{{ route('products.download', $item->id) }}" class="btn btn-success btn-block">
            <i class="fa fa-download"></i> Download QR Code
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('products.edit', $item->id) }}" class="btn btn-primary btn-block">
            <i class="fa fa-pencil"></i> Edit Produk
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('products.destroy', $item->id) }}" class="btn btn-danger btn-block">
            <i class="fa fa-trash"></i> Hapus Produk
        </a>
    </div>
</div>
