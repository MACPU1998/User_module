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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 64)->nullable();
            $table->string('last_name', 64)->nullable();
            $table->string('email', 128);
            $table->string("password");
            $table->string('mobile', 16)->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('occupation')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0:disabled | 1:enabled | 2:block');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
