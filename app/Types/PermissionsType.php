<?php

namespace App\Types;

/**
 * @method static self edit_links()
 * @method static self create_links()
 * @method static self delete_links()
 * @method static self moderate_links()
 * @method static self moderate_tags()
 */
final class PermissionsType extends BaseType
{
    protected static function values(): array
    {
        return [
            'edit_links' => 'edit-links',
            'create_links' => 'create-links',
            'delete_links' => 'delete-links',
            'moderate_links' => 'moderate-links',
            'moderate_tags' => 'moderate-tags',
        ];
    }

    protected static function labels(): array
    {
        return [
            'edit_links' => 'Edit Links',
            'create_links' => 'Create Links',
            'delete_links' => 'Delete Links',
            'moderate_links' => 'Moderate Links',
            'moderate-tags' => 'Moderate Tags',
        ];
    }
}
