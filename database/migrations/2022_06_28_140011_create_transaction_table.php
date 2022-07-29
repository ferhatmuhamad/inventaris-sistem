<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_product');
            $table->integer('id_category');
            $table->date('date');
            $table->integer('stock');
            $table->enum('type', ['SO', 'S', 'B']);
            $table->integer('id_customer');
            $table->integer('id_supplier');
            $table->integer('id_warehouse');
            $table->integer('id_periode');
            $table->integer('id_month');

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
        Schema::dropIfExists('transaction');
    }
}
