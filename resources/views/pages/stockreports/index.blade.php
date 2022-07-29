@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ $message }}
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="box-title">Laporan Stok Periode : <strong>{{$data['month']->nama_bulan}} {{$data['periode']->nama_periode}}</strong></h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-content">

                                        <div class="table-responsive">
                                            {{-- <table class="table table-striped"> --}}
                                            <table id="table-content" class="mt-4 table table-hover table-stripped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Gambar</th>
                                                        <th>Kode</th>
                                                        <th>Nama Produk</th>
                                                        <th>Harga</th>
                                                        <th>Stok Min</th>
                                                        <th>Stok Gudang</th>
                                                        <th>Lokasi</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-custom')
<script>
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ url('stockreport/data') }}",
                // data: function (d) {
                //     d.Fiscal_Year_Id = $('#filter_tahun').val();
                // }
            },
            autoWidth: false,
            // order: [[1, 'desc']],
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                },

                {
                    "targets": 3, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },
                {
                    "targets": 4, // your case first column
                    "className": "text-center",
                    "width": "15%"
                },
                {
                    "targets": 7, // your case first column
                    "className": "text-center",
                    "width": "15%"
                },

                ],
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'imageData', name: 'imageData'},
                {data: 'kodeBlade', name: 'kodeBlade'},
                {data: 'productName', name: 'productName'},
                {data: 'hargaJual', name: 'hargaJual'},
                {data: 'stockMin', name: 'stockMin'},
                {data: 'stockWarehouse', name: 'stockWarehouse'},
                {data: 'warehouse', name: 'warehouse'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            },
        });

        $('#filter').click(function(){
            table.draw();
        });

        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

        $('.data-search').on('keyup', function() {
            table.search(this.value).draw();
        });
    })
</script>
@endsection
