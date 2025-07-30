<?php

namespace Database\Seeders;

use App\Models\WorkingHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkingHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workingHours = [
            ['day_of_week' => 'Monday', 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false],
            ['day_of_week' => 'Tuesday', 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false],
            ['day_of_week' => 'Wednesday', 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false],
            ['day_of_week' => 'Thursday', 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false],
            ['day_of_week' => 'Friday', 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'is_closed' => false],
            ['day_of_week' => 'Saturday', 'start_time' => '10:00:00', 'end_time' => '15:00:00', 'is_closed' => false],
            ['day_of_week' => 'Sunday', 'start_time' => null, 'end_time' => null, 'is_closed' => true],
        ];

        foreach ($workingHours as $hour) {
            WorkingHour::firstOrCreate(
                ['day_of_week' => $hour['day_of_week']],
                $hour
            );
        }
        $this->command->info('Working hours seeded!');
    }
}
