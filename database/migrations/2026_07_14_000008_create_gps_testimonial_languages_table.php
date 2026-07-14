<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_testimonial_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gps_testimonial_id')
                ->constrained('gps_testimonials')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('language_id')
                ->constrained('languages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->text('text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_testimonial_languages');
    }
};
