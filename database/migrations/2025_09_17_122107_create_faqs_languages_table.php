<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Language;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_languages', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->foreignId('faq_id')->constrained('faqs')->onDelete('cascade');
            $table->foreignIdFor(Language::class, 'language_id');
            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_languages');
    }
};
