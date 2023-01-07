<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Department::insert([
            ['name' => 'Điều hành'],
            ['name' => 'Kế toán'],
            ['name' => 'Kinh doanh'],
            ['name' => 'Truyền thông'],
            ['name' => 'Nhân sự'],
            ['name' => 'Kho vận'],
            ['name' => 'Kỹ thuật'],
            ['name' => 'CS Khách hàng'],
            ['name' => 'Cửa hàng'],
        ]);
    }
}
