<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solution_category_languages', function (Blueprint $table) {
            $table->dropColumn('short_description');
            $table->text('description')->nullable()->after('name');
        });

        Schema::table('solution_categories', function (Blueprint $table) {
            $table->dropForeign(['blob_id']);
            $table->dropColumn('blob_id');
        });
    }

    public function down(): void
    {
        Schema::table('solution_category_languages', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->string('short_description')->nullable()->after('name');
        });

        Schema::table('solution_categories', function (Blueprint $table) {
            $table->foreignId('blob_id')
                ->nullable()
                ->constrained('blobs')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
