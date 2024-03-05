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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title_book');
            $table->string('original_price');
            $table->string('price');
            $table->string('book_image');
            $table->text('description');
            $table->string('quantity');
            $table->string('status')->default(1);
            $table->bigInteger('id_author')->unsigned();
            $table->bigInteger('id_cate')->unsigned();  
            $table->bigInteger('id_publisher')->unsigned();
            $table->timestamps();
            $table->softDeletes();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};