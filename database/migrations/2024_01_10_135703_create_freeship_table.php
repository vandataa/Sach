<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('freeship', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->timestamps();
            $table->bigInteger('id_tp')->unsigned();
            $table->bigInteger('id_qh')->unsigned();
            $table->bigInteger('id_xa')->unsigned();
            $table->foreign('id_tp')->references('id')->on('tinhtp');
            $table->foreign('id_qh')->references('id')->on('quanhuyen');
            $table->foreign('id_xa')->references('id')->on('xaphuong');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freeship');
    }
};
