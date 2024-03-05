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
        Schema::create('demobook', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->bigInteger('id_book')->unsigned();
            $table->timestamps();
            $table->foreign('id_book')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demobook');
    }
};