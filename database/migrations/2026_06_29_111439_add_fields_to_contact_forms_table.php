<?php

use App\Enums\ContactFormStatuses;
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
        Schema::table('contact_forms', function (Blueprint $table) {
            $table->renameColumn('source', 'utm_source');
            $table->renameColumn('campaign', 'utm_campaign');
            $table->string('utm_medium')->nullable();
            $table->string('utm_content')->nullable();
            $table->boolean('is_read')->default(false);
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('status')->default(ContactFormStatuses::INTAKE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_forms', function (Blueprint $table) {
            $table->dropConstrainedForeignId('admin_id');
            $table->dropColumn(['utm_medium', 'utm_content', 'is_read', 'status']);
            $table->renameColumn('utm_source', 'source');
            $table->renameColumn('utm_campaign', 'campaign');
        });
    }
};
