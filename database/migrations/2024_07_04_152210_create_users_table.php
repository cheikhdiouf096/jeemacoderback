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
            $table->string('firstname');
            $table->string('lastname');
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('metier')->nullable();
            $table->enum('role', ['organisateur', 'participant', 'jury']);
            $table->string('photo')->nullable()->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
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
