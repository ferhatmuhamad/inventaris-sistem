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
                        <h2 class="box-title"><strong>Daftar Seluruh User</strong></h2>
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
            </div>
        </div>
    </div>
@endsection

@section('script-custom')
<script>
    $(function () {
        var table = $('.data-tables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ url('alluser/data') }}",
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
