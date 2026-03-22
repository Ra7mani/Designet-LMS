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
        Schema::table('users', function (Blueprint $table) {
            // UI Preferences
            $table->boolean('dark_mode')->default(false)->after('updated_at');
            $table->string('accent_color', 50)->default('purple')->after('dark_mode');
            $table->string('text_size', 50)->default('normal')->after('accent_color');
            $table->string('timezone', 255)->default('UTC')->after('text_size');
            $table->string('currency', 10)->default('MAD')->after('timezone');
            $table->string('language', 5)->default('fr')->after('currency');

            // Notification Preferences (JSON)
            $table->json('notification_settings_json')->nullable()->after('language');

            // Subscription Data
            $table->string('subscription_plan', 50)->default('free')->after('notification_settings_json');
            $table->timestamp('subscription_expires_at')->nullable()->after('subscription_plan');

            // Soft Delete Support
            $table->softDeletes()->after('subscription_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'dark_mode',
                'accent_color',
                'text_size',
                'timezone',
                'currency',
                'language',
                'notification_settings_json',
                'subscription_plan',
                'subscription_expires_at',
                'deleted_at',
            ]);
        });
    }
};
