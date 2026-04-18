<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // membuat daftar permission
        $permissions = [
            'request.index',
            'request.create',
            'request.store',
            'request.show',
            'request.edit',
            'request.update',
            'request.destroy',
            'request.data-json',

            'approval.index',
            'approval.status',
            'approval.show',
            'approval.data-json',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // roles
        $requester = Role::firstOrCreate(['name' => 'requester']);
        $approver  = Role::firstOrCreate(['name' => 'approver']);

        // permission by prefix
        $requestPermissions = Permission::where('name', 'like', 'request.%')->get();
        $approvalPermissions = Permission::where('name', 'like', 'approval.%')->get();

        // assign 
        $requester->syncPermissions($requestPermissions);
        $approver->syncPermissions($approvalPermissions);
    }
}
