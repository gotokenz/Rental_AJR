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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('id_driver')->unique();
            $table->timestamps();
            $table->string('nama_driver');
            $table->string('alamat');
            $table->date('tgl_lahir');
            $table->string('jenis_kelamin');
            $table->string('email');
            $table->string('no_telp');
            $table->string('bahasa');
            $table->string('status_driver');
            $table->string('password');
            $table->double('tarif_driver');
            $table->double('rerata_rating');
            $table->string('url_sim');
            $table->string('url_surat_bebas_napza');
            $table->string('url_surat_kesehatan_jiwa');
            $table->string('url_surat_kesehatan_jasmani');
            $table->string('url_skck');
            $table->string('url_foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
