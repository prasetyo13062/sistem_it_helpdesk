<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Department
        |--------------------------------------------------------------------------
        */

        $departments = [
            'IT',
            'HR',
            'Finance',
            'Produksi',
            'Warehouse',
            'Marketing',
            'Lainnya',
        ];

        foreach ($departments as $department) {
            Department::firstOrCreate([
                'name' => $department,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $categories = [
            'Hardware',
            'Software',
            'Network',
            'Printer',
            'Account & Access',
            'Security',
            'Lainnya',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Department
        |--------------------------------------------------------------------------
        */

        $itDepartment = Department::where('name', 'IT')->first();
        $produksiDepartment = Department::where('name', 'Produksi')->first();


        /*
        |--------------------------------------------------------------------------
        | Akun Pegawai
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'pegawai@ithelpdesk.test',
            ],
            [
                'name' => 'Pegawai Demo',
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'department_id' => $produksiDepartment->id,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Akun IT
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'it@ithelpdesk.test',
            ],
            [
                'name' => 'IT Support',
                'password' => Hash::make('password'),
                'role' => 'it',
                'department_id' => $itDepartment->id,
            ]
        );
    }
}