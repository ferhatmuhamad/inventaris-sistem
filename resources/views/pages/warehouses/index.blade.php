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
                        <h2 class="box-title"><strong>Daftar Gudang</strong></h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <div class="table-responsive">
                                            {{-- <table class="table table-striped"> --}}
                                            <table id="table-content" class="mt-4 table table-hover table-stripped data-table" data-page-size="10">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Nama Gudang</th>
                                                        <th>Alamat Gudang</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                {{-- <tbody>
                                                    @forelse ($items as $item)
                                                        <tr>
                                                            <td>{{ $item->id }}</td>
                                                            <td>{{ $item->nama_gudang }}</td>
                                                            <td>{{ $item->alamat_gudang }}</td>
                                                            <td>{{ $item->email_gudang }}</td>
                                                            <td>{{ $item->telepon_gudang }}</td>
                                                            <td>
                                                                <a href="{{ route('warehouses.edit', $item->id) }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('warehouses.destroy', $item->id) }}"
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
                                                            <td colspan="6" class="text-center p-5">
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
@endsection

@section('script-custom')
    <script>
        $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ url('warehouses/data') }}",
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
                    "targets": 1, // your case first column
                    "className": "text-center",
                    "width": "40%"
                },
                {
                    "targets": 2, // your case first column
                    "className": "text-center",
                    "width": "40%"
                },

                ],
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'nama_gudang', name: 'nama_gudang'},
                {data: 'alamat_gudang', name: 'alamat_gudang'},
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
                        url:"{{ url('warehouses/destroy')}}"+'/'+id_product,
                        data:{"_token": "{{ csrf_token() }}"},
                        success:function(data){
                            location.reload();
                        }
                    });
                }
                // var url = '<?= route("products.destroy", '.id_product.') ?>';
            });

        // $('#filter').click(function(){
        //     table.draw();
        // });

        // $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

        // $('.data-search').on('keyup', function() {
        //     table.search(this.value).draw();
        // });
    });
    </script>
@endsection
