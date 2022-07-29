@extends('layouts.default')

@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-success float-right">AKTIF</span>
                            <h5>Periode</h5>
                        </div>
                        <div class="ibox-content">
                            @foreach ($data['month'] as $month)
                                @foreach ($data['periode'] as $periode)
                                <h1 class="no-margins">{{ $month->nama_bulan }} {{ $periode->nama_periode }}</h1>
                                @endforeach
                            @endforeach
                            <small>Stok Minimal</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-danger float-right">GAGAL</span>
                            <h5>Stok Keluar</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{$data['stockoutf']}}</h1>
                            <small>Proses Gagal</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-warning float-right">PROSES</span>
                            <h5>Stok Keluar</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $data['stockoutp'] }}</h1>
                            <small>Proses Pengiriman/Pelunasan</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <span class="label label-primary float-right">SELESAI</span>
                            <h5>Stok Keluar</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ $data['stockouts'] }}</h1>
                            <small>Proses Pengiriman/Pelunasan</small>
                        </div>
                    </div>
                </div>
    </div>

    {{-- GRAFIK --}}
    <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Total Pengeluaran (Periode)</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                            <div class="col-lg-12">
                                <div class="graph-chart">
                                    <div class="graph-chart-content" id="graph-dashboard-content"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Data Transaksi</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">
                                    <table id="table-content" class="mt-4 table table-hover table-stripped data-table">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Customer</th>
                                                <th>Nama Produk</th>
                                                <th>Tanggal</th>
                                                <th>Stok Keluar</th>
                                                <th>Kekurangan Tagihan</th>
                                                <th>Status Customer</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->can('read-all-profile'))
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="table-responsive">
                                    <table id="table-content" class="mt-4 table table-hover table-stripped data-tables" data-page-size="10">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Id User</th>
                                                <th>Nama User</th>
                                                <th>Email User</th>
                                                <th>Jabatan User</th>
                                                <th>Status User</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    <div class="footer">
        <div class="float-right">
            10GB of <strong>250GB</strong> Free.
        </div>
        <div>
            <strong>Copyright</strong> Futake Indonesia &copy; 2022 (v1.0)
        </div>
    </div>
    </div>
    <div id="right-sidebar">
        <div class="sidebar-container">
            <ul class="nav nav-tabs navs-3">
                <li>
                    <a class="nav-link" data-toggle="tab" href="#tab-3"> <i class="fa fa-gear"></i> </a>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection

@section('script-custom')
<script src="{{asset("/assets/js/highcharts.js")}}"></script>

<script text="text/javascript">
    var total_price_out = <?php echo json_encode($total_price_out) ?>;
    var month_out = <?php echo json_encode($month_out) ?>;
    Highcharts.chart('graph-dashboard-content', {
        title : {
            text : 'Grafik Pengeluaran Bulanan'
        },
        xAxis : {
            categories : month_out
        },
        yAxis : {
            title : {
                text : 'Nominal Pendapatan Bulanan'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect : true
            },
        },
        series : [{
            name : 'Nominal Pendapatan',
            data : total_price_out
        }]
    });
</script>

<script>
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ url('stockout/read') }}",
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
                    "targets": 1, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },
                {
                    "targets": 2, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },

                ],
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'idCustomer', name: 'idCustomer'},
                // {data: 'kodeBlade', name: 'kodeBlade'},
                {data: 'productName', name: 'productName'},
                {data: 'date', name: 'date'},
                {data: 'productStock', name: 'productStock'},
                {data: 'billCustomer', name: 'billCustomer'},
                {data: 'status', name: 'status'},
            ],
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            },
        });

        $(document).on('click', '#delete-btn', function(event) {
            // var id_product = $(this).data('id');
            const id_product = $(event.currentTarget).data('id');
            if (confirm('Apa anda yakin?') == true) {
                $(document).ajaxStop(function(){
                    window.location.reload();
                });
                $.ajax({
                    type:'DELETE',
                    dataType:'json',
                    url:"{{ url('stockin/destroy')}}"+'/'+id_product,
                    data:{"_token": "{{ csrf_token() }}"},
                    success:function(data){
                        location.reload();
                    }
                });
            }
            // var url = '<?= route("products.destroy", '.id_product.') ?>';
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

<script>
    $(function () {
        var table = $('.data-tables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ url('/user') }}",
            },
            autoWidth: false,
            // order: [[1, 'desc']],
            columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                },

                {
                    "targets": 1, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },
                {
                    "targets": 2, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },

                ],
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'id_user', name: 'id_user'},
                {data: 'nama_user', name: 'nama_user'},
                {data: 'email_user', name: 'email_user'},
                {data: 'role_user', name: 'role_user'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        $(document).on('click', '#delete-btn', function(event) {
                // var id_product = $(this).data('id');
                const id_product = $(event.currentTarget).data('id');
                if (confirm('Apa anda yakin?') == true) {
                    $(document).ajaxStop(function(){
                        window.location.reload();
                    });
                    $.ajax({
                        type:'DELETE',
                        dataType:'json',
                        url:"{{ url('/destroy')}}"+'/'+id_product,
                        data:{"_token": "{{ csrf_token() }}"},
                        success:function(data){
                            location.reload();
                        }
                    });
                }
                // var url = '<?= route("products.destroy", '.id_product.') ?>';
            });
    });
</script>

@endsection
