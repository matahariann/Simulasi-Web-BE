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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->string('kabKota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('angkatan');
            $table->enum('jalurMasuk', ['SNBP', 'SNBT', 'Mandiri', 'SBUB']);
            $table->string('email')->unique()->nullable();
            $table->string('noTelp')->nullable();
            $table->enum('status', ['Aktif', 'Lulus', 'DO', 'Cuti'])->default('Aktif');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('dosenwali_nip');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dosenwali_nip')->references('nip')->on('dosenwalis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswas');

        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['dosenwali_nip']);
        });
    }
};
