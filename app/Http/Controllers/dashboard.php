<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboard extends Controller
{
    //

    public function index()
    {

        $ingredientes = DB::table('ingredientes')
            ->whereColumn('stock', '<=', 'stock_minimo')
            ->limit(12)
            ->get();

        $comprasDinero = DB::table('nota_compras')
            ->whereMonth('created_at', date('m'))
            ->sum('monto_total');

        $ventasDinero = DB::table('pedidos')
            ->whereMonth('created_at', date('m'))
            ->sum('monto_total');

        $comprasCantidad = DB::table('nota_compras')
            ->whereMonth('created_at', date('m'))
            ->count();

        $ventasCantidad = DB::table('pedidos')
            ->whereMonth('created_at', date('m'))
            ->count();


        // funcion que agrupa las ventas de este año por mes para postgres
        // $ventasPorMes = DB::table('pedidos')
        //     ->select(DB::raw('sum(monto_total) as total, extract(month from created_at) as mes'))
        //     ->whereYear('created_at', date('Y'))
        //     ->groupBy(DB::raw('extract(month from created_at)'))
        //     ->get();

        // function que me agrupe la cantidad de pedidos que se realizan de diferentes procedencia de este año por meses para postgres
        $pedidosPorProcedencia = DB::table('pedidos')
            ->select(DB::raw('count(*) as cantidad, proveniente'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('proveniente', DB::raw('extract(month from created_at)'))
            ->get();

        // $pedidosPorProcedencia = DB::table('pedidos')
        //     ->select(DB::raw('count(*) as cantidad, procedencia'))
        //     ->groupBy('procedencia')
        //     ->get();

        // funcion que me agrupe las pizzas mas vendidas de este mes
        $pizzasMasVendidas = DB::table('detalle_pedidos')
            ->select(DB::raw('sum(cantidad) as cantidad, producto_id'))
            ->whereMonth('created_at', date('m'))
            ->groupBy('producto_id')
            ->orderBy('cantidad', 'desc')
            ->limit(5)
            ->get();

        // funcion que me agrupe las pizzas mas vendidas del mes pasado
        $pizzasMasVendidasMesPasado = DB::table('detalle_pedidos')
            ->select(DB::raw('sum(cantidad) as cantidad, producto_id'))
            ->whereMonth('created_at', date('m')-1)
            ->groupBy('producto_id')
            ->orderBy('cantidad', 'desc')
            ->limit(5)
            ->get();


        return view('dashboard', compact('ingredientes', 'comprasDinero', 'ventasDinero', 'comprasCantidad', 'ventasCantidad', 'pedidosPorProcedencia', 'pizzasMasVendidas'));
    }
}
