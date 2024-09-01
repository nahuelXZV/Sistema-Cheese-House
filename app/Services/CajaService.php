<?php

namespace App\Services;

use App\Models\Caja;

class CajaService
{
    public function __construct() {}

    static public function CreateCaja(array $array) {}

    static public function UpdateCaja(array $array) {}

    static public function DeleteCaja(int $id) {}

    static public function GetCaja(int $id)
    {
        $caja = Caja::find($id);
        return $caja;
    }

    static public function GetCajas()
    {
        $recetas = Caja::orderBy('fecha', 'desc')
            ->paginate(10);
        return $recetas;
    }
}
