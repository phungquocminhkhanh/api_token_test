<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPhieuBanHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail__phieu_ban_hangs', function (Blueprint $table) {
            $table->id();
            $table->integer('soluong');
            $table->float('dongia');
            $table->float('thanhtien');
            $table->unsignedBigInteger('idSP');
            $table->unsignedBigInteger('idPBH');
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
        Schema::dropIfExists('detail__phieu_ban_hangs');
    }
}
