<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonthRequest;
use App\Http\Requests\UpdateMonthRequest;
use App\Models\Month;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MonthController extends Controller
{
    private $home, $current, $periode;

    public function __construct()
    {
        $this->middleware('auth');
        $periode = Periode::where('active', 'Y')->get();
        if ($periode->count() == 1) {
            $this->periode = $periode->first();
        } else {
            return redirect('periode')->send();
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('read-month')) {
            return view('pages.month.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-month')) {
            $data = Month::where('id_periode', $this->periode->id)->orderBy('created_at', 'desc')->get();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                $status = '<span class="badge badge-'.( $data->active == 'Y' ? 'success' : 'danger' ).'">'.( $data->active == 'Y' ? 'AKTIF' : 'NON-AKTIF' ).'</span>';
                // dd($status);
                return $status;
            })
            ->addColumn('action', function ($data){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                if (Auth::user()->can(['update-month','delete-month'])) {
                    $btn = '<a id="edit-btn" href="'.url('month/edit/'.$data->id).'" data-url="'.url('month/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
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
        if(Auth::user()->can('create-month')) {
            return view('pages.month.create');
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
        if(Auth::user()->can('create-month')) {
            $array_update = [
                'active' => 'N',
            ];

            $x = Month::where('active', 'Y');
            if ($x->count() > 0) {
                $x->update($array_update);
            }

            $data               = new Month();
            $data->nama_bulan = $request->input('nama_bulan');
            $data->id_periode = $this->periode->id;
            $data->active       = 'Y';
            $data->save();

            return redirect()->route('month')->with('success', 'Periode Bulan Berhasil Ditambahkan');
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
        if(Auth::user()->can('update-month')) {
            $data = Month::findOrFail($id);
            if ($data == null) {
                echo 'Maaf Data Tidak Ada!';
            }
            return view('pages.month.edit', compact('data'));
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
        if(Auth::user()->can('update-month')) {
            $x = Month::findOrFail($id);
            if ($request->input('active') == $x->active) {
                $array_update = [
                    'nama_bulan' => $request->input('nama_bulan')
                ];
                if ($x->count() > 0) {
                    $x->update($array_update);
                } else {
                    return redirect($this->current);
                }
            } else {
                $array_update = [
                    'nama_bulan' => $request->input('nama_bulan'),
                    'active' => $request->input('active')
                ];
                $up = Month::where('active', 'Y');
                if ($request->input('active') == 'Y') {
                    $up->update(['active' => 'N']);
                    $x->update($array_update);
                } else {
                    $x->update($array_update);
                }
            }
            return redirect()->route('month')->with('success', 'Periode Bulan Berhasil Diperbarui');
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
        if(Auth::user()->can('delete-month')) {
            $user = Month::findOrFail($id);
            if ($user != null) {
                $user->delete();
            }
            return redirect()->route('month')->with('success', 'Periode Bulan Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
