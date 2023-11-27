<?php

namespace App\static_data;

final class OrderStatus
{
    const waiting = '0';
    const done = '1';

    public static function toArray()
    {
        return [
            self::waiting,
            self::done,
        ];
    }
}
