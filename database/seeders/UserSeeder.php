<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Doni', 'username' => 'doni', 'password' => Hash::make('123456'), 'job_title' => 'Direktur'],
            ['name' => 'Dono', 'username' => 'dono', 'password' => Hash::make('123456'), 'job_title' => 'Stakeholder'],
            ['name' => 'Dona', 'username' => 'dona', 'password' => Hash::make('123456'), 'job_title' => 'Admin'],
        ];

        $direktur = User::create($users[0]);
        $direktur->syncRoles(['direktur', 'super admin']);

        $direktur = User::create($users[1]);
        $direktur->syncRoles('stakeholder');

        $direktur = User::create($users[2]);
        $direktur->syncRoles('admin');
    }
}
