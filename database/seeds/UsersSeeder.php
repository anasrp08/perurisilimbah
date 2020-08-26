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

         

        // Create Admin sample
        $admin = new User();
        $admin->name = 'Admin Limbah';
        $admin->email = 'admin@limbahperuri';
        
        $admin->password = bcrypt('admin123');
        $admin->avatar = "admin_avatar.jpg";
        $admin->is_verified = 1;
        $admin->save();
        $admin->attachRole($adminRole);

        // Create Sample member
        $bc = new User();
        $bc->name = 'Operator';
        $bc->email = 'operator@limbahperuri';
        
        $bc->password = bcrypt('operator123');
        $bc->avatar = "operator_avatar.png";
        $bc->is_verified = 1;
        $bc->save();
        $bc->attachRole($beacukaiRole);

      
    }
}
