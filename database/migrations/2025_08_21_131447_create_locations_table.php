<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('sort_number')->default(0);
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('support_number')->nullable();
            $table->decimal('longitude', 19, 16)->nullable();
            $table->decimal('latitude', 19, 16)->nullable();
            $table->string('location_link')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
