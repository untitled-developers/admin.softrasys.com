<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('value')->default(0);
            $table->string('suffix')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->unsignedInteger('sort_number')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_stats');
    }
};
