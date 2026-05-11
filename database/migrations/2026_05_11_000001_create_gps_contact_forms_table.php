<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_contact_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('industry')->nullable();
            $table->string('phone_number');
            $table->string('number_of_vehicles')->nullable();
            $table->string('country')->nullable();
            $table->text('message')->nullable();
            $table->string('source')->nullable();
            $table->string('referrer')->nullable();
            $table->string('campaign')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_contact_forms');
    }
};