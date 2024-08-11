<?php

namespace App\Constants;

class ProvenienciaVenta
{
    const PICK_UP = 'Pick-Up';
    const LOCAL = 'Local';
    const PAGINA_WEB = 'Pagina Web';
    const PEDIDOS_YA = 'Pedidos Ya';
    const WHATSAPP = 'Whatsapp';
    const TELEFONO = 'Telefono';
    const DELIVERY = 'Delivery';
    const OTRO = 'Otro';

    public static function getProveniencias()
    {
        return [
            self::PICK_UP,
            self::LOCAL,
            self::PAGINA_WEB,
            self::PEDIDOS_YA,
            self::WHATSAPP,
            self::TELEFONO,
            self::DELIVERY,
            self::OTRO,
        ];
    }

}
