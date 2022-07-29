<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class ProductCategoryController extends Controller
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
        if(Auth::user()->can('read-product-category')) {
            return view('pages.productcategory.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read()
    {
        if(Auth::user()->can('read-product-category')) {
            $data = ProductCategory::all();

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                $btn = '<div style="text-align:center;"><div class="btn-group">';
                if (Auth::user()->can(['update-product-category','delete-product-category'])) {
                    $btn = '<a id="edit-btn" href="'.url('productcategory/edit/'.$data->id).'" data-url="'.url('productcategory/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
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
        if(Auth::user()->can('create-product-category')) {
            return view('pages.productcategory.create');
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
    public function store(ProductCategoryRequest $request)
    {
        if(Auth::user()->can('create-product-category')) {
            $request->validate([
                'nama_kategori' => 'required|max:255'
            ]);
            $data = [
                'nama_kategori' => $request->nama_kategori,
                'user_name'  => Auth::user()->nama
            ];
            // $data = $request->all();

            ProductCategory::create($data);
            return redirect()->route('productcategory')->with('success', 'Kategori Berhasil Ditambahkan');
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
        if(Auth::user()->can('update-product-category')) {
            $item = ProductCategory::findOrFail($id);

            return view('pages.productcategory.edit')->with([
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
    public function update(ProductCategoryRequest $request, $id)
    {
        if(Auth::user()->can('update-product-category')) {
            $request->validate([
                'nama_kategori' => 'required|max:255'
            ]);
            $data = [
                'nama_kategori' => $request->nama_kategori,
                'user_name'  => Auth::user()->nama
            ];
            // $data = $request->all();

            $item = ProductCategory::findOrFail($id);
            $item->update($data);

            return redirect()->route('productcategory')->with('success', 'Kategori Berhasil Diperbarui');
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
        if(Auth::user()->can('delete-product-category')) {
            $item = ProductCategory::findOrFail($id);
            $item->delete();

            return redirect()->route('productcategory')->with('success', 'Kategori Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
