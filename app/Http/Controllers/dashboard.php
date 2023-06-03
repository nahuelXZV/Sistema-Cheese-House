<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class dashboard extends Controller
{
    private function getMesString($mes)
    {
        $arrayMes = [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        return $arrayMes[$mes];
    }

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

        $pedidosPorProcedencia = DB::table('pedidos')
            ->select(DB::raw('count(*) as cantidad, proveniente, extract(month from created_at) as mes'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('proveniente', DB::raw('extract(month from created_at)'))
            ->orderBy('proveniente', 'asc')
            ->get();

        $arrayProcedencia = [];
        foreach ($pedidosPorProcedencia as $key => $procedencia) {
            $arrayProcedencia[$procedencia->proveniente][$this->getMesString($procedencia->mes)] = $procedencia->cantidad;
        }

        // $proveniencia = ['Local', 'Pedidos Ya', 'Pagina Web', 'Uber Eats', 'Rappi', 'Glovo', 'Whatsapp', 'Telefono', 'Otro'];
        // foreach ($proveniencia as $key => $destino) {
        //     $pedidosPorProcedenciaLocal = $pedidosPorProcedencia->where('proveniente', $destino);
        //     $arrayData = [];
        //     $arrayData[0] = $pedidosPorProcedenciaLocal->where('mes', '1')->first()->cantidad ?? 0;
        //     $arrayData[1] = $pedidosPorProcedenciaLocal->where('mes', '2')->first()->cantidad ?? 0;
        //     $arrayData[2] = $pedidosPorProcedenciaLocal->where('mes', '3')->first()->cantidad ?? 0;
        //     $arrayData[3] = $pedidosPorProcedenciaLocal->where('mes', '4')->first()->cantidad ?? 0;
        //     $arrayData[4] = $pedidosPorProcedenciaLocal->where('mes', '5')->first()->cantidad ?? 0;
        //     $arrayData[5] = $pedidosPorProcedenciaLocal->where('mes', '6')->first()->cantidad ?? 0;
        //     $arrayData[6] = $pedidosPorProcedenciaLocal->where('mes', '7')->first()->cantidad ?? 0;
        //     $arrayData[7] = $pedidosPorProcedenciaLocal->where('mes', '8')->first()->cantidad ?? 0;
        //     $arrayData[8] = $pedidosPorProcedenciaLocal->where('mes', '9')->first()->cantidad ?? 0;
        //     $arrayData[9] = $pedidosPorProcedenciaLocal->where('mes', '10')->first()->cantidad ?? 0;
        //     $arrayData[10] = $pedidosPorProcedenciaLocal->where('mes', '11')->first()->cantidad ?? 0;
        //     $arrayData[11] = $pedidosPorProcedenciaLocal->where('mes', '12')->first()->cantidad ?? 0;
        //     $arrayProcedencia[$destino] = $arrayData;
        // }

        $pizzasMasVendidas = DB::table('detalle_pedidos')
            ->select(DB::raw('sum(cantidad) as cantidad, extract(month from detalle_pedidos.created_at) as mes, productos.nombre as nombre'))
            ->join('productos', 'productos.id', '=', 'detalle_pedidos.producto_id')
            ->whereYear('detalle_pedidos.created_at', date('Y'))
            ->groupBy('productos.nombre', DB::raw('extract(month from detalle_pedidos.created_at)'))
            ->orderBy('cantidad', 'desc')
            ->limit(5)
            ->get();


        $arrayPizzas = [];
        foreach ($pizzasMasVendidas as $key => $pizza) {
            $arrayPizzas[$pizza->nombre][$this->getMesString($pizza->mes)] = $pizza->cantidad;
        }

        $pizzaListName = Producto::where('categoria', 'Pizza')->get()->pluck('nombre')->toArray();

        $arrayColores = [
            '#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
            '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
            '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        ];

        return view('dashboard', compact('ingredientes', 'comprasDinero', 'ventasDinero', 'comprasCantidad', 'ventasCantidad', 'arrayProcedencia', 'arrayPizzas', 'pizzaListName', 'arrayColores'));
    }
}
