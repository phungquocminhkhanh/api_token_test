<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTonKhoAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ton_kho__agents', function (Blueprint $table) {
            $table->id();
            $table->integer('soluong');
            $table->integer('soluongantoan');
            $table->boolean('trangthai');
            $table->unsignedBigInteger('idSP');
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
        Schema::dropIfExists('ton_kho__agents');
    }
}
