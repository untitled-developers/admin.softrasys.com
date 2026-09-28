<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('language_id')
                ->constrained('languages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->string('address')->nullable();
            $table->timestamps();

            $table->unique(['location_id', 'language_id']);
        });

        // Copy existing name/address into every language before dropping them
        DB::table('location_languages')->insertUsing(
            ['location_id', 'language_id', 'name', 'address', 'created_at', 'updated_at'],
            DB::table('locations')
                ->crossJoin('languages')
                ->select([
                    'locations.id',
                    'languages.id',
                    'locations.name',
                    'locations.address',
                    'locations.created_at',
                    'locations.updated_at',
                ])
        );

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['name', 'address']);
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('address')->nullable()->after('sort_number');
        });

        DB::table('locations')
            ->join('location_languages', 'location_languages.location_id', '=', 'locations.id')
            ->where('location_languages.language_id', 1)
            ->update([
                'locations.name' => DB::raw('location_languages.name'),
                'locations.address' => DB::raw('location_languages.address'),
            ]);

        Schema::dropIfExists('location_languages');
    }
};
