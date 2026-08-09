<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Training', 'Conference', 'Meeting', 'Course', 'Event'] as $name) {
            Category::create(['category_name' => $name]);
        }

        $agency = Agency::create([
            'agency_name' => 'Jabatan Digital Negara',
            'agency_code' => 'JDN',
            'address' => 'Putrajaya, Malaysia',
            'contact' => '03-8000-0000',
            'email' => 'admin@jdn.gov.my',
        ]);

        User::create([
            'agency_id' => $agency->agency_id,
            'name' => 'System Admin',
            'email' => 'admin@jdn.gov.my',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'user_type' => 'government',
        ]);
    }
}
