<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // public function all(Request $request)
    // {
    //     $id = $request->input('id');
    //     $kode = $request->input('kode');
    //     $name = $request->input('nama_produk');
    //     $qr = $request->input('kodeqr');
    //     $supplier = $request->input('supplier');
    //     $price_from = $request->input('price_from');
    //     $price_to = $request->input('price_to');

    //     if ($id)
    //     {
    //         $product = Product::with('productcategory')->find($id);
    //         // $data = Product::where(['id' => $id])->first();
    //         // $kodeqr = $product->kodeqr;
    //         // $file = public_path($kodeqr);

    //         if ($product) {
    //             return ResponseFormatter::success($product, 'Data produk berhasil diambil');
    //         }

    //         else {
    //             return ResponseFormatter::error(null, 'Data produk tidak ditemukan', 404);
    //         }
    //     }

    //     if ($qr)
    //     {
    //         $product = Product::with('productcategory')->find($qr);

    //         if ($product) {
    //             return ResponseFormatter::success($product, 'Data produk berhasil diambil');
    //         }

    //         else {
    //             return ResponseFormatter::error(null, 'Data produk tidak ditemukan', 404);
    //         }
    //     }

    // }

    public function getQRCodeByCode($code) {
        $data = Product::with('productcategory')->where('kode', $code)->first();

        return $data;
    }

    public function getqrcode(Request $request)
    {
        $tokenstatis = 'Bearer sz5jighueth4usz5y47';

        if($request->header('Authorization') == $tokenstatis) {

            $code = $request->kode;
            $result = $this->getQRCodeByCode($code);

            if($result) {
                return ResponseFormatter::success($result, 'success');
            } else {
                return ResponseFormatter::error(null, 'failed');
            }
        } else {
            return ResponseFormatter::error('failed');
        }
    }
}
