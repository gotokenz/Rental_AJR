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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi')->unique();
            $table->timestamps();
            $table->unsignedInteger('id_pegawai');
            $table->string('id_driver')->nullable();
            $table->string('id_customer');
            $table->unsignedInteger('id_aset_mobil');
            $table->unsignedInteger('id_promo')->nullable();
            $table->string('jenis_sewa');
            $table->dateTime('tgl_transaksi');
            $table->dateTime('tgl_mulai_sewa');
            $table->dateTime('tgl_selesai_sewa');
            $table->dateTime('tgl_pengembalian')->nullable();
            $table->double('total_harga_sewa');
            $table->string('status_transaksi');
            $table->dateTime('tgl_bayar')->nullable();
            $table->string('metode_bayar');
            $table->double('total_diskon');
            $table->double('total_denda');
            $table->double('total_harga');
            $table->string('url_bukti_pembayaran');
            $table->double('rating_driver');
            $table->double('rating_perusahaan');

            $table->foreign('id_pegawai')->references('id_pegawai')->on('employees');
            $table->foreign('id_customer')->references('id_customer')->on('customers');
            $table->foreign('id_driver')->nullable()->references('id_driver')->on('drivers');
            $table->foreign('id_aset_mobil')->references('id_aset_mobil')->on('cars');
            $table->foreign('id_promo')->nullable()->references('id_promo')->on('promos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
