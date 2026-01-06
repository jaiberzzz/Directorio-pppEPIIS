<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $roleSuperAdmin = Role::create(['name' => 'Superadmin']);
        $roleDocente = Role::create(['name' => 'Docente']);
        $roleEstudiante = Role::create(['name' => 'Estudiante']);

        // Create Permissions (Optional, can add detailed permissions later)
        // Permission::create(['name' => 'edit articles']);

        // Create Admin User
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($roleSuperAdmin);

        // Create a Docente User for testing
        $docente = User::create([
            'name' => 'Docente Supervisor',
            'email' => 'docente@example.com',
            'password' => Hash::make('password'),
        ]);
        $docente->assignRole($roleDocente);
    }
}
