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
        Schema::create('hackathons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('structure_organisateur');
            $table->string('theme');
            $table->string('description');
            $table->string('logo_url');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('prix');
            $table->string('lieu');
            $table->unsignedBigInteger('organisateur_id');
            $table->foreign('organisateur_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hackathons');
    }
};
