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
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <h2 class="box-title"><strong>Daftar Produk Keluar (<i>Stock Out</i>)</strong></h2>
                                </div>
                            </div>
                            @if (Auth::user()->can('create-stockout'))
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <a href="{{ route('stockout.create') }}" class="btn btn-primary btn-lg btn-block mt-2"><i class="fa fa-plus"></i> Tambah Data</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-content">

                                        {{-- <div class="row mb-2">
                                            <div class="col-lg-2">
                                                <input class="form-control" type="date" name="min" id="min">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div> --}}
                                        <div class="table-responsive">
                                            <table id="table-content" class="mt-4 table table-hover table-stripped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Customer</th>
                                                        {{-- <th>Kode</th> --}}
                                                        <th>Nama Produk</th>
                                                        <th>Tanggal</th>
                                                        <th>Stok Keluar</th>
                                                        <th>Harga Produk</th>
                                                        <th>Total Harga</th>
                                                        <th>Kekurangan Tagihan</th>
                                                        <th>Status Customer</th>
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
                {
                    "targets": 9, // your case first column
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
                {data: 'idCustomer', name: 'idCustomer'},
                // {data: 'kodeBlade', name: 'kodeBlade'},
                {data: 'productName', name: 'productName'},
                {data: 'date', name: 'date'},
                {data: 'productStock', name: 'productStock'},
                {data: 'hargaJual', name: 'hargaJual'},
                {data: 'totalPrice', name: 'totalPrice'},
                {data: 'billCustomer', name: 'billCustomer'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
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
@endsection
