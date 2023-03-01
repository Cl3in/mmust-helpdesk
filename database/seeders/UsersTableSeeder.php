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
            'first_name' => 'CALVINS',
            'last_name' => 'OCHIENG ',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Technician1',
            'last_name' => 'Kemunto',
            'email' => 'technician1@gmail.com',
            'role' => 'technician',
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Technician2',
            'last_name' => 'Kemunto',
            'email' => 'technician2@gmail.com',
            'role' => 'technician',
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Student1',           
            'last_name' => 'Paul',
            'email' => 'student1@gmail.com',
            'role' => 'student',
            'password' => Hash::make('123456')
        ]);

        User::create([
            'first_name' => 'Student2',           
            'last_name' => 'Paul',
            'email' => 'student2@gmail.com',
            'role' => 'student',
            'password' => Hash::make('123456')
        ]);
    }
}
