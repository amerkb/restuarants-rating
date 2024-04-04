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
        Schema::create('restaurant_details', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('category')->nullable();
            $table->string('logo')->nullable();
            $table->string('background')->nullable();
            $table->timestamps();
            $table->primary(['restaurant_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_details');
    }
};
