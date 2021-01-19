<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPhieuXuatKhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail__phieu_xuat_khos', function (Blueprint $table) {
            $table->id();
            $table->integer('soluong');
            $table->float('dongia');
            $table->float('thanhtien');
            $table->unsignedBigInteger('idSP');// 7 ngay
            $table->unsignedBigInteger('idPXK');
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
        Schema::dropIfExists('detail__phieu_xuat_khos');
    }
}
