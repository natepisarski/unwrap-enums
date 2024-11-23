<?php
declare(strict_types = 1);

namespace Natepisarski\UnwrapEnums;

use BackedEnum;
use UnitEnum;

/**
 * Unwraps an array of enums or a single enum.
 *
 * @param mixed $enums A single enum or iterable of enums. If single, the function returns 1 single value. Otherwise, it will
 * return an array of values. Any value that's already unwrapped will be returned as-is.
 * @param bool $recursive If true, it will unwrap all nested enums inside the iterable
 * @return array|BackedEnum
 * @throws EnumUnwrapException
 */
function unwrap_enums(mixed $enums, bool $recursive = true): array|BackedEnum
{
    if (! is_iterable($enums)) {
        if (! $enums instanceof UnitEnum) {
            return $enums;
        }

        if (! $enums instanceof BackedEnum) {
            $enumClass = $enums::class;
            throw new EnumUnwrapException("$enumClass was passed to unwrap_enums but had no backing value");
        }

        return $enums->value;
    }

    $unwrapped = [];
    if ($recursive) {
        foreach ($enums as $enum) {
            $unwrapped[] = unwrap_enums($enum);
        }
    } else {
        foreach ($enums as $enum) {
            $unwrapped[] = unwrap_enums($enum, false);
        }
    }

    return $unwrapped;
}