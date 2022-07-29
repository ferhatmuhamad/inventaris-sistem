<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use Redirect;

use App\Http\Requests\StockSo\StoreSoRequest;
use App\Http\Requests\StockSo\UpdateSoRequest;
use App\Models\Month;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Periode;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    public function index()
    {
        if(Auth::user()->can('read-dashboard')) {

            // PERIODE
            $data['periode'] = DB::table('periode')->where('active', 'Y')->where('deleted_at', null)->select('nama_periode')->get();
            $data['month'] = DB::table('month')->where('active', 'Y')->where('deleted_at', null)->select('nama_bulan')->get();

            // STOK KELUAR GAGAL
            $data['stockoutf'] = Transaction::where('type','S')->where('check','S')->where('status_bill','F')->where('id_periode', $this->periode->id)->count('id_product');

            // STOK KELUAR PROSES
            $data['stockoutp'] = Transaction::where('type','S')->where('check','S')->where('status_bill','P')->where('id_periode', $this->periode->id)->count('id_product');
            // dd($stockin);

            // STOK KELUAR SELESAI
            $data['stockouts'] = Transaction::where('type','S')->where('check','S')->where('status_bill','S')->where('id_periode', $this->periode->id)->count('id_product');

            $total_price_out = Transaction::where('id_periode', $this->periode->id)
            ->where('type','S')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("CAST(SUM(bill) as int) as totalprice"))
            ->groupBy(DB::raw("Month(date)"))
            ->pluck('totalprice');

            $month_out = Transaction::where('id_periode', $this->periode->id)
            ->where('type','S')
            ->where('check','S')->where('status_bill','S')
            ->select(DB::raw("MONTHNAME(date) as bulanout"))
            ->groupBy(DB::raw("MONTHNAME(date)"))
            ->orderBy('date', 'asc')
            ->pluck('bulanout');

            return view('pages.dashboard',compact('data','total_price_out','month_out'));
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-dashboard')) {
            // Tabel Data
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
                ->escapeColumns([])
                ->make(true);
        } else {
            return redirect('forbidden');
        }
    }

    public function user()
    {
        if(Auth::user()->can('read-all-profile')) {
            $user = Auth::user()->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->select('users.id', 'roles.name','users.nama','users.email')
            ->get();

            return Datatables::of($user)
            ->addIndexColumn()
            ->addColumn('id_user', function ($user) {
                $id_user = $user->id;

                return $id_user;
            })
            ->addColumn('nama_user', function ($user) {
                $nama_user = $user->nama;

                return $nama_user;
            })
            ->addColumn('email_user', function ($user) {
                $email_user = $user->email;

                return $email_user;
            })
            ->addColumn('role_user', function ($user) {
                $role_user = $user->name;

                return $role_user;
            })
            ->addColumn('status', function ($user) {
                $status = '<span class="badge badge-'.( $user->name == 'user' ? 'danger' : 'primary' ).'">'.( $user->name == 'user' ? 'BUTUH VERIFIKASI!' : 'SELESAI VERIFIKASI' ).'</span>';

                return $status;
            })
            ->addColumn('action', function ($user){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                if (Auth::user()->can(['delete-all-profile'])) {
                    $btn .= '<a id="delete-btn" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$user->id.'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('delete-all-profile')) {
            $id = Auth::user()->findOrFail($id);
            // dd($id);
            if ($id != null) {
                $id->delete();
            }

            return redirect('dashboard')->with('success', 'User Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }

}
