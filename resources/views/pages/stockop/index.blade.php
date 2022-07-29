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
                                    <h2 class="box-title"><strong>Daftar Cek Stok (<i>Stock Opname</i>)</strong></h2>
                                </div>
                            </div>
                            @if (Auth::user()->can('create-stockopname'))
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <a href="{{ route('stockopname.create') }}" class="btn btn-primary btn-lg btn-block mt-2"><i class="fa fa-plus"></i> Tambah Data</a>
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
                                            <table id="table-content" class="mt-4table table-hover table-stripped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Kode</th>
                                                        <th>Nama Produk</th>
                                                        <th>Harga</th>
                                                        <th>Tanggal</th>
                                                        <th>Stok Masuk (Proses)</th>
                                                        <th>Stok Gudang</th>
                                                        <th>Gudang</th>
                                                        <th>Keterangan</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                {{-- <tbody>
                                                    @if(count($data['parse']) == 0)
                                                    <tr>
                                                        <td colspan="12" class="text-center p-5">
                                                            Data Tidak Tersedia!
                                                        </td>
                                                    </tr>
                                                    @else
                                                    @foreach ($data['parse'] as $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>@php($kodeBlade = explode('-', $item->product->kode))
                                                        <td>{{ $kodeBlade[0] }}</td>
                                                        <td>{{ $item->product->nama_produk }}</td>
                                                        <td>{{ $item->product->harga_jual }}</td>
                                                        <td>{{ $item->date }}</td>
                                                        <td>{{ $item->product->stock }}</td>
                                                        <td>{{ $item->stock }}</td>
                                                        <td>{{ $item->id_warehouse == NULL ? '-':$item->warehouse->nama_gudang }}</td>
                                                        <td><span class="badge badge-{{ $item->product->stock == $item->stock ? 'primary' : 'danger'}}">{{ $item->product->stock == $item->stock ? 'AMAN' : 'PERLU TINDAKAN'}}</span></td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Grup">
                                                                <a href="{{ route('stockopname.edit', [$item->id]) }}" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('stockopname.destroy', [$item->id]) }}"
                                                                    method="POST"
                                                                    class="d-inline"
                                                                    onclick="return confirm('yakin?');">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody> --}}
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
                url : "{{ url('stockopname/read') }}",
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
                    "targets": 2, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },
                {
                    "targets": 7, // your case first column
                    "className": "text-center",
                    "width": "20%"
                },

                ],
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'kodeBlade', name: 'kodeBlade'},
                {data: 'productName', name: 'productName'},
                {data: 'hargaJual', name: 'hargaJual'},
                {data: 'date', name: 'date'},
                {data: 'stock_check', name: 'stock_check'},
                {data: 'stock_op', name: 'stock_op'},
                {data: 'idWarehouse', name: 'idWarehouse'},
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
                    url:"{{ url('stockopname/destroy')}}"+'/'+id_product,
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
