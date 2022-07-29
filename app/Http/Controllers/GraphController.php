<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Redirect;

use App\Http\Requests\StockSo\StoreSoRequest;
use App\Http\Requests\StockSo\UpdateSoRequest;
use App\Models\Month;
use App\Models\Transaction;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
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
        if(Auth::user()->can('read-graph')) {
            // STOCKOUT
            $data['total_price_out'] = Transaction::where('id_periode', $this->periode->id)
            ->where('id_month', $this->month->id)
            ->where('type','S')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("CAST(SUM(bill) as int) as totalprice"))
            ->groupBy(DB::raw("Month(date)"))
            ->pluck('totalprice');

            $data['month_out'] = Transaction::where('id_periode', $this->periode->id)
            ->where('id_month', $this->month->id)
            ->where('type','S')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("MONTHNAME(date) as bulanout"))
            ->groupBy(DB::raw("MONTHNAME(date)"))
            ->pluck('bulanout');

            // STOCKOPNAME
            $data['total_product_opname'] = Transaction::where('id_periode', $this->periode->id)
            ->where('id_month', $this->month->id)
            ->where('type','SO')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("CAST(COUNT(id_product) as int) as totalopname"))
            ->groupBy(DB::raw("Month(date)"))
            ->pluck('totalopname');

            $data['month_opname'] = Transaction::where('id_periode', $this->periode->id)
            ->where('id_month', $this->month->id)
            ->where('type','SO')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("MONTHNAME(date) as bulanopname"))
            ->pluck('bulanopname');

            // STOCKIN
            $data['total_product_in'] = Transaction::where('id_periode', $this->periode->id)
            ->where('id_month', $this->month->id)
            ->where('type','B')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("CAST(COUNT(id_product) as int) as totalin"))
            ->groupBy(DB::raw("Month(date)"))
            ->pluck('totalin');

            $data['month_in'] = Transaction::where('id_periode', $this->periode->id)
            ->where('id_month', $this->month->id)
            ->where('type','B')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("MONTHNAME(date) as bulanin"))
            ->pluck('bulanin');

            return view('pages.graph', compact('data'));
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
