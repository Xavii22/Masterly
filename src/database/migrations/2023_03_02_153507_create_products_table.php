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
            $table->id();
            $table->string('name', 30)->notNullable();
            $table->string('description', 5000)->notNullable();
            $table->integer('price')->notNullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('important')->default(false);
            $table->boolean('sold')->default(false);
            $table->unsignedBigInteger('store_id')->notNullable();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
