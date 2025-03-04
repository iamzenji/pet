<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateLaratrustTables();

        $config = Config::get('laratrust_seeder.roles_structure');

        if ($config === null) {
            $this->command->error("The configuration has not been published. Did you run `php artisan vendor:publish --tag=\"laratrust-seeder\"`?");
            return false;
        }

        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $roleName => $modules) {
            // Create role
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'display_name' => ucwords(str_replace('_', ' ', $roleName)),
                'description' => ucwords(str_replace('_', ' ', $roleName))
            ]);

            $permissions = [];

            $this->command->info("Creating Role: " . strtoupper($roleName));

            // Assign permissions
            foreach ($modules as $module => $value) {
                foreach (explode(',', $value) as $perm) {
                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = Permission::firstOrCreate([
                        'name' => $module . '-' . $permissionValue,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                    ])->id;

                    $this->command->info("Creating Permission: $permissionValue for $module");
                }
            }

            // Attach permissions to the role
            $role->permissions()->sync($permissions);

            if (Config::get('laratrust_seeder.create_users')) {
                $this->command->info("Creating '$roleName' user");

                // Create a default user for each role
                $user = User::create([
                    'name' => ucwords(str_replace('_', ' ', $roleName)),
                    'email' => $roleName . '@app.com',
                    'password' => bcrypt('password'),
                ]);

                $user->attachRole($role);
            }
        }
    }

    /**
     * Truncates all Laratrust tables and users table
     *
     * @return void
     */
    public function truncateLaratrustTables()
    {
        $this->command->info('Truncating User, Role, and Permission tables');
        Schema::disableForeignKeyConstraints();

        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();

        if (Config::get('laratrust_seeder.truncate_tables')) {
            DB::table('roles')->truncate();
            DB::table('permissions')->truncate();

            if (Config::get('laratrust_seeder.create_users')) {
                DB::table('users')->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
