<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'the admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('123456')
        ]);

        User::create([
            'name' => 'the technician',
            'email' => 'technician@gmail.com',
            'role' => 'technician',
            'password' => Hash::make('123456')
        ]);

        User::create([
            'name' => 'the student',
            'email' => 'student@gmail.com',
            'role' => 'student',
            'password' => Hash::make('123456')
        ]);
    }
}
