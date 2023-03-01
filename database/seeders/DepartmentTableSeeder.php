<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Information Technology'
        ]);

        Department::create([
            'name' => 'Mathematics'
        ]);

        Department::create([
            'name' => 'Chemistry'
        ]);

        Department::create([
            'name' => 'Optometry'
        ]);
    }
}
