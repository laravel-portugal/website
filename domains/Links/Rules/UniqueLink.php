<?php

namespace Domains\Links\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueLink implements Rule
{
    protected static $fake = false;

    public static function isFake()
    {
        return self::$fake;
    }

    public static function fake(bool $fake = true)
    {
        self::$fake = $fake;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (self::$fake) {
            return false;
        }

        // TODO: call the api to find out if this link already exists or not.
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Já existe um registo na base de dados com este endereço URL.';
    }
}
