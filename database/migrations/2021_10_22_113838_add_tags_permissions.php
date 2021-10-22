<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Types\PermissionsType;
use App\Types\RolesType;

class AddTagsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::create(['name' => PermissionsType::moderate_tags()->value]);
        $moderator = Role::findByName(RolesType::moderator());
        $moderator?->givePermissionTo(PermissionsType::moderate_tags()->value);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::query()->where('name',PermissionsType::moderate_tags()->value)->delete();
        $moderator = Role::findByName(RolesType::moderator());
        $moderator?->revokePermissionTo(PermissionsType::moderate_tags()->value);
    }
}
