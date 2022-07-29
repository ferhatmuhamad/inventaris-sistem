@extends('layouts.default')

@section('style-custom')
<link rel="stylesheet" href="{{asset("https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css")}}">
@endsection

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>Tambah Data Stok Masuk</strong></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        {{-- =============== FORM =============== --}}
                        <form action="{{ route('stockin.store') }}" method="POST">
                            @csrf
                            <div class="container wrap mb-5">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Tanggal</label>
                                        <input type="date" name="date" class="form-control">
                                    </div>
                                </div>
                                <div class="clone">
                                    <div id="clone1">
                                        <div class="row input_fields_wrap">
                                            <div class="col-md-10 mb-3">
                                                <label for="">Pilih Barang</label>
                                                <select name="id_product[]" id="id_product" class="form-control @error('id_product') is-invalid @enderror" required data-live-search="true">
                                                    @if ($data['product']->count() == 0)
                                                        <option value="">Belum Ada Satuan Barang</option>
                                                    @else
                                                        <option value="">-- Pilih --</option>
                                                        @foreach ($data['product'] as $product)
                                                        @php($kodeBlade = explode('-', $product->product->kode))
                                                            <option value="{{$product->id_product}}">{{$kodeBlade[0]}} | {{$product->product->nama_produk}} | STOK :{{$product->total_stock()}} | Rp {{number_format($product->product->harga_jual)}} | Supplier {{$product->supplier->nama_supplier}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('id_product') <div class="text-muted">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="">Stok Produk</label>
                                                <input type="number" min="1" name="stock[]" id="stock" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col md-12">
                                        <a href="#" class="btn btn-danger remove_field">Hapus</a>
                                        <button class="btn btn-primary add_field_button">Tambah Barang</button>
                                        <button id="proses_button" class="btn btn-success">Proses</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- =============== END FORM =============== --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-custom')

{{-- SELECT LIVE SEARCH --}}
<script src="{{asset("https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js")}}"></script>

<script>
    $(document).ready(function() {
        $('select').selectpicker();
    })
</script>

<script type="text/javascript">

    $(document).ready(function() {
        var max_fields      = 20; //maximum input boxes allowed
        var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count


        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){
                x++;
                // let wrapper_w = $(wrapper).clone().appendTo('.clone').attr('id', 'clone' + cloneCount);
                $(wrapper).clone().appendTo('.clone');
            }
            // cloneCount++
        });


        $('.wrap').on("click",".remove_field", function(){
            //alert('ok');
            $('.wrap').find('.input_fields_wrap').not(':first').last().remove();
        });
    });

    </script>
@endsection
