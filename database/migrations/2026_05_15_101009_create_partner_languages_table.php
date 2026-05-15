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
        Schema::create('partner_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')
                ->constrained('partners')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('language_id')
                ->constrained('languages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_languages');
    }
};
