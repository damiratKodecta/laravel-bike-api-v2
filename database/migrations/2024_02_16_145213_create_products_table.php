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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->unsignedBigInteger('product_type_id');
            $table->string('name', 255)->fullText(); //Adds a full text index (MySQL/PostgreSQL).
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->foreign('product_type_id')->references('product_type_id')->on('product_types')->onDelete('cascade')->onUpdate('cascade');
           });

        // Add the full-text index
    //DB::statement("ALTER TABLE products ADD FULLTEXT INDEX idx_name (name)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
