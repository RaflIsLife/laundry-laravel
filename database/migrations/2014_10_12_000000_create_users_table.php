<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->unique()->nullable()->default('Not Provided');
            $table->string('coordinate')->nullable();
            $table->string('address')->nullable();
            $table->enum('role', ['customer', 'kasir', 'owner', 'admin', 'kurir'])->default('customer');
            $table->enum('status', ['available', 'on_delivery'])->default('available');
            $table->unsignedInteger('daily_completed_orders')->default(0);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
