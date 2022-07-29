<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Redirect;

use App\Http\Requests\StockSo\StoreSoRequest;
use App\Http\Requests\StockSo\UpdateSoRequest;

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

class StockOpController extends Controller
{
    private $periode, $month;

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
        if(Auth::user()->can('read-stockopname')) {
            return view('pages.stockop.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-stockopname')) {
            $data['parse'] = Transaction::where('type','SO')->where('check','S')->where('status_bill', 'S')->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->orderBy('created_at','desc')->get();

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
                ->addColumn('hargaJual', function ($data) {
                    $hargaJual = $data->product->harga_jual;

                    return number_format($hargaJual);
                })
                ->addColumn('stock_check', function ($data) {
                    $stock_check = DB::table('transaction')->where('id_product', $data->id_product)->where('type','B')->where('check', 'P')->orWhere('check', 'OP')->where('status_bill','S')->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->where('deleted_at', null)->sum('stock');
                    // dd($stock_check);
                    return $stock_check;
                })
                ->addColumn('stock_op', function ($data) {
                    // $stock_op = DB::table('transaction')->where('id_product', $data->id_product)->where('type', '!=', 'S')->where('check', 'S')->where('status_bill', 'S')->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->where('deleted_at', null)->sum('stock');
                    $stock_op = $data->total_stock();
                    return $stock_op;
                })
                ->addColumn('idWarehouse', function ($data) {
                    $idWarehouse = $data->id_warehouse == NULL ? '-':$data->warehouse->nama_gudang;

                    return  $idWarehouse;
                })
                ->addColumn('status', function ($data) {
                    $stock_check = DB::table('transaction')->where('id_product', $data->id_product)->where('check', 'P')->where('deleted_at', null)->sum('stock');
                    $status = '<span class="badge badge-'.( $stock_check == 0 ? 'primary' : 'danger' ).'">'.( $stock_check == 0 ? 'SELESAI PENGECEKAN' : 'PROSES PENGECEKAN' ).'</span>';

                    return $status;
                })
                ->addColumn('action', function ($data){
                    $btn = '<div style="text-align:center;"><div class="btn-group">';
                    if (Auth::user()->can(['delete-stockopname','update-stockopname'])) {
                        $btn .= '<a id="edit-btn" href="'.url('stockopname/edit/'.$data->id).'" data-url="'.url('stockopname/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
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
        if(Auth::user()->can('create-stockopname')) {
            $data['periode'] = $this->periode;
            $data['parse'] = Transaction::with('supplier')->where('type','SO')->where('id_periode',$this->periode->id)->where('id_month', $this->month->id)->get();
            $data['warehouse'] = Warehouse::get();
            $data['supplier'] = Supplier::get();
            if ($data['parse']->count() == 0) {
                $data['product'] = Product::get();
            } else {
                foreach ($data['parse'] as $id) {
                    $ids[] = $id->id_product;
                }
                $data['product'] = Product::whereNotIn('id',$ids)->get();
            }
            return view('pages.stockop.create',compact('data'));
        } else {
            return redirect('forbidden');
        }
    }

    public function data($id = null)
    {
        if(Auth::user()->can('create-stockopname')) {
            $data = Product::with('supplier')->findOrFail($id);

            return response()->json($data);
        } else {
            return redirect('forbidden');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSoRequest $request)
    {
        if(Auth::user()->can('create-stockopname')) {
            $item               = new Transaction;
            $item->id_product   = $request->input('id_product');
            $item->date         = Carbon::now()->format('Y-m-d');
            $item->stock        = $request->input('stock');
            $item->type         = 'SO';
            $item->check        = 'S';
            $item->status_bill  = 'S';
            $item->bill         = 0;
            $item->id_customer  = 0;
            $item->id_supplier  = $request->input('id_supplier');
            $item->id_warehouse = $request->input('id_warehouse');
            $item->id_periode   = $this->periode->id;
            $item->id_month     = $this->month->id;
            $item->save();

            return redirect(route('stockopname'))->with('success', 'Stock Opname Berhasil Ditambahkan');
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
        if(Auth::user()->can('update-stockopname')) {
            $data['parse'] = Transaction::findOrFail($id);
            $data['warehouse'] = Warehouse::get();
            $data['supplier'] = Supplier::get();
            $data['product'] = Product::get();

            return view('pages.stockop.edit',compact('data'));
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
    public function update(UpdateSoRequest $request, $id)
    {
        if(Auth::user()->can('update-stockopname')) {
            $idx = Transaction::findOrFail($id);
            if ($idx != null) {
                $array_update = [
                    'stock'         => $request->input('stock'),
                    'id_warehouse'  => $request->input('id_warehouse')
                ];
                $idx->update($array_update);
            }
            return redirect('stockopname')->with('success', 'Stock Opname Berhasil Diperbaiki');
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
        if(Auth::user()->can('delete-stockopname')) {
            $idx = Transaction::findOrFail($id);

            if ($idx != null) {
                $idx->delete();
            }
            return redirect('stockopname')->with('success', 'Stock Opname Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
