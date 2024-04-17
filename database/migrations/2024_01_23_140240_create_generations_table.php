<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generations', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('QR');
            $table->string('value')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        $folderPath = public_path('asset/QR');

        // Get all the files within the folder
        $files = File::files($folderPath);

        // Delete each file
        foreach ($files as $file) {
            File::delete($file);
        }
        Schema::dropIfExists('generations');
    }
};
