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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hackaton_id');
            $table->enum('status', ['en attente', 'accepté', 'refusé']);
            $table->text('motivation')->nullable();
            $table->enum('type', ['groupe', 'individuel']);
            $table->date('date_inscription')->nullable();
            $table->foreign('hackaton_id')->references('id')->on('hackathons')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('participants');
    }
};
