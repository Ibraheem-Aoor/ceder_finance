<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermsissonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = $this->getDataToSeed();
        $created_permissions = [];
        foreach ($permissions as $section => $section_permissions) {
            foreach ($section_permissions as $permission) {
                if (is_array($permission)) {
                    continue;
                }
                $created_permissions[] = Permission::updateOrcreate(
                    [
                        'name' => $permission . ' ' . $section,
                        'guard_name' => 'web',
                    ],
                    [
                        'name' => $permission . ' ' . $section,
                        'guard_name' => 'web',

                    ]
                )->id;
                $this->createRolesAndAssignPermissions($created_permissions, @$section_permissions['roles']);
            }
        }

        Artisan::call('cache:clear');
    }

    protected function getDataToSeed(): array
    {
        return [
            // Employee Permissions
            'employees' => [
                'manage',
                'view',
                'create',
                'edit',
                'delete',
                'roles' => [
                    'HR',
                ],
            ],
        ];
    }


    /**
     * Create roles and assign permissions
     */
    protected function createRolesAndAssignPermissions(array $created_permissions, array $roles = [])
    {
        foreach ($roles as $role) {
            $role = Role::where('name', $role)->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
            $role->givePermissionTo($created_permissions);
        }
    }
}
