<?php

namespace App\static_data;

final class SizeMeal
{
    const small = 'small';
    const medium = 'medium';
    const large = 'large';

    public static function toArray()
    {
        return [
            self::small,
            self::medium,
            self::large
        ];
    }
}
