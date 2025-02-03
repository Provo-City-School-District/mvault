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
            $table->string('name');
            $table->string('brand');
            $table->string('make');
            $table->string('model');
            $table->string('serial');
            $table->bigInteger('site')->unsigned();
            $table->foreign('site')->references('id')->on('locations');
            $table->string('room');
            $table->string('program');
            $table->string('category');
            $table->string('notes');
            $table->date('purchase_date');
            $table->integer('expected_lifespan');
            $table->integer('replacement_cost');
            $table->timestamp('last_validated')->default(DB::raw('TIMESTAMP(0)'));

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
