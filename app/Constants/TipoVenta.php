<?php

namespace App\Constants;

class TipoVenta
{
    const LOCAL = 'Local';
    const LLEVAR = 'Llevar';
    const PICK_UP = 'Pick-Up';
    const OTRO = 'Otro';

    public static function getTipoVentas()
    {
        return [
            self::LOCAL,
            self::LLEVAR,
            self::PICK_UP,
            self::OTRO,
        ];
    }
}
