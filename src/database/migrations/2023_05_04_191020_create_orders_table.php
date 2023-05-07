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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->notNullable();
            $table->boolean('accepted')->default(false);

            $table->unsignedBigInteger('buyer_id')->index();
            $table->foreign('buyer_id')->references('id')->on('users')->cascadeOnDelete();
            
            $table->unsignedBigInteger('seller_id')->index();
            $table->foreign('seller_id')->references('id')->on('users')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
