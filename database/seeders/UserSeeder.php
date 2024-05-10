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
            ['name' => 'Doni', 'nip' => '1234', 'password' => Hash::make('123456'), 'job_title' => 'Direktur'],
            ['name' => 'Dono', 'nip' => '1235', 'password' => Hash::make('123456'), 'job_title' => 'Finance'],
            ['name' => 'Dana', 'nip' => '1236', 'password' => Hash::make('123456'), 'job_title' => 'Staff'],
        ];

        $direktur = User::create($users[0]);
        $direktur->syncRoles('direktur');

        $direktur = User::create($users[1]);
        $direktur->syncRoles('finance');

        $direktur = User::create($users[2]);
        $direktur->syncRoles('staff');
    }
}
