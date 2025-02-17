<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des permissions
        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'join project']);
        Permission::create(['name' => 'view tasks']);

        // Créer des rôles et attribuer des permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->assignPermission('create project');
        $admin->assignPermission('join project');
        $admin->assignPermission('view tasks');

        $member = Role::create(['name' => 'member']);
        $member->assignPermission('join project');
        $member->assignPermission('view tasks');
    }
}
