<?php

namespace App\Constants;

class MetodoPagos
{
    const EFECTIVO = 'Efectivo';
    const TRANSFERENCIA_BANCARIA = 'Transferencia Bancaria';
    const QR = 'QR';
    const TARJETA = 'Tarjeta';
    const CORTESIA = 'Cortesia';
    const OTRO = 'Otro';

    public static function getMetodoPagos()
    {
        return [
            self::EFECTIVO,
            //self::TRANSFERENCIA_BANCARIA,
            self::QR,
            self::TARJETA,
            //self::CORTESIA,
            //self::OTRO,
        ];
    }
}
