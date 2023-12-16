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
        Schema::create('land_classification', function (Blueprint $table) {
            $table->id();
            $table->string('land_classification_name');
            $table->integer('fair_market_value');
            $table->integer('assessment_level');
            $table->timestamps();
        });

        Schema::table('land_classification', function (Blueprint $table) {
            $table->unsignedBigInteger('property_id');
            $table->foreign('property_id')->references('id')->on('property');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_classification');
    }
};
