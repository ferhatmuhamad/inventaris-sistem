<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class CustomerController extends Controller
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
        if(Auth::user()->can('read-customer')) {
            return view('pages.customers.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-customer')) {
            $data = Customer::all();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                $btn = '<a id="edit-btn" href="'.url('customers/edit/'.$data->id).'" data-url="'.url('customers/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
                // $btn .= '<a id="delete-btn" href="'.route('customers.destroy', $data->id).'" class="btn btn-danger btn-sm" data-delete="" title="'.__('general.delete').'" onclick="return confirm" data-toggle="tooltip" data-placement="left"><i class="fa fa-trash"></i></a>';
                $btn .= '<a id="delete-btn" href="javascript:void(0);" data-toggle="tooltip" data-id="'.$data->id.'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
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
        if(Auth::user()->can('create-customer')) {
            return view('pages.customers.create');
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
        if(Auth::user()->can('create-customer')) {
            $request->validate([
                'nama_customer'     => 'required|max:255',
                'alamat_customer'   => 'required|max:255',
                'telepon_customer'  => 'required',
            ]);
            $data = [
                'nama_customer' => $request->input('nama_customer'),
                'alamat_customer' => $request->input('alamat_customer'),
                'email_customer' => $request->input('email_customer'),
                'telepon_customer' => $request->input('telepon_customer'),
                'user_name' => Auth::user()->nama
            ];

            Customer::create($data);
            return redirect()->route('customers')->with('success', 'Customer Berhasil Ditambahkan');
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
        if(Auth::user()->can('update-customer')) {
            $item = Customer::findOrFail($id);

            return view('pages.customers.edit')->with([
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
    public function update(CustomerRequest $request, $id)
    {
        if(Auth::user()->can('update-customer')) {
            $request->validate([
                'nama_customer'     => 'required|max:255',
                'alamat_customer'   => 'required|max:255',
                'telepon_customer'  => 'required',
            ]);
            $data = [
                'nama_customer' => $request->input('nama_customer'),
                'alamat_customer' => $request->input('alamat_customer'),
                'email_customer' => $request->input('email_customer'),
                'telepon_customer' => $request->input('telepon_customer'),
                'user_name'        => Auth::user()->nama
            ];
            // $data = $request->all();

            $item = Customer::findOrFail($id);
            $item->update($data);

            return redirect()->route('customers')->with('success', 'Customer Berhasil Diperbarui');
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
        if(Auth::user()->can('delete-customer')) {
            $item = Customer::findOrFail($id);
            $item->delete();

            return redirect()->route('customers')->with('success', 'Customer Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
