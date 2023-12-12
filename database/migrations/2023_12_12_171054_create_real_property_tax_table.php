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
        Schema::create('real_property_tax', function (Blueprint $table) {
            $table->id();
            $table->string('area_type');
            $table->string('basic_property_tax');
            $table->integer('special_education_fund');
            $table->timestamps();
        });

        Schema::table('real_property_tax', function (Blueprint $table) {
            $table->unsignedBigInteger('property_owner_id');
            $table->foreign('property_owner_id')->references('id')->on('property_owners');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_property_tax');
    }
};
