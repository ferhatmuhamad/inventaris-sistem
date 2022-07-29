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
                        <h2 class="box-title"><strong>Daftar Produk Kategori</strong></h2>
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
                                                        <th>Nama Kategori</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                {{-- <tbody>
                                                    @forelse ($items as $item)
                                                        <tr>
                                                            <td>{{ $item->id }}</td>
                                                            <td>{{ $item->nama_kategori }}</td>
                                                            <td>
                                                                <a href="{{ route('productcategory.edit', $item->id) }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('productcategory.destroy', $item->id) }}"
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
                    url : "{{ url('productcategory/data') }}",
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
                        "width": "50%"
                    },
                    {
                        "targets": 2, // your case first column
                        "className": "text-center",
                        "width": "50%"
                    },

                    ],
                columns: [
                    {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false },
                    {data: 'nama_kategori', name: 'nama_kategori'},
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
                        url:"{{ url('productcategory/destroy')}}"+'/'+id_product,
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
