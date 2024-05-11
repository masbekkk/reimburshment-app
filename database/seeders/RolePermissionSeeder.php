<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $direktur = Role::create(['name' => 'direktur']);
        $finance = Role::create(['name' => 'finance']);
        $staff = Role::create(['name' => 'staff']);
        $super_admin = Role::create(['name' => 'super admin']);

        $crudReimburshment = Permission::create(['name' => 'crud reimburshment']);
        $editStatusReimburshment = Permission::create(['name' => 'edit status reimburshment']);
        $createStaffAccount = Permission::create(['name' => 'create staff account']);
        $editStaffAccount = Permission::create(['name' => 'edit staff account']);
        $deleteStaffAccount = Permission::create(['name' => 'delete staff account']);
        $crudRolePemission = Permission::create(['name' => 'crud role']);

        $direktur->givePermissionTo([$editStatusReimburshment, $createStaffAccount, $editStaffAccount, $deleteStaffAccount]);
        $finance->givePermissionTo([$editStatusReimburshment]);
        $staff->givePermissionTo($crudReimburshment);
        $super_admin->givePermissionTo($crudRolePemission);
    }
}
