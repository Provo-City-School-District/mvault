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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->string('barcode');
            $table->string('company');
            $table->string('model');
            $table->bigInteger('site')->unsigned();
            $table->foreign('site')->references('id')->on('locations');
            $table->string('room');
            $table->string('program');
            $table->string('category');
            $table->string('notes');
            $table->date('purchase_date');
            $table->integer('expected_lifespan');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
