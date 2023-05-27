<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboard extends Controller
{
    //

    public function index()
    {
        // funcion sql para encontrar los ingredientes que esten cerca de su stock minimo solo 10

        $ingredientes = DB::table('ingredientes')
            ->whereColumn('stock', '<=', 'stock_minimo')
            ->limit(12)
            ->get();

        // funcion que me devuelve la cantidad de dinero que se ha gastado en compras en el mes actual
        $comprasDinero = DB::table('nota_compras')
            ->whereMonth('created_at', date('m'))
            ->sum('monto_total');

        // funcion que me devulve la cantidad de dinero que se ha vendido en los pedidos del mes actual
        // $ventas = DB::table('pedidos')
        //     ->whereMonth('created_at', date('m'))
        //     ->sum('monto_total');




        return view('dashboard', compact('ingredientes'), compact('comprasDinero'));
    }
}
