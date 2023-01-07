<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Position::insert([
            ['name' => 'Giám đốc', 'position_allowance_amount' => 25000000, 'department_id' => 1],
            ['name' => 'Phó Giám đốc', 'position_allowance_amount' => 20000000, 'department_id' => 1],

            ['name' => 'Trưởng phòng Kế toán', 'position_allowance_amount' => 10000000, 'department_id' => 2],
            ['name' => 'Nhân viên Kế toán', 'position_allowance_amount' => 4000000, 'department_id' => 2],

            ['name' => 'Trưởng phòng Kinh doanh', 'position_allowance_amount' => 5000000, 'department_id' => 3],
            ['name' => 'Nhân viên Kinh doanh', 'position_allowance_amount' => 2000000, 'department_id' => 3],
            ['name' => 'Nhân viên Kinh doanh Online', 'position_allowance_amount' => 2000000, 'department_id' => 3],
            ['name' => 'Nhân viên Kế hoạch', 'position_allowance_amount' => 2000000, 'department_id' => 3],

            ['name' => 'Trưởng phòng Truyền thông', 'position_allowance_amount' => 5000000, 'department_id' => 4],
            ['name' => 'Nhân viên Truyền thông', 'position_allowance_amount' => 2000000, 'department_id' => 4],

            ['name' => 'Trưởng phòng Nhân sự', 'position_allowance_amount' => 5000000, 'department_id' => 5],
            ['name' => 'Nhân viên Tuyển dụng', 'position_allowance_amount' => 2000000, 'department_id' => 5],
            ['name' => 'Nhân viên Đào tạo', 'position_allowance_amount' => 2000000, 'department_id' => 5],

            ['name' => 'Trường phòng Kho vận', 'position_allowance_amount' => 5000000, 'department_id' => 6],
            ['name' => 'Nhân viên Kho vận', 'position_allowance_amount' => 2000000, 'department_id' => 6],

            ['name' => 'Trường phòng Kỹ thuật', 'position_allowance_amount' => 5000000, 'department_id' => 7],
            ['name' => 'Nhân viên Phần cứng', 'position_allowance_amount' => 2000000, 'department_id' => 7],
            ['name' => 'Nhân viên Phần mềm', 'position_allowance_amount' => 2000000, 'department_id' => 7],
            ['name' => 'Nhân viên Bảo trì', 'position_allowance_amount' => 2000000, 'department_id' => 7],

            ['name' => 'Trường phòng CS Khách hàng', 'position_allowance_amount' => 0, 'department_id' => 8],
            ['name' => 'Nhân viên CS Khách hàng', 'position_allowance_amount' => 0, 'department_id' => 8],
            ['name' => 'Nhân viên Xử lý khiếu nại', 'position_allowance_amount' => 0, 'department_id' => 8],
            ['name' => 'Nhân viên Kiểm soát chất lượng', 'position_allowance_amount' => 0, 'department_id' => 8],

            ['name' => 'Quản lý Cửa hàng', 'position_allowance_amount' => 0, 'department_id' => 9],
            ['name' => 'Nhân viên bán hàng', 'position_allowance_amount' => 0, 'department_id' => 9],
            ['name' => 'Nhân viên Thu ngân', 'position_allowance_amount' => 0, 'department_id' => 9],
            ['name' => 'Nhân viên Kỹ thuật', 'position_allowance_amount' => 0, 'department_id' => 9],
            ['name' => 'Nhân viên Bảo vệ', 'position_allowance_amount' => 0, 'department_id' => 9],
        ]);
    }
}
