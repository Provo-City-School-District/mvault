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

        /*

        Asset Name
        Brand
        Make
        Model
        Serial #
        Purchase Price
        Purchase Date
        Life Expectancy
        Preven. Maint Date
        Program (HVAC, Electrical, etc)
        Replacement Date
        Replacement Costs

        */
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('site')->unsigned();
            $table->foreign('site')->references('id')->on('locations');
            $table->string('room')->nullable();
            $table->bigInteger('category')->nullable()->unsigned();
            $table->foreign('category')->references('id')->on('asset_categories');

            $table->string('name');
            $table->string('company');
            $table->string('model');
            $table->string('serial');
            $table->string('barcode')->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->date('purchase_date');
            $table->date('projected_eol_date');
            $table->decimal('replacement_price', 10, 2);

            $table->string('description');

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
