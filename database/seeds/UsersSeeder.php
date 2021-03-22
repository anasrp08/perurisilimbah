<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin role
        $adminRole = new Role();
        $adminRole->name = "admin"; 
        $adminRole->display_name = "Admin";
        $adminRole->save();

        // Create Member role
        $beacukaiRole = new Role();
        $beacukaiRole->name = "operator";
        $beacukaiRole->display_name = "Operator";
        $beacukaiRole->save();

        $unitKerjaRole = new Role();
        $unitKerjaRole->name = "unit kerja";
        $unitKerjaRole->display_name = "Unit Kerja";
        $unitKerjaRole->save();

        $satpamRole = new Role();
        $satpamRole->name = "pengawas";
        $satpamRole->display_name = "Pengawas";
        $satpamRole->save();



         

        // Create Admin sample
        $admin = new User();
        $admin->name = 'Admin Limbah';
        $admin->email = 'admin@limbahperuri'; 
        $admin->username = '7776'; 
        $admin->password = bcrypt('admin123');
        $admin->avatar = "admin_avatar.jpg";
        $admin->is_verified = 1;
        $admin->save();
        $admin->attachRole($adminRole);

        // Create Sample member
        $bc = new User();
        $bc->name = 'Operator';
        $bc->email = 'operator@limbahperuri'; 
        $bc->username = '7777'; 
        $bc->password = bcrypt('operator123');
        $bc->avatar = "operator_avatar.png";
        $bc->is_verified = 1;
        $bc->save();
        $bc->attachRole($beacukaiRole);

        $uk = new User();
        $uk->name = 'Unit Kerja';
        $uk->email = 'unitkerja@limbahperuri'; 
        $uk->username = '7778'; 
        $uk->password = bcrypt('unitkerja123');
        $uk->avatar = "operator_avatar.png";
        $uk->is_verified = 1;
        $uk->save();
        $uk->attachRole($unitKerjaRole);

        $pengawas = new User();
        $pengawas->name = 'Pengawas';
        $pengawas->email = 'pengawas@limbahperuri'; 
        $pengawas->username = '7779'; 
        $pengawas->password = bcrypt('pengawas123');
        $pengawas->avatar = "operator_avatar.png";
        $pengawas->is_verified = 1;
        $pengawas->save();
        $pengawas->attachRole($satpamRole);

    }
}
