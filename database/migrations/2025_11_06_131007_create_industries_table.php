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
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blob_id')
                ->nullable()
                ->constrained('blobs')
                ->nullOnDelete();
            $table->boolean('is_hidden')->default(false);
            $table->unsignedInteger('sort_number')->default(0);
            $table->string('slug')->unique();
            $table->string('btn_href')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};
