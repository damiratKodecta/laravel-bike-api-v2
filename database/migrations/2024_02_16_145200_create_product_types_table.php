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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id('product_type_id');
            $table->string('name', 255);
            $table->text('description')->nullable(); //by default, not nullable.
            //$table->timestamps();
            /*
            By omitting the timestamps() method, 
            Laravel will not create created_at and updated_at columns 
            in the product_types table. 
            This is perfectly valid and allows you to define 
            the schema according to your specific requirements.
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};
