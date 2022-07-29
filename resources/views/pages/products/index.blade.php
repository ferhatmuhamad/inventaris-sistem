@extends('layouts.default')

@section('content')
    <div class="wrapper wrapper-content">
        {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
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
                        <h2 class="box-title"><strong>Daftar Produk</strong></h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    {{-- <table class="table table-striped"> --}}
                                                    <table id="table-content" class="mt-4 table table-hover table-stripped data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>NO</th>
                                                                <th>Foto</th>
                                                                <th>Kode</th>
                                                                <th>Nama Produk</th>
                                                                <th>Kategori</th>
                                                                <th>Stok</th>
                                                                <th>Harga</th>
                                                                <th>Tanggal</th>
                                                                <th>Kode QR</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        {{-- <tbody>
                                                            @php($i=1)
                                                            @forelse ($items as $item)
                                                                <tr>
                                                                    <td>{{ $i++ }}</td>
                                                                    <td><img class="img-fluid" style="width: 50px" src="{{ $item->photo }}" alt=""></td>
                                                                    @php($kodeBlade = explode('-', $item->kode))
                                                                    <td>{{ $kodeBlade[0] }}</td>
                                                                    <td>{{ $item->nama_produk }}</td>
                                                                    <td>{{ $item->productcategory->nama_kategori }}</td>
                                                                    <td>{{ $item->stock }}</td>
                                                                    <td>{{ number_format($item->harga_jual) }}</td>
                                                                    <td>{{ $item->barang_masuk }}</td>
                                                                    <td><img style="width: 50px" src="{{ $item->kodeqr }}" alt=""></td>
                                                                    <td>
                                                                        <a href="#mymodal"
                                                                        data-remote = "{{ route('products.show', $item->id) }}"
                                                                        data-toggle = "modal"
                                                                        data-target = "#mymodal"
                                                                        data-title = "Detail Produk {{ $item->kode }}"
                                                                        class="btn btn-info btn-sm">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('products.download', $item->id) }}"
                                                                        class="btn btn-success btn-sm">
                                                                            <i class="fa fa-download"></i>
                                                                        </a>
                                                                        <a href="{{ route('products.edit', $item->id) }}"
                                                                            class="btn btn-primary btn-sm">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <form action="{{ route('products.destroy', $item->id) }}"
                                                                            method="POST"
                                                                            class="d-inline"
                                                                            onclick="return confirm('yakin?');">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <button class="btn btn-danger btn-sm">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="12" class="text-center p-5">
                                                                        Data Tidak Tersedia!
                                                                    </td>
                                                                </tr>
                                                            @endforelse
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
                    url : "{{ url('products/data') }}",
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
                    {data: 'imageData', name: 'imageData', orderable: false, searchable: false},
                    {data: 'kodeBlade', name: 'kodeBlade'},
                    {data: 'nama_produk', name: 'nama_produk'},
                    {data: 'productCategory', name: 'productCategory'},
                    {data: 'stock_min', name: 'stock_min'},
                    {data: 'hargaJual', name: 'hargaJual'},
                    {data: 'barang_masuk', name: 'barang_masuk'},
                    {data: 'kodeQr', name: 'kodeQr', orderable: false, searchable: false},
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
                        url:"{{ url('products/destroy')}}"+'/'+id_product,
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
