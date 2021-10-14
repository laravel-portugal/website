<?php

use App\Types\PermissionsType;
use App\Types\RolesType;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SeedPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // @see https://spatie.be/docs/laravel-permission/v5/basic-usage/new-app
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create the permissions
        Permission::create(['name' => PermissionsType::edit_links()->value]);
        Permission::create(['name' => PermissionsType::create_links()->value]);
        Permission::create(['name' => PermissionsType::delete_links()->value]);
        Permission::create(['name' => PermissionsType::moderate_links()->value]);

        // Create Moderator Role
        $moderator = Role::create(['name' => RolesType::moderator()->value]);
        $moderator->givePermissionTo(PermissionsType::moderate_links()->value);

        // Give user role permissions
        $user = Role::create(['name' => RolesType::user()->value]);
        $user->givePermissionTo(PermissionsType::edit_links()->value);
        $user->givePermissionTo(PermissionsType::create_links()->value);
        $user->givePermissionTo(PermissionsType::delete_links()->value);

        // Create the admin
        Role::create(['name' => RolesType::admin()->value]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::truncate();
        Role::truncate();
    }
}
