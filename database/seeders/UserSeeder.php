<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Requestor',
                'email' => 'requestor@mail.com',
                'username' => 'requestor',
                'password' => bcrypt('requestorpass'),
            ],
            [
                'name' => 'SPV Gudang',
                'email' => 'spv@mail.com',
                'username' => 'spv',
                'password' => bcrypt('spvpass'),
            ],
            [
                'name' => 'Kepala Gudang',
                'email' => 'head@mail.com',
                'username' => 'head',
                'password' => bcrypt('headpass'),
            ],
            [
                'name' => 'Manager Operasional',
                'email' => 'manager@mail.com',
                'username' => 'manager',
                'password' => bcrypt('managerpass'),
            ],
            [
                'name' => 'Direktur Operasional',
                'email' => 'coo@mail.com',
                'username' => 'coo',
                'password' => bcrypt('coopass'),
            ],
            [
                'name' => 'Direktur Keuangan',
                'email' => 'cfo@mail.com',
                'username' => 'cfo',
                'password' => bcrypt('cfopass'),
            ],
        ];

        foreach ($users as $userData) {
            User::factory()->create($userData);
        }
    }
}
