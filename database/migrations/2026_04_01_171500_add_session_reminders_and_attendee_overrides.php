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
        Schema::table('course_sessions', function (Blueprint $table) {
            $table->boolean('auto_reminder_30m_enabled')->default(true)->after('max_attendees');
            $table->timestamp('auto_reminder_30m_sent_at')->nullable()->after('auto_reminder_30m_enabled');
            $table->json('excluded_attendee_ids')->nullable()->after('auto_reminder_30m_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_sessions', function (Blueprint $table) {
            $table->dropColumn(['auto_reminder_30m_enabled', 'auto_reminder_30m_sent_at', 'excluded_attendee_ids']);
        });
    }
};
