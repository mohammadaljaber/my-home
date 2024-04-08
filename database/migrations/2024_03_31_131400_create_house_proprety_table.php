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
        Schema::create('house_property', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('house_id');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('house_id')->references('id')->on('houses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_proprety');
    }
};
