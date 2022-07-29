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
                                    <h2 class="box-title"><strong>Daftar Periode</strong></h2>
                                </div>
                            </div>
                            @if (Auth::user()->can('create-periode'))
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <a href="{{ route('periode.create') }}" class="btn btn-primary btn-lg btn-block mt-2"><i class="fa fa-plus"></i> Tambah Data</a>
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

                                        <div class="table-responsive">
                                            {{-- <table class="table table-striped"> --}}
                                            <table id="table-content" class="mt-4 table table-hover table-stripped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Nama Periode</th>
                                                        <th>Status Periode</th>
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
                url : "{{ url('periode/data') }}",
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
                    "targets": 0, // your case first column
                    "className": "text-center",
                    "width": "5%"
                },
                {
                    "targets": 3, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },

                ],
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'nama_periode', name: 'nama_periode'},
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
                    url:"{{ url('periode/destroy')}}"+'/'+id_product,
                    data:{"_token": "{{ csrf_token() }}"},
                    success:function(data){
                        location.reload();
                    }
                });
            }
            // var url = '<?= route("products.destroy", '.id_product.') ?>';
        });

        // $(document).on('click', '#delete-btn', function(event) {
        //     // var id_product = $(this).data('id');
        //     const id_product = $(event.currentTarget).data('id');
        //     // confirm('Apa anda yakin?');
        //     swal({
        //         title: 'Delete!',
        //         html: 'Anda ingin menghapus data ini?',
        //         showCancelButton: true,
        //         closeOnConfirm: false,
        //         showLoaderOnConfirm: true,
        //         confirmButtonColor: '#5cb85c',
        //         cancelButtonColor: '#d33',
        //         cancelButtonText: 'Tidak',
        //         confirmButtonText: 'Ya'
        //     },
        //     function(){
        //         $.ajax({
        //             type:'DELETE',
        //             dataType:'json',
        //             url:"{{ url('products/destroy')}}"+'/'+id_product,
        //             data:{"_token": "{{ csrf_token() }}"},
        //             success:function(response){
        //                 swal({
        //                     title: 'Delete!',
        //                     text: 'Produk Telah Dihapus',
        //                     type: 'success',
        //                     timer: 2000,
        //                 });
        //                 // table.draw();
        //                 table.DataTable().ajax.reload(null, false);
        //             },
        //             error: function(error) {
        //                 swal({
        //                     title: 'Error!',
        //                     text: error.responseJSON.message,
        //                     type: 'error',
        //                     timer: 2000,
        //                 });
        //             },
        //         });
        //     });
        // });

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
