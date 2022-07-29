<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
// use Redirect;

use App\Http\Requests\StockIn\StoreStockInRequest;

use App\Models\Transaction;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Month;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class StockInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $periode = Periode::where('active', 'Y')->get();
        $month = Month::where('active', 'Y')->get();
        if ($periode->count() == 1 && $month->count() == 0) {
            return redirect()->route('month')->send();
        } else if ($periode->count() == 1 && $month->count() == 1) {
            $this->periode = $periode->first();
            $this->month = $month->first();
        } else {
            return redirect()->route('periode')->send();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('read-stockin')) {
            return view('pages.stockin.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-stockin')) {
            $data['parse'] = Transaction::where('type','B')->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->orderBy('created_at','desc')->get();

            return Datatables::of($data['parse'])
                ->addIndexColumn()
                ->addColumn('kodeBlade', function ($data) {
                    $kodeBlade = explode('-', $data->product->kode);
                    // dd($kodeBlade[0]);
                    return $kodeBlade[0];
                })
                ->addColumn('productName', function ($data) {
                    $productName = $data->product->nama_produk;

                    return $productName;
                })
                ->addColumn('idSupplier', function ($data) {
                    $idSupplier = $data->id_supplier == NULL ? '-':$data->supplier->nama_supplier;

                    return  $idSupplier;
                })
                ->addColumn('hargaJual', function ($data) {
                    $hargaJual = $data->product->harga_jual;

                    return number_format($hargaJual);
                })
                ->addColumn('productStock', function ($data) {
                    $productStock = $data->stock;

                    return $productStock;
                })
                ->addColumn('totalPrice', function ($data) {
                    $totalPrice = number_format($data->product->harga_jual * $data->stock);

                    return $totalPrice;
                })
                ->addColumn('check', function ($data) {
                    if ($data->check == 'F') {
                        $check = '<span class="badge badge-danger">GAGAL</span>';
                    } else if ($data->check == 'P') {
                        $check = '<span class="badge badge-warning">PROSES</span>';
                    } else if ($data->check == 'OP') {
                        $check = '<span class="badge badge-success">OPNAME</span>';
                    }else {
                        $check = '<span class="badge badge-primary">SELESAI</span>';
                    }
                    // $check = '<span class="badge badge-'.( $data->check == 'S' ? 'primary' : 'danger' ).'">'.( $data->check == 'S' ? 'SELESAI' : 'PROSES' ).'</span>';

                    return $check;
                })
                ->addColumn('action', function ($data){
                    $btn = '<div style="text-align:center;"><div class="btn-group">';
                    if (Auth::user()->can(['update-stockin','delete-stockin'])) {
                        $btn .= '<a id="edit-btn" href="'.url('stockin/edit/'.$data->id).'" data-url="'.url('stockin/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
                        $btn .= '<a id="delete-btn" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$data->id.'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    } else {
                        $btn = '<a id="none-btn" href="/forbidden" class="btn btn-danger btn-sm" title="'.__('general.none').'" data-toggle="tooltip" data-placement="left"></i>Tidak Tersedia</a> ';
                    }
                    $btn .= '</div></div>';
                    return $btn;
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return redirect('forbidden');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('create-stockin')) {
            $data['product'] = Transaction::with('supplier')->where('type', 'SO')->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->get();
            $data['supplier'] = Supplier::get();
            // dd($data);
            return view('pages.stockin.create', compact('data'));
        } else {
            return redirect('forbidden');
        }
    }

    // public function data($id = null)
    // {
    //     if(Auth::user()->can('')) {
    //         $data = Product::with('supplier')->with('stockin')->findOrFail($id);
    //         dd($data);
    //         return response()->json($data);
    //     } else {
    //         return redirect('forbidden');
    //     }
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('create-stockin')) {
            $key1 = 0;
            $key2 = 0;
            $key3 = 0;
            $key4 = 0;

            // dd($request->all());

            foreach ($request->input('id_product') as $row){
                $wh = Transaction::where('id_product', $request->input('id_product.'.$key1++))->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->where('type','SO')->first();
                // $supp = Transaction::with('supplier', $request->input('id_supplier'))->where('id_periode', $this->periode->id)->where('type','SO')->first();
                // dd($wh);
                if ($wh == NULL) {
                    return redirect(route('stockin'))->with('Error', 'Data Tidak Dapat Ditampilkan! Lakukan Stok Opname Terlebih Dahulu');
                }
                $charges[] = [
                    'id_product'    => $request->input('id_product.'.$key2++),
                    'date'          => $request->input('date'),
                    'id_supplier'   => $wh->supplier->id,
                    'stock'         => $request->input('stock.'.$key3++),
                    'type'          => 'B',
                    'check'         => 'P',
                    'status_bill'   => 'S',
                    'bill'          => 0,
                    'id_customer'   => 0,
                    'id_warehouse'  => $wh->warehouse->id,
                    'id_periode'    => $this->periode->id,
                    'id_month'      => $this->month->id,
                    'user_name'     => Auth::user()->nama
                ];
            }

            Transaction::insert($charges);
            return redirect('stockin')->with('success', 'Stock Masuk Berhasil Ditambahkan');
        } else {
            return redirect('forbidden');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('update-stockin')) {
            $data['parse'] = Transaction::with('supplier')->where('type', 'B')->findOrFail($id);
            $data['supplier'] = Supplier::get();
            $data['product'] = Product::get();

            // dd($data);
            return view('pages.stockin.edit', compact('data'));
        } else {
            return redirect('forbidden');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('update-stockin')) {
            $idx = Transaction::findOrFail($id);
            if ($idx != null) {
                $array_update = [
                    'date'          => $request->input('date'),
                    'stock'         => $request->input('stock'),
                    'check'         => $request->input('check'),
                    'user_name'     => Auth::user()->nama
                ];
                // dd($array_update);
                $idx->update($array_update);
            }
            return redirect('stockin')->with('success', 'Stock Masuk Berhasil Diperbaiki');
        } else {
            return redirect('forbidden');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('delete-stockin')) {
            $id = Transaction::findOrFail($id);
            if ($id != null) {
                $id->delete();
            }

            return redirect('stockin')->with('success', 'Stock Masuk Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
