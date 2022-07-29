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
                                    <h2 class="box-title"><strong>Daftar Produk Masuk (<i>Stock In</i>)</strong></h2>
                                </div>
                            </div>
                            @if (Auth::user()->can('create-stockin'))
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <a href="{{ route('stockin.create') }}" class="btn btn-primary btn-lg btn-block mt-2"><i class="fa fa-plus"></i> Tambah Data</a>
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
                                            <table id="table-content" class="mt-4 table table-hover table-stripped data-table">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Kode</th>
                                                        <th>Nama Produk</th>
                                                        <th>Supplier</th>
                                                        <th>Tanggal</th>
                                                        <th>Harga Produk</th>
                                                        <th>Stok Masuk</th>
                                                        <th>Total Harga</th>
                                                        <th>Status Produk</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if(count($data['parse']) == 0)
                                                    <tr>
                                                        <td colspan="6" class="text-center p-5">
                                                            Data Tidak Tersedia!
                                                        </td>
                                                    </tr>
                                                    @else
                                                    @foreach ($data['parse'] as $item)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item->nama_periode }}</td>
                                                        <td><span class="badge badge-{{ $item->active == 'Y' ? 'success' : 'danger'}}">{{ $item->active == 'Y' ? 'AKTIF' : 'NON-AKTIF'}}</span></td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Grup">
                                                                <a href="{{ route('periode.edit', [$item->id]) }}" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('periode.destroy', [$item->id]) }}"
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
                                                    @endif --}}
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
                url : "{{ url('stockin/read') }}",
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
                    "targets": 3, // your case first column
                    "className": "text-center",
                    "width": "15%"
                },
                {
                    "targets": 5, // your case first column
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
                {data: 'kodeBlade', name: 'kodeBlade'},
                {data: 'productName', name: 'productName'},
                {data: 'idSupplier', name: 'idSupplier'},
                {data: 'date', name: 'date'},
                {data: 'hargaJual', name: 'hargaJual'},
                {data: 'productStock', name: 'productStock'},
                {data: 'totalPrice', name: 'totalPrice'},
                {data: 'check', name: 'check'},
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
