<?php

namespace Database\Seeders;

use App\Models\UserAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'schoolId' => '2023-00125',
                'name' => 'John Smith',
                'email' => 'john.smith@school.edu',
                'program' => 'Computer Science',
                'year' => '3rd Year',
                'section' => 'A',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00126',
                'name' => 'Maria Johnson',
                'email' => 'maria.johnson@school.edu',
                'program' => 'Psychology',
                'year' => '2nd Year',
                'section' => 'B',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00127',
                'name' => 'Robert Davis',
                'email' => 'robert.davis@school.edu',
                'program' => 'Engineering',
                'year' => '4th Year',
                'section' => 'A',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00128',
                'name' => 'Sarah Williams',
                'email' => 'sarah.williams@school.edu',
                'program' => 'Business Administration',
                'year' => '3rd Year',
                'section' => 'C',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00129',
                'name' => 'Thomas Brown',
                'email' => 'thomas.brown@school.edu',
                'program' => 'Information Technology',
                'year' => '1st Year',
                'section' => 'A',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00130',
                'name' => 'Emily Garcia',
                'email' => 'emily.garcia@school.edu',
                'program' => 'Nursing',
                'year' => '2nd Year',
                'section' => 'B',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00131',
                'name' => 'Michael Martinez',
                'email' => 'michael.martinez@school.edu',
                'program' => 'Accountancy',
                'year' => '4th Year',
                'section' => 'A',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00132',
                'name' => 'Jessica Rodriguez',
                'email' => 'jessica.rodriguez@school.edu',
                'program' => 'Education',
                'year' => '3rd Year',
                'section' => 'C',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00133',
                'name' => 'David Lee',
                'email' => 'david.lee@school.edu',
                'program' => 'Architecture',
                'year' => '2nd Year',
                'section' => 'A',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00135',
                'name' => 'Christopher Wilson',
                'email' => 'christopher.wilson@school.edu',
                'program' => 'Computer Science',
                'year' => '4th Year',
                'section' => 'B',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00136',
                'name' => 'Amanda Taylor',
                'email' => 'amanda.taylor@school.edu',
                'program' => 'Psychology',
                'year' => '3rd Year',
                'section' => 'A',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00137',
                'name' => 'Daniel Thomas',
                'email' => 'daniel.thomas@school.edu',
                'program' => 'Engineering',
                'year' => '2nd Year',
                'section' => 'C',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00138',
                'name' => 'Rachel Jackson',
                'email' => 'rachel.jackson@school.edu',
                'program' => 'Business Administration',
                'year' => '1st Year',
                'section' => 'B',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00139',
                'name' => 'Kevin White',
                'email' => 'kevin.white@school.edu',
                'program' => 'Information Technology',
                'year' => '3rd Year',
                'section' => 'A',
                'password' => Hash::make('password123'),
            ],
            [
                'schoolId' => '2023-00140',
                'name' => 'Michelle Harris',
                'email' => 'michelle.harris@school.edu',
                'program' => 'Nursing',
                'year' => '4th Year',
                'section' => 'C',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($students as $student) {
            UserAccount::create($student);
        }
    }
}
