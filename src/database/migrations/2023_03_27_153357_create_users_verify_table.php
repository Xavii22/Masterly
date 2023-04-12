<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users_verify', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->timestamps();

            $table->foreign('id')->references('id')->on('users');
        });

        /*
        Schema::table('users', function (Blueprint $table) {

            $table->boolean('is_email_verified')->default(0);

        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_verify');
    }
};
