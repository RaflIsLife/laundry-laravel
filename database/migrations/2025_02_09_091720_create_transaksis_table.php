<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('courier_id')->nullable()->constrained('users');
            $table->integer('ongkir')->default(0);
            $table->integer('total_harga');
            $table->integer('subtotal');
            $table->integer('qty');
            $table->enum('status', ['menunggu pengambilan', 'menunggu pengantaran', 'pengambilan', 'antrian laundry', 'proses laundry', 'pengantaran', 'menunggu user mengambil', 'selesai']);
            $table->enum('pembayaran', ['qris', 'cod']);
            $table->enum('status_pembayaran', ['lunas', 'proses']);
            $table->enum('pengantaran', ['ya', 'tidak'])->default('ya');
            $table->enum('cara_pemesanan', ['offline', 'online'])->default('online');
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
        Schema::dropIfExists('transaksis');
    }
}
