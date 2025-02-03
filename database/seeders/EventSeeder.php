<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Event;
class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::insert([
 
            [
                'title' => 'Visit',
                'start' => Carbon::create(2025, 2, 2)->subDays(1), // 5 hari sebelum tanggal sekarang
                'end' => Carbon::create(2025, 2, 4)->subDays(5),   // 2 hari sebelum tanggal sekarang
                'className' => 'bg-warning-subtle',
                'allDay' => true,
                'location' => 'Online',
                'description' => 'Long Term Event means an incident that last longer than 12 hours.',
                'extendedProps' => json_encode(['department' => 'Long Event']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
