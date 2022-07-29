<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class SupplierController extends Controller
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
        if(Auth::user()->can('read-supplier')) {
            return view('pages.suppliers.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-supplier')) {
            $data = Supplier::all();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                if (Auth::user()->can(['update-supplier','delete-supplier'])) {
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
        if(Auth::user()->can('create-supplier')) {

        } else {
            return redirect('forbidden');
        }
        return view('pages.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('create-supplier')) {
            $request->validate([
                'nama_supplier'     => 'required|max:255',
                'alamat_supplier'   => 'required|max:255',
                'email_supplier'    => 'required',
                'telepon_supplier'  => 'required'
            ]);
            $data = [
                'nama_supplier'     => $request->nama_supplier,
                'alamat_supplier'   => $request->alamat_supplier,
                'email_supplier'    => $request->email_supplier,
                'telepon_supplier'  => $request->telepon_supplier,
                'user_name'         => Auth::user()->nama
            ];
            // $data = $request->all();

            Supplier::create($data);
            return redirect()->route('suppliers')->with('success', 'Supplier Berhasil Ditambahkan');
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
        if(Auth::user()->can('update-supplier')) {
            $item = Supplier::findOrFail($id);

            return view('pages.suppliers.edit')->with([
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
        if(Auth::user()->can('update-supplier')) {
            $request->validate([
                'nama_supplier'     => 'required|max:255',
                'alamat_supplier'   => 'required|max:255',
                'email_supplier'    => 'required',
                'telepon_supplier'  => 'required|max:255'
            ]);
            $data = [
                'nama_supplier'     => $request->nama_supplier,
                'alamat_supplier'   => $request->alamat_supplier,
                'email_supplier'    => $request->email_supplier,
                'telepon_supplier'  => $request->telepon_supplier,
                'user_name'         => Auth::user()->nama
            ];

            $item = Supplier::findOrFail($id);
            $item->update($data);

            return redirect()->route('suppliers')->with('success', 'Supplier Berhasil Diperbarui');
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
        if(Auth::user()->can('delete-supplier')) {
            $item = Supplier::findOrFail($id);
            $item->delete();

            return redirect()->route('suppliers')->with('success', 'Supplier Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
