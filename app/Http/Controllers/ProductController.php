<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\QRCodeModel;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Product::all();

        $items = Product::with(['productcategory'])->get();

        return view('pages.products.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productcategory = ProductCategory::all();

        return view('pages.products.create')->with([
            'productcategory' => $productcategory
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'kode' => 'required|max:255|unique:product,kode,NULL,id,deleted_at,NULL',
            'id_kategori' => 'required|integer|exists:product_category,id',
            'nama_produk' => 'required|max:255',
            'spesifikasi' => 'required|max:255',
            'stok' => 'required|integer',
            'letak' => 'required|max:255',
            'supplier' => 'required|max:255',
            'barang_masuk' => 'date',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer',
            'photo' => 'required|image',
        ]);

        $data = [
            'kode' => $request->kode,
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok,
            'letak' => $request->letak,
            'supplier' => $request->supplier,
            'barang_masuk' => $request->barang_masuk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'photo' => $request->photo,
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
    }

    // DOWNLOAD FUNCTION

    public function download($id)
    {
        $data = Product::where(['id' => $id])->first();
        $kodeqr = $data->kodeqr;

        $file = public_path($kodeqr);
        // dd($file);

        return response()->download($file);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Product::with('productcategory')->findOrFail($id);

        return view('pages.products.show')->with([
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $productcategory = ProductCategory::all();

        return view('pages.products.edit')->with([
            'item' => $item,
            'productcategory' => $productcategory
        ]);
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
        $request->validate([
            'id_kategori' => 'required|integer|exists:product_category,id',
            'nama_produk' => 'required|max:255',
            'spesifikasi' => 'required|max:255',
            'stok' => 'required|integer',
            'letak' => 'required|max:255',
            'supplier' => 'required|max:255',
            'barang_masuk' => 'date',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer',
            'photo' => 'image|file',
        ]);

        $data = [
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok,
            'letak' => $request->letak,
            'supplier' => $request->supplier,
            'barang_masuk' => $request->barang_masuk,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'photo' => $request->photo,
        ];

        $removehttp = $this->remove_http($request->oldImage);
        if ($request->file('photo')) {
            // dd($removehttp);
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
    }

    function remove_http($url) {
        $disallowed = array('http://127.0.0.1:8000/storage/', 'https://127.0.0.1:8000/storage/');
        foreach($disallowed as $d) {
           if(strpos($url, $d) === 0) {
              return str_replace($d, '', $url);
           }
        }
        return $url;
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $removehttp = $this->remove_http($item->photo);
        if ($removehttp) {
            Storage::delete($removehttp);

        }
        $item->delete();

        return redirect()->route('products')->with('success', 'Product Berhasil Dihapus');
    }
}
