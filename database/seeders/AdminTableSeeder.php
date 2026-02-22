<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admin_table')->updateOrInsert(
            ['schoolId' => 'Guidance@2025'],
            [
                'name' => 'Guidance Office',
                'email' => 'guidanceoffice@minsu.com',
                'password' => Hash::make('guidanceoffice@2025'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}