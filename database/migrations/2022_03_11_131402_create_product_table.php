<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode');
            $table->integer('id_kategori');
            $table->string('nama_produk');
            $table->longText('spesifikasi');
            $table->integer('stock_min');
            $table->integer('stock');
            $table->string('letak');
            $table->string('supplier');
            $table->date('barang_masuk');
            $table->integer('harga_jual');
            $table->integer('harga_beli');
            $table->string('photo');
            $table->string('kodeqr');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
