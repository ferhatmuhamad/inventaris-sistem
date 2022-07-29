<div class="row">
    <div class="col-6">
        <div class="d-block">
            <h3>Foto Produk</h3>
            <img class="img-fluid" src="{{ $data['parse']->product->photo }}">
        </div>
        <div class="d-block mt-3">
            <h3>Data Transaksi</h3>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th class="col-4">Tanggal Transaksi</th>
                        <td>{{ $data['parse']->date }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Stok Total</th>
                        <td>{{ $data['parse']->stock*-1 }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Total Transaksi</th>
                        <td>{{ number_format($data['parse']->product->harga_jual * $data['parse']->stock*-1) }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Tagihan Terbayar</th>
                        <td>{{ number_format($data['parse']->bill) }}</td>
                    </tr>
                    <tr>
                        <th class="col-4">Kekurangan Tagihan</th>
                        @php
                            $totalTransaksi = $data['parse']->product->harga_jual * $data['parse']->stock*-1;
                            $totalTagihan = number_format($totalTransaksi - $data['parse']->bill);
                        @endphp
                        <td>{{ $totalTagihan }} <strong>( {{ $totalTagihan == 0 ? 'Lunas' : 'Belum Lunas' }} )</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <h3>Data Customer</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="col-4">Nama Customer</th>
                    <td>{{ $data['parse']->customer->nama_customer }}</td>
                </tr>
                <tr>
                    <th class="col-4">Alamat Customer</th>
                    <td>{{ $data['parse']->customer->alamat_customer }}</td>
                </tr>
                <tr>
                    <th>Kontak Customer</th>
                    <td>{{ $data['parse']->customer->telepon_customer }}</td>
                </tr>
                <tr>
                    <th>Email Customer</th>
                    <td>{{ $data['parse']->customer->email_customer }}</td>
                </tr>
            </table>
        </div>
        <div class="hr-line-dashed"></div>
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
    @if (Auth::user()->can('update-stockout'))
    <div class="col-4">
        <a href="{{ route('stockout.setstatus', $data['parse']->id) }}?status_bill=S" class="btn btn-success btn-block">
            <i class="fa fa-check"></i> Pilih Sukses
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('stockout.setstatus', $data['parse']->id) }}?status_bill=P" class="btn btn-warning btn-block">
            <i class="fa fa-spinner"></i> Pilih Proses
        </a>
    </div>
    <div class="col-4">
        <a href="{{ route('stockout.setstatus', $data['parse']->id) }}?status_bill=F" class="btn btn-danger btn-block">
            <i class="fa fa-times"></i> Pilih Gagal
        </a>
    </div>
    @else
    <div class="col-12">
        <a href="/forbidden" class="btn btn-danger btn-block">
            Fitur Tidak Tersedia
        </a>
    </div>
    @endif
</div>
