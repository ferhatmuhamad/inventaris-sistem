<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Periode\StorePeriodeRequest;
use App\Http\Requests\Periode\UpdatePeriodeRequest;
use Yajra\Datatables\Datatables;

use App\Models\Periode;
use Illuminate\Support\Facades\Auth;

class PeriodeController extends Controller
{
    private $home, $current;

    public function __construct()
    {
        $this->middleware('auth');
        $this->home = route('dashboard');
        $this->current = route('periode');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('read-periode')) {
            return view('pages.periode.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-periode')) {
            $data = Periode::orderBy('created_at', 'desc')->get();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                $status = '<span class="badge badge-'.( $data->active == 'Y' ? 'success' : 'danger' ).'">'.( $data->active == 'Y' ? 'AKTIF' : 'NON-AKTIF' ).'</span>';
                // dd($status);
                return $status;
            })
            ->addColumn('action', function ($data){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                if (Auth::user()->can(['update-periode','delete-periode'])) {
                    $btn = '<a id="edit-btn" href="'.url('periode/edit/'.$data->id).'" data-url="'.url('periode/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
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
        if(Auth::user()->can('create-periode')) {
            return view('pages.periode.create');
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
    public function store(StorePeriodeRequest $request)
    {
        if(Auth::user()->can('create-periode')) {
            $array_update = [
                'active' => 'N',
            ];

            $x = Periode::where('active', 'Y');
            if ($x->count() > 0) {
                $x->update($array_update);
            }

            $data               = new Periode;
            $data->nama_periode = $request->input('nama_periode');
            $data->active       = 'Y';
            $data->user_name    = Auth::user()->nama;
            $data->save();

            return redirect()->route('periode')->with('success', 'Periode Berhasil Ditambahkan');
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
        if(Auth::user()->can('update-periode')) {
            $data = Periode::findOrFail($id);
            if ($data == null) {
                echo 'Maaf Data Tidak Ada!';
            }
            return view('pages.periode.edit', compact('data'));
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
    public function update(UpdatePeriodeRequest $request, $id)
    {
        if(Auth::user()->can('update-periode')) {
            $x = Periode::findOrFail($id);
            if ($request->input('active') == $x->active) {
                $array_update = [
                    'nama_periode' => $request->input('nama_periode')
                ];
                if ($x->count() > 0) {
                    $x->update($array_update);
                } else {
                    return redirect($this->current);
                }
            } else {
                $array_update = [
                    'nama_periode' => $request->input('nama_periode'),
                    'active' => $request->input('active')
                ];
                $up = Periode::where('active', 'Y');
                if ($request->input('active') == 'Y') {
                    $up->update(['active' => 'N']);
                    $x->update($array_update);
                } else {
                    $x->update($array_update);
                }
            }
            return redirect()->route('periode')->with('success', 'Periode Berhasil Diperbarui');
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
        if(Auth::user()->can('delete-periode')) {
            $user = Periode::findOrFail($id);
            if ($user != null) {
                $user->delete();
            }
            return redirect()->route('periode')->with('success', 'Periode Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
