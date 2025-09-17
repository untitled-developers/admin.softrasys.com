<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Language;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('career_languages', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('short_description');
            $table->text('job_description');
            $table->foreignId('career_id')->constrained('careers')->onDelete('cascade');
            $table->foreignIdFor(Language::class, "language_id");
            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_languages');
    }
};
