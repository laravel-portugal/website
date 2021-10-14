<?php

namespace App\Types;

use Illuminate\Support\Collection;
use Spatie\Enum\Laravel\Enum;

abstract class BaseType extends Enum
{
    public static function attemptFrom($value, $default = null): static
    {
        if ($value instanceof self) {
            return $value;
        }

        if (null === $value) {
            return $default;
        }

        return static::tryFrom($value) ?? $default;
    }

    public static function contains($value): bool
    {
        return collect(static::values())->contains($value);
    }

    public static function containsLabel($value): bool
    {
        return collect(static::labels())->has(strtolower($value));
    }

    public static function translate($prefix = ''): array
    {
        $values = collect(static::values())->flip()->toArray();

        return trans_values($values, $prefix);
    }

    public static function toGuideLine(): array
    {
        $values = collect(static::values())->flip();

        return $values->combine(static::values())->toArray();
    }

    public static function translateKeys($prefix = ''): array
    {
        $values = collect(static::values())->flip()->toArray();

        return trans_keys($values, $prefix);
    }

    public static function toCollection(): Collection
    {
        return collect(static::toArray());
    }

    public function notOneOfTheFollowing(...$others): bool
    {
        try {
            foreach ($others as $enum) {
                if (! $enum instanceof static) {
                    $enum = static::from($others);
                }

                $result = $this->equals($enum);

                if (true === $result) {
                    return false;
                }
            }
        } catch (\Exception $e) {
        }

        return true;
    }

    public function oneOfTheFollowing(...$others): bool
    {
        try {
            foreach ($others as $enum) {
                if (! $enum instanceof self) {
                    $enum = static::attemptFrom($others);
                }

                return $this->equals($enum);
            }
        } catch (\Exception $e) {
        }

        return false;
    }
}
