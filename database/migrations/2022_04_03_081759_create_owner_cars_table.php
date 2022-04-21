<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_cars', function (Blueprint $table) {
            $table->increments('id_pemilik');
            $table->timestamps();
            $table->string('status_pemilik');
            $table->string('nama_pemilik');
            $table->string('no_ktp');
            $table->string('alamat');
            $table->string('no_telp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owner_cars');
    }
};
