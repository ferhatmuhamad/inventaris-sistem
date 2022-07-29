<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\QRCodeModel;
use App\Models\Supplier;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
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
        if(Auth::user()->can('read-product')) {
            return view('pages.products.index');
        } else {
            return redirect('forbidden');
        }
    }

    public function read(Request $request)
    {
        if(Auth::user()->can('read-product')) {
            $data = Product::all();
            $data = Product::with(['productcategory'])->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('imageData', function ($data) {
                    $imageData = '<img class="img-fluid" style="width: 50px" src="'.url( $data->photo ).'" alt="">';

                    return $imageData;
                })
                ->addColumn('kodeBlade', function ($data) {
                    $kodeBlade = explode('-', $data->kode);

                    return $kodeBlade[0];
                })
                ->addColumn('productCategory', function ($data) {
                    $productCategory = $data->productcategory->nama_kategori;

                    return $productCategory;
                })
                ->addColumn('hargaJual', function ($data) {
                    $hargaJual = $data->harga_jual;

                    return number_format($hargaJual);
                })
                ->addColumn('kodeQr', function ($data) {
                    $kodeQr = '<img style="width: 50px" src="'.url($data->kodeqr).'" alt="">';

                    return $kodeQr;
                })
                ->addColumn('action', function ($data){
                    $btn = '<div style="text-align:center;"><div class="btn-group">';
                    $btn = '<a id="show-btn" href="#mymodal" data-remote="'.url('products/show/'.$data->id).'" class="btn btn-info btn-sm" data-title="Detail Produk '.$data->kode.'" title="'.__('Show').'" data-toggle="modal" data-target="#mymodal"  data-placement="left"><i class="fa fa-eye"></i></a> ';
                    $btn .= '<a id="download-btn" href="'.url('products/download/'.$data->id).'" data-url="'.url('products/download/'.$data->id).'" class="btn btn-success btn-sm" title="'.__('general.download').'" data-toggle="tooltip"><i class="fa fa-download"></i></a> ';
                    if (Auth::user()->can(['update-product','delete-product'])) {
                        $btn .= '<a id="edit-btn" href="'.url('products/edit/'.$data->id).'" data-url="'.url('products/edit/'.$data->id).'" class="btn btn-primary btn-sm" title="'.__('general.edit').'" data-toggle="tooltip" data-placement="left"><i class="fa fa-pencil"></i></a> ';
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
        if(Auth::user()->can('create-product')) {
            $data['supplier'] = Supplier::get();
            $data['category'] = ProductCategory::all();

            return view('pages.products.create', compact('data'));
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
        if(Auth::user()->can('create-product')) {
            $request->validate([
                'kode'          => 'required|max:255|unique:product,kode,NULL,id,deleted_at,NULL',
                'id_kategori'   => 'required|integer|exists:product_category,id',
                'nama_produk'   => 'required|max:255',
                'spesifikasi'   => 'required|max:255',
                'stock_min'     => 'required|integer',
                'id_supplier'   => 'required|integer|exists:supplier,id',
                'letak'         => 'required|max:255',
                'barang_masuk'  => 'date',
                'harga_jual'    => 'required|integer',
                'harga_beli'    => 'required|integer',
                'photo'         => 'required|image',
            ]);

            $data = [
                'kode'          => $request->kode,
                'id_kategori'   => $request->id_kategori,
                'nama_produk'   => $request->nama_produk,
                'spesifikasi'   => $request->spesifikasi,
                'stock_min'     => $request->stock_min,
                'id_supplier'   => $request->id_supplier,
                'letak'         => $request->letak,
                'barang_masuk'  => $request->barang_masuk,
                'harga_jual'    => $request->harga_jual,
                'harga_beli'    => $request->harga_beli,
                'photo'         => $request->photo,
                'user_name'     => Auth::user()->nama
            ];

            $timeInsert = time();
            $kode_input = $request->kode . '-' . $timeInsert;
            $kode_qr = $kode_input;
            $path_qr = 'qrcodes/' . $kode_qr . '.png';

            $file_gambar = $request->file('photo');

            QrCode::format('png')->size(500)->generate($kode_qr, '../public/' . $path_qr);

            $path_foto = 'product/' . $file_gambar->getClientOriginalName() . '-' . $timeInsert . '.' . $file_gambar->getClientOriginalExtension();

            $file_gambar->move(public_path('../public/storage/product'), '../public/' . $path_foto);

            QRCodeModel::create([
                'qrcode' => $kode_qr,
                'path_qrcode' => $path_qr,
                'path_img' => $path_foto,
            ]);

            $data['kode'] = $kode_input;
            $data['kodeqr'] = $path_qr;
            $data['photo'] = $path_foto;

            Product::create($data);

            return redirect()->route('products')->with('success', 'Product Berhasil Ditambahkan');
        } else {
            return redirect('forbidden');
        }
    }

    // DOWNLOAD FUNCTION

    public function download($id)
    {
        if(Auth::user()->can('read-product')) {
            $data = Product::where(['id' => $id])->first();
            $kodeqr = $data->kodeqr;

            $file = public_path($kodeqr);
            return response()->download($file);
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
        if(Auth::user()->can('read-product')) {
            $data['parse'] = Product::with('productcategory')->with('supplier')->findOrFail($id);
            $data['supplier'] = Supplier::get();

            return view('pages.products.show', compact('data'));
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
        if(Auth::user()->can('update-product')) {
            $data['parse'] = Product::findOrFail($id);
            $data['supplier'] = Supplier::get();
            $data['category'] = ProductCategory::all();

            return view('pages.products.edit', compact('data'));
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
        if(Auth::user()->can('update-product')) {
            $request->validate([
                'id_kategori'   => 'required|integer|exists:product_category,id',
                'nama_produk'   => 'required|max:255',
                'spesifikasi'   => 'required|max:255',
                'stock_min'     => 'required|integer',
                'id_supplier'   => 'required|integer|exists:supplier,id',
                'letak'         => 'required|max:255',
                'barang_masuk'  => 'date',
                'harga_jual'    => 'required|integer',
                'harga_beli'    => 'required|integer',
                'photo'         => 'image|file',
            ]);

            $data = [
                'id_kategori'   => $request->id_kategori,
                'nama_produk'   => $request->nama_produk,
                'spesifikasi'   => $request->spesifikasi,
                'stock_min'     => $request->stock_min,
                'id_supplier'   => $request->id_supplier,
                'letak'         => $request->letak,
                'barang_masuk'  => $request->barang_masuk,
                'harga_jual'    => $request->harga_jual,
                'harga_beli'    => $request->harga_beli,
                'photo'         => $request->photo,
                'user_name'     => Auth::user()->nama
            ];

            $removehttp = $this->remove_http($request->oldImage);
            if ($request->file('photo')) {
                if ($removehttp) {
                    Storage::delete($removehttp);
                }
                $file_gambar = $request->file('photo');
                $path_foto = 'product/' . $file_gambar->getClientOriginalName() . '-' . time() . '.' . $file_gambar->getClientOriginalExtension();
                $file_gambar->move(public_path('../public/storage/product'), '../public/' . $path_foto);
            } else {
                $path_foto = $removehttp;
            }

            $data['photo'] = $path_foto;

            $item = Product::findOrFail($id);
            $item->update($data);

            return redirect()->route('products')->with('success', 'Produk Berhasil Diperbarui');
        } else {
            return redirect('forbidden');
        }
    }

    function remove_http($url) {
        if(Auth::user()->can('update-product')) {
            $disallowed = array('http://127.0.0.1:8001/storage/', 'https://127.0.0.1:8001/storage/');
            foreach($disallowed as $d) {
               if(strpos($url, $d) === 0) {
                  return str_replace($d, '', $url);
               }
            }
            return $url;
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
        if(Auth::user()->can('delete-product')) {
            $item = Product::findOrFail($id);
            $removehttp = $this->remove_http($item->photo);
            if ($removehttp) {
                Storage::delete($removehttp);
            }
            // example:
            // alert()->question('Are you sure?','You won\'t be able to revert this!')->showCancelButton('Cancel', '#aaa');
            $item->delete();

            return redirect()->route('products')->with('success', 'Produk Berhasil Dihapus');
        } else {
            return redirect('forbidden');
        }
    }
}
