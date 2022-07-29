<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Month;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
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
        if(Auth::user()->can('read-stockreport')) {
            $data['periode'] = $this->periode;
            $data['month'] = $this->month;
            return view('pages.stockreports.index', compact('data'));
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-stockreport')) {
            $data['periode'] = $this->periode;
            $x = Transaction::where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->where('type','SO') ->get();
            $data['parse'] = $x->groupBy('id_product');
            $data['warehouse'] = Warehouse::get();

            return Datatables::of($x)
                ->addIndexColumn()
                ->addColumn('imageData', function ($data) {
                    $imageData = '<img class="img-fluid" style="width: 50px" src="'.url( $data->product->photo ).'" alt="">';

                    return $imageData;
                })
                ->addColumn('kodeBlade', function ($data) {
                    $kodeBlade = explode('-', $data->product->kode);

                    return $kodeBlade[0];
                })
                ->addColumn('productName', function ($data) {
                    $productName = $data->product->nama_produk;

                    return $productName;
                })
                ->addColumn('hargaJual', function ($data) {
                    $hargaJual = $data->product->harga_jual;

                    return number_format($hargaJual);
                })
                ->addColumn('stockMin', function ($data) {
                    $stockMin = $data->product->stock_min;

                    return $stockMin;
                })
                ->addColumn('stockWarehouse', function ($data) {
                    // $stockWarehouse = DB::table('transaction')->where('id_product', $data->id_product)->where('check', 'S')->where('status_bill', 'F')->where('deleted_at', null)->sum('stock');
                    $stockWarehouse = $data->total_stock();

                    return $stockWarehouse;
                })
                ->addColumn('warehouse', function ($data) {
                    $warehouse = $data->warehouse->nama_gudang;

                    return $warehouse;
                })
                ->addColumn('status', function ($data) {
                    $totalStock = $data->total_stock();
                    $status = '<span class="badge badge-'.( $totalStock >= $data->product->stock_min ? 'primary' : 'danger' ).'">'.( $totalStock >= $data->product->stock_min ? 'AMAN' : 'BAHAYA' ).'</span>';

                    return $status;
                })
                ->addColumn('action', function ($data){
                    $kodeBlade = explode('-', $data->product->kode);
                    $btn = '<div style="text-align:center;"><div class="btn-group">';
                    $btn = '<a id="show-btn" href="#mymodal" data-remote="'.url('stockreport/show/'.$data->id).'" class="btn btn-info btn-sm" data-title="Detail Laporan Stock ('.$kodeBlade[0].')" title="'.__('Show').'" data-toggle="modal" data-target="#mymodal"  data-placement="left"><i class="fa fa-eye"></i></a> ';
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can('read-stockreport')) {
            $data['parse'] = Transaction::with('customer')->where('check', 'S')->findOrFail($id);
            $data['stockwarehouse'] = Transaction::where('id_product', $data['parse']->id_product)->where('check', 'S')->where('status_bill', 'S')->where('deleted_at', null)->sum('stock');
            $data['stockin'] = Transaction::where('id_product', $data['parse']->id_product)->where('type','B')->where('check','S')->where('deleted_at', null)->select('stock')->orderBy('created_at','desc')->sum('stock');
            $data['stockout'] = Transaction::where('id_product', $data['parse']->id_product)->where('type','S')->where('check','S')->where('status_bill', 'S')->where('deleted_at', null)->select('stock')->orderBy('created_at','desc')->sum('stock');
            // $data['totalstock'] = Transaction::where('id_product', $data['parse']->id_product)->where('check','S')->where('status_bill', 'F')->where('deleted_at', null)->select('stock')->orderBy('created_at','desc')->sum('stock');

            return view('pages.stockreports.show', compact('data'));
        } else {
            return redirect('forbidden');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
