<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ApprovalStep;

class ApproverLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'spv@mail.com'     => 1,
            'head@mail.com'    => 2,
            'manager@mail.com' => 3,
            'coo@mail.com'     => 4,
            'cfo@mail.com'     => 5,
        ];

        foreach ($data as $email => $level) {
            $user = User::where('email', $email)->first();
            if ($user) {
                ApprovalStep::create([
                    'user_id' => $user->id,
                    'level' => $level,
                ]);
            }
        }
    }
}
