<div class="row">
    <div class="col-6">
        <div class="d-block">
            <h3>Foto Produk</h3>
            <img class="img-fluid" src="{{ $data['parse']->product->photo }}">
        </div>
    </div>
    <div class="col-6">
        <h3>Data Produk</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="col-4">Kode Produk</th>
                    @php
                        $kodeBlade = explode('-', $data['parse']->product->kode);
                    @endphp
                    <td>{{ $kodeBlade[0] }}</td>
                </tr>
                <tr>
                    <th class="col-4">Nama Produk</th>
                    <td>{{ $data['parse']->product->nama_produk }}</td>
                </tr>
                <tr>
                    <th>Kategori Produk</th>
                    <td>{{ $data['parse']->product->productcategory->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Spesifikasi</th>
                    <td>{!! $data['parse']->product->spesifikasi !!}</td>
                </tr>
                <tr>
                    <th>Supplier Produk</th>
                    <td>{{ $data['parse']->supplier->nama_supplier }}</td>
                </tr>
                <tr>
                    <th>Harga Produk</th>
                    <td>
                        <table class="table table-bordered">
                            <tr style="background-color: #18A689; color: white;">
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                            </tr>
                            <tr>
                                <td>Rp. {{ number_format($data['parse']->product->harga_beli) }}</td>
                                <td>Rp. {{ number_format($data['parse']->product->harga_jual) }}</td>
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
    <h3>Data Transaksi</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Stok Min</th>
                    <th>Stok Gudang</th>
                    <th>Stok Keluar</th>
                    <th>Stok Masuk</th>
                    {{-- <th>Total Stok (Periode Ini)</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data['parse']->product->stock_min }}</td>
                    <td>{{ $data['stockwarehouse'] }}</td>
                    <td>{{ $data['stockout'] }}</td>
                    <td>{{ $data['stockin'] }}</td>
                    {{-- <td>{{ $data['totalstock'] }}</td> --}}
                </tr>
            </tbody>
            {{-- <tr>
                <th class="col-4">Tanggal Transaksi</th>
                <td>{{ $data['parse']->date }}</td>
            </tr>
            <tr>
                <th class="col-4">Stok Total</th>
                <td>{{ $data['parse']->stock }}</td>
            </tr>
            <tr>
                <th class="col-4">Total Transaksi</th>
                <td>{{ number_format($data['parse']->product->harga_jual * $data['parse']->stock) }}</td>
            </tr>
            <tr>
                <th class="col-4">Tagihan Terbayar</th>
                <td>{{ number_format($data['parse']->bill) }}</td>
            </tr>
            <tr>
                <th class="col-4">Total Tagihan</th>
                @php
                    $totalTransaksi = $data['parse']->product->harga_jual * $data['parse']->stock;
                    $totalTagihan = number_format($totalTransaksi - $data['parse']->bill);
                @endphp
                <td>{{ $totalTagihan }} <strong>( {{ $totalTagihan == 0 ? 'Lunas' : 'Belum Lunas' }} )</strong></td>
            </tr> --}}
        </table>
    </div>
</div>
<div class="row">
    @if (Auth::user()->can('update-product'))
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
