<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $google2fa = new Google2FA();

        $users = [
            [
                'name' => 'Requestor',
                'email' => 'requestor@mail.com',
                'username' => 'requestor',
                'password' => bcrypt('requestorpass'),
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ],
            [
                'name' => 'SPV Gudang',
                'email' => 'spv@mail.com',
                'username' => 'spv',
                'password' => bcrypt('spvpass'),
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ],
            [
                'name' => 'Kepala Gudang',
                'email' => 'head@mail.com',
                'username' => 'head',
                'password' => bcrypt('headpass'),
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ],
            [
                'name' => 'Manager Operasional',
                'email' => 'manager@mail.com',
                'username' => 'manager',
                'password' => bcrypt('managerpass'),
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ],
            [
                'name' => 'Direktur Operasional',
                'email' => 'coo@mail.com',
                'username' => 'coo',
                'password' => bcrypt('coopass'),
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ],
            [
                'name' => 'Direktur Keuangan',
                'email' => 'cfo@mail.com',
                'username' => 'cfo',
                'password' => bcrypt('cfopass'),
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ],
        ];

        foreach ($users as $userData) {
            User::factory()->create($userData);
        }
    }
}
