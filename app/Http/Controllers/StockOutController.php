<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
// use Redirect;

use App\Http\Requests\Stockout\StoreStockoutRequest;

use App\Models\Transaction;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Month;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\Datatables\Datatables;

class StockOutController extends Controller
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
        if(Auth::user()->can('read-stockout')) {
            return view('pages.stockout.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-stockout')) {
            $data['parse'] = Transaction::where('type','S')->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->orderBy('created_at','desc')->get();

            return Datatables::of($data['parse'])
                ->addIndexColumn()
                ->addColumn('idCustomer', function ($data) {
                    $idCustomer = $data->id_customer == NULL ? '-':$data->customer->nama_customer;

                    return  $idCustomer;
                })
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
                ->addColumn('productStock', function ($data) {
                    $productStock = $data->stock*-1;

                    return $productStock;
                })
                ->addColumn('totalPrice', function ($data) {
                    $totalPrice = number_format($data->product->harga_jual * $data->stock*-1);

                    return $totalPrice;
                })
                ->addColumn('billCustomer', function ($data) {
                    $totalPrice = $data->product->harga_jual * $data->stock*-1;
                    $billCustomer = number_format($totalPrice - $data->bill);

                    return $billCustomer;
                })
                ->addColumn('status', function ($data) {
                    $totalPrice = $data->product->harga_jual * $data->stock;
                    $billCustomer = number_format($totalPrice - $data->bill);

                    if ($data->status_bill == 'F') {
                        $status = '<span class="badge badge-danger">GAGAL</span>';
                    } else if ($data->status_bill == 'P') {
                        $status = '<span class="badge badge-warning">PROSES</span>';
                    } else {
                        $status = '<span class="badge badge-primary">SELESAI</span>';
                    }
                    // $status = '<span class="badge badge-'.( $billCustomer == 0 ? 'primary' : 'danger' ).'">'.( $billCustomer == 0 ? 'SELESAI' : 'PROSES' ).'</span>';

                    return $status;
                })
                ->addColumn('action', function ($data){
                    $btn = '<div style="text-align:center;"><div class="btn-group">';
                    $btn = '<a id="show-btn" href="#mymodal" data-remote="'.url('stockout/show/'.$data->id).'" class="btn btn-info btn-sm" data-title="Detail Transaksi ('.$data->customer->nama_customer.')" title="'.__('Show').'" data-toggle="modal" data-target="#mymodal"  data-placement="left"><i class="fa fa-eye"></i></a> ';
                    if (Auth::user()->can(['update-stockout','delete-stockout'])) {
                        $btn .= '<a id="edit-btn" href="'.url('stockout/edit/'.$data->id).'" data-url="'.url('stockout/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
                        $btn .= '<a id="delete-btn" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$data->id.'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
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
        if(Auth::user()->can('create-stockout')) {
            $data['product'] = Transaction::with('customer')->where('type', 'SO')->where('check', 'S')->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->get();
            $data['customer'] = Customer::get();
            // dd($data);
            return view('pages.stockout.create', compact('data'));
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
    public function store(Request $request)
    {
        if(Auth::user()->can('create-stockout')) {
            $key1 = 0;
            $key2 = 0;
            $key3 = 0;
            $key4 = 0;
            $key5 = 0;
            $key6 = 0;
            $key7 = 0;

            // dd($request->all());

            foreach ($request->input('id_product') as $row){
                $wh = Transaction::where('id_product', $request->input('id_product.'.$key1++))->where('id_periode', $this->periode->id)->where('id_month', $this->month->id)->where('type','SO')->where('check','S')->first();
                $totalPrice = $wh->product->harga_jual * $request->input('stock.'.$key6++);
                // dd($totalPrice);
                if ($wh->total_stock() < $request->input('stock.'.$key5++)) {
                    Alert::error('Oops..','Stok ' . $wh->product->nama_produk . ' Melebihi Batas');
                    return redirect('stockout');
                } else {
                    if ($wh == NULL) {
                        return redirect(route('stockout'))->with('Error', 'Data Tidak Dapat Ditampilkan! Lakukan Stok Opname Terlebih Dahulu');
                    }
                    if ($totalPrice == $request->input('bill.'.$key7++)) {
                        $charges[] = [
                            'id_product'    => $request->input('id_product.'.$key2++),
                            'date'          => $request->input('date'),
                            'id_supplier'   => $wh->id_supplier,
                            'stock'         => $request->input('stock.'.$key3++)*-1,
                            'type'          => 'S',
                            'check'         => 'S',
                            'status_bill'   => 'S',
                            'bill'          => $request->input('bill.'.$key4++),
                            'id_customer'   => $request->input('id_customer'),
                            'id_warehouse'  => $wh->warehouse->id,
                            'id_periode'    => $this->periode->id,
                            'id_month'      => $this->month->id
                        ];
                    } else {
                        $charges[] = [
                            'id_product'    => $request->input('id_product.'.$key2++),
                            'date'          => $request->input('date'),
                            'id_supplier'   => $wh->id_supplier,
                            'stock'         => $request->input('stock.'.$key3++)*-1,
                            'type'          => 'S',
                            'check'         => 'S',
                            'status_bill'   => 'P',
                            'bill'          => $request->input('bill.'.$key4++),
                            'id_customer'   => $request->input('id_customer'),
                            'id_warehouse'  => $wh->warehouse->id,
                            'id_periode'    => $this->periode->id,
                            'id_month'      => $this->month->id
                        ];
                    }
                }
            }
            // dd($charges);
            Transaction::insert($charges);
            Alert::success('Hore!', 'Stok Keluar Berhasil Ditambahkan');
            return redirect('stockout');
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
        if(Auth::user()->can('read-stockout')) {
            $data['parse'] = Transaction::with('customer')->where('type', 'S')->where('check', 'S')->findOrFail($id);
            // $data['product'] = Product::with('productcategory')->with('supplier')->findOrFail($id);
            $data['customer'] = Customer::get();

            return view('pages.stockout.show', compact('data'));
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
        if(Auth::user()->can('update-stockout')) {
            $data['parse'] = Transaction::with('customer')->where('type', 'S')->where('check', 'S')->findOrFail($id);
            $data['customer'] = Customer::get();
            $data['product'] = Product::get();

            // dd($data);
            return view('pages.stockout.edit', compact('data'));
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
        if(Auth::user()->can('update-stockout')) {
            $wh = Transaction::with('product')->find($id);
            $totalPrice = $wh->product->harga_jual * $wh->stock*-1;

            $idx = Transaction::findOrFail($id);
            if ($idx != null) {
                $array_update = [
                    'date'          => $request->input('date'),
                    'stock'         => $request->input('stock'),
                    'status_bill'   => $request->input('status_bill'),
                    'bill'          => $request->input('bill'),
                ];
                // dd($array_update);
                if ($request->status_bill == 'S') {
                    $idx->bill = $totalPrice;
                }
                $idx->update($array_update);
            }
            return redirect('stockout')->with('success', 'Stock Keluar Berhasil Diperbaiki');
        } else {
            return redirect('forbidden');
        }
    }

    public function setstatus(Request $request, $id)
    {
        if(Auth::user()->can('update-stockout')) {
            $wh = Transaction::with('product')->find($id);
            $totalPrice = $wh->product->harga_jual * $wh->stock*-1;

            $request->validate([
                'status_bill' => 'required|in:F,P,S'
            ]);

            $data = Transaction::findOrFail($id);
            $data->status_bill = $request->status_bill;

            if ($request->status_bill == 'S') {
                $data->bill = $totalPrice;
            }

            $data->save();
            Alert::success('Hore!', 'Status Telah Diperbaiki');
            return redirect('stockout');
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
        if(Auth::user()->can('delete-stockout')) {
            $id = Transaction::findOrFail($id);
            if ($id != null) {
                $id->delete();
            }

            return redirect('stockout')->with('success', 'Stock Keluar Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
