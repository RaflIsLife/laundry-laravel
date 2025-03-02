<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiLayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_layanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->onDelete('cascade');
            $table->foreignId('layanan_id')->onDelete('cascade');
            $table->enum('type_qty', ['kg', 'pcs']);
            $table->decimal('qty');
            $table->integer('harga');
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
        Schema::dropIfExists('transaksi_layanans');
    }
}
