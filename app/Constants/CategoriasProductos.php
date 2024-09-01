<?php

namespace App\Constants;

class CategoriasProductos
{
    const PIZZA = 'Pizza';
    const POSTRE = 'Postre';
    const BEBIDA = 'Bebida';
    const MITAD = 'Mitad';
    const OTRO = 'Otro';

    // Agrega aquí más tipos de programas si es necesario
    public static function all(): array
    {
        return [
            self::PIZZA,
            self::POSTRE,
            self::MITAD,
            self::BEBIDA,
            self::OTRO,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }

    public static function getConReceta(): array
    {
        return [
            self::PIZZA,
            self::POSTRE,
            self::MITAD,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }

    public static function getSinReceta(): array
    {
        return [
            self::BEBIDA,
            self::OTRO,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
