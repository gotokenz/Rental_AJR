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
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id_aset_mobil');
            $table->timestamps();
            $table->unsignedInteger('id_pemilik')->nullable();
            $table->string('nama_mobil');
            $table->string('tipe');
            $table->string('jenis_transmisi');
            $table->string('jenis_bahan_bakar');
            $table->string('warna');
            $table->double('volume_bagasi');
            $table->string('fasilitas');
            $table->integer('kapasitas_penumpang');
            $table->string('plat_nomor');
            $table->string('nomor_stnk');
            $table->string('kategori_aset');
            $table->double('harga_sewa');
            $table->string('status_mobil');
            $table->date('tgl_servis');
            $table->date('mulai_kontrak')->nullable();
            $table->date('akhir_kontrak')->nullable();
            $table->string('url_foto');

            $table->foreign('id_pemilik')->nullable()->references('id_pemilik')->on('owner_cars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
