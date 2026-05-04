<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Enrollment;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BulkEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_PH');
        $grades = ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'];
        $sexes = ['Male', 'Female'];
        $tvlChoices = ['ICT', 'CSS', 'Food Industry', 'Automotive', 'Drafting', 'SMAW', 'HE'];
        $shsStrands = [
            'STEM' => 'Academic',
            'ABM' => 'Academic',
            'HUMSS' => 'Academic',
            'ICT' => 'TVL',
            'HE' => 'TVL',
            'Industrial Arts' => 'TVL'
        ];

        $this->command->info('Creating 100 approved enrollment records...');

        for ($i = 0; $i < 100; $i++) {
            $grade = $faker->randomElement($grades);
            $sex = $faker->randomElement($sexes);
            $lrn = $faker->numerify('############'); // 12 digits
            
            // Create user first
            $user = User::create([
                'name' => $faker->name($sex === 'Male' ? 'male' : 'female'),
                'student_id' => $lrn,
                'email' => $lrn . '@tnts.edu.ph',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            $isShs = in_array($grade, ['Grade 11', 'Grade 12']);
            $strand = null;
            $track = null;
            $choices = null;
            $specialization = null;

            if ($isShs) {
                $strand = $faker->randomElement(array_keys($shsStrands));
                $track = $shsStrands[$strand];
            } elseif (in_array($grade, ['Grade 8', 'Grade 9', 'Grade 10'])) {
                $choices = $faker->randomElements($tvlChoices, 3);
                $specialization = $choices[0];
            }

            Enrollment::create([
                'user_id' => $user->id,
                'transaction_number' => 'TNTS-' . strtoupper(Str::random(8)),
                'status' => 'Enrolled',
                'type' => $faker->randomElement(['New', 'Old', 'Transferee']),
                'grade_level' => $grade,
                'lrn' => $lrn,
                'last_name' => $faker->lastName,
                'first_name' => $faker->firstName($sex === 'Male' ? 'male' : 'female'),
                'middle_name' => $faker->lastName,
                'birthdate' => $faker->dateTimeBetween('-18 years', '-12 years')->format('Y-m-d'),
                'sex' => $sex,
                'gwa' => $faker->randomFloat(2, 75, 98),
                'track' => $track,
                'strand' => $strand,
                'shs_track' => $track,
                'tech_voc_choices' => $choices,
                'specialization' => $specialization,
                'contact_no' => '9' . $faker->numerify('#########'),
                'father_name' => $faker->name('male'),
                'mother_maiden_name' => $faker->name('female'),
                'current_barangay' => $faker->streetName,
                'current_municipality' => 'Tanza',
                'current_province' => 'Cavite',
                'current_house_no' => $faker->buildingNumber,
                'current_street' => $faker->streetName,
                'current_zip' => '4108',
            ]);
        }

        $this->command->info('Bulk enrollment seeding complete.');
    }
}
