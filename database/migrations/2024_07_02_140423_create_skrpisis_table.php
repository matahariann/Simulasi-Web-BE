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
        Schema::create('skrpisis', function (Blueprint $table) {
            $table->id();
            $table->string('semester');
            $table->string('tanggalSidang');
            $table->string('dosenPembimbing');
            $table->string('scanSidang');
            $table->boolean('approval')->default('0');
            $table->string('nim_mhs');
            $table->timestamps();

            $table->foreign('nim_mhs')->references('nim')->on('mahasiswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skrpisis');

        Schema::table('skripsis', function (Blueprint $table) {
            $table->dropForeign(['nim_mhs']);
        });
    }
};
