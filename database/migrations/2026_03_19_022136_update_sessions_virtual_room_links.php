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
        \Illuminate\Support\Facades\DB::table('course_sessions')
            ->where('virtual_room_link', 'like', '%jitsi%')
            ->delete();

        $googleMeetLinks = [
            'https://meet.google.com/abc-defg-hij',
            'https://meet.google.com/xyz-uvwx-abc',
            'https://meet.google.com/pqr-stuv-wxy',
            'https://meet.google.com/efg-hijk-lmn',
        ];

        $sessions = \Illuminate\Support\Facades\DB::table('course_sessions')->get();
        foreach ($sessions as $index => $session) {
            \Illuminate\Support\Facades\DB::table('course_sessions')
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
