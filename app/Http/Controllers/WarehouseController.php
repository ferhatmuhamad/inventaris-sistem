<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Http\Requests\WarehouseRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('read-warehouse')) {
            return view('pages.warehouses.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-warehouse')) {
            $data = Warehouse::all();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                if (Auth::user()->can(['update-warehouse','delete-warehouse'])) {
                    $btn = '<a id="edit-btn" href="'.url('suppliers/edit/'.$data->id).'" data-url="'.url('suppliers/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
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
        if(Auth::user()->can('create-warehouse')) {
            return view('pages.warehouses.create');
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
        if(Auth::user()->can('create-warehouse')) {
            $request->validate([
                'nama_gudang'   => 'required|max:256',
                'alamat_gudang'   => 'required|max:256',
            ]);

            $data = [
                'nama_gudang'   => $request->nama_gudang,
                'alamat_gudang' => $request->alamat_gudang,
                'user_name'     => Auth::user()->nama
            ];
            // $data = $request->all();

            Warehouse::create($data);
            return redirect()->route('warehouses')->with('success', 'Gudang Berhasil Ditambahkan');
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
        if(Auth::user()->can('update-warehouse')) {
            $item = Warehouse::findOrFail($id);

            return view('pages.warehouses.edit')->with([
                'item' => $item,
            ]);
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
        if(Auth::user()->can('update-warehouse')) {
            $request->validate([
                'nama_gudang'   => 'required|max:255',
                'alamat_gudang'   => 'required|max:255',
                'stock_min'     => 'required|integer',
            ]);
            $data = [
                'nama_gudang' => $request->nama_gudang,
                'alamat_gudang' => $request->alamat_gudang,
                'user_name' => Auth::user()->nama
            ];

            $item = Warehouse::findOrFail($id);
            $item->update($data);

            return redirect()->route('warehouses')->with('success', 'Gudang Berhasil Diperbarui');
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
        if(Auth::user()->can('delete-warehouse')) {
            $item = Warehouse::findOrFail($id);
            $item->delete();

            return redirect()->route('warehouses')->with('success', 'Gudang Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
