<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('course_sessions')
            ->where('virtual_room_link', 'like', '%jitsi%')
            ->delete();

        $googleMeetLinks = [
            'https://meet.google.com/abc-defg-hij',
            'https://meet.google.com/xyz-uvwx-abc',
            'https://meet.google.com/pqr-stuv-wxy',
            'https://meet.google.com/efg-hijk-lmn',
        ];

        $sessions = DB::table('course_sessions')->get();
        foreach ($sessions as $index => $session) {
            DB::table('course_sessions')
                ->where('id', $session->id)
                ->update(['virtual_room_link' => $googleMeetLinks[$index % count($googleMeetLinks)]]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
