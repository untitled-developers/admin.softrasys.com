<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blob_id')
                ->nullable()
                ->constrained('blobs')
                ->nullOnDelete();
            $table->boolean('is_hidden')->default(false);
            $table->unsignedInteger('sort_number')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_features');
    }
};
