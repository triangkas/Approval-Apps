<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'requestor@mail.com'    => 'requester',
            'spv@mail.com'          => 'approver',
            'head@mail.com'         => 'approver',
            'manager@mail.com'      => 'approver',
            'coo@mail.com'          => 'approver',
            'cfo@mail.com'          => 'approver',
        ];

        foreach ($map as $email => $roleName) {
            $user = User::where('email', $email)->first();

            if ($user) {
                $user->syncRoles([$roleName]);
            }
        }
    }
}
