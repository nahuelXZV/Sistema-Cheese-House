<?php

namespace App\Console\Commands;

use App\Constants\CategoriasProductos;
use App\Models\DetalleCompra;
use App\Models\DetallePedido;
use App\Models\Ingrediente;
use App\Models\Producto;
use App\Models\Receta;
use App\Models\ReporteIngrediente;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReporteIngredientes extends Command
{
    protected $signature = 'app:reporte-ingredientes';

    protected $description = 'Genera los datos del reporte de ingredientes, Diariamente a las 23:59';

    public function handle()
    {
        Log::info('Entro a generar el reporte de ingredientes');
        $fecha = now()->format('Y-m-d');
        $diaAnterior = now()->subDay()->format('Y-m-d');

        $creado =  ReporteIngrediente::where('fecha', $fecha)->orderBy('fecha', 'desc')->first();
        if ($creado) return;
        Log::info('Generando reporte de ingredientes para la fecha: ' . $fecha);
        try {

            // VENTAS
            $detallesPedidos = DetallePedido::whereDate('created_at', $fecha)->get();
            $listaVenta = [
                'ingredientes' => [],
                'productos' => [],
            ];
            foreach ($detallesPedidos as $detalle) {
                $listaProductosRecetas = CategoriasProductos::getConReceta();
                $listaProductoSinRecetas = CategoriasProductos::getSinReceta();

                $producto = Producto::find($detalle->producto_id);

                if (in_array($producto->categoria, $listaProductoSinRecetas)) {
                    $stockDescontar = floatval($detalle->cantidad);
                    $listaVenta['productos'][] = [
                        'producto_id' => $producto->id,
                        'stockDescontar' => $stockDescontar,
                    ];
                    continue;
                }
                if (!in_array($producto->categoria, $listaProductosRecetas)) continue;
                $receta = Receta::find($producto->receta_id);
                foreach ($receta->ingredientes as $ingrediente) {
                    $stockDescontar = floatval($detalle->cantidad) * floatval($ingrediente->pivot->cantidad);
                    $listaVenta['ingredientes'][] = [
                        'ingrediente_id' => $ingrediente->id,
                        'stockDescontar' => $stockDescontar,
                    ];
                }
            }

            // COMPRAS
            $detallesCompras = DetalleCompra::whereDate('created_at', $fecha)->get();
            $listaCompra = [
                'ingredientes' => [],
                'productos' => [],
            ];
            foreach ($detallesCompras as $detalle) {
                $producto = Producto::find($detalle->producto_id);
                if ($detalle->producto_id) {
                    $stockAumentar = floatval($detalle->cantidad);
                    $listaCompra['productos'][] = [
                        'producto_id' => $producto->id,
                        'stockAumentar' => $stockAumentar,
                    ];
                    continue;
                }
                if (!$detalle->ingrediente_id) continue;
                $stockAumentar = floatval($detalle->cantidad);
                $listaCompra['ingredientes'][] = [
                    'ingrediente_id' => $ingrediente->id,
                    'stockAumentar' => $stockAumentar,
                ];
            }


            // AGRUPACION DE INGREDIENTES
            $resultVentasIngredientes = [];
            foreach ($listaVenta['ingredientes'] as $item) {
                $id = $item['ingrediente_id'];
                $stock = $item['stockDescontar'];
                if (isset($resultVentasIngredientes[$id])) {
                    $resultVentasIngredientes[$id] += $stock;
                } else {
                    $resultVentasIngredientes[$id] = $stock;
                }
            }

            $resultComprasIngredientes = [];
            foreach ($listaCompra['ingredientes'] as $item) {
                $id = $item['ingrediente_id'];
                $stock = $item['stockAumentar'];
                if (isset($resultComprasIngredientes[$id])) {
                    $resultComprasIngredientes[$id] += $stock;
                } else {
                    $resultComprasIngredientes[$id] = $stock;
                }
            }

            $ingredientes = Ingrediente::all();
            // INGREDIENTES
            foreach ($ingredientes as $ingrediente) {
                $reporteAnterior = ReporteIngrediente::where('ingrediente_id', $ingrediente->id)->where('fecha', $diaAnterior)->orderBy('fecha', 'desc')->first();
                if (!$reporteAnterior) $stock_inicial = 0;
                else $stock_inicial = $reporteAnterior->stock_final;

                $stock_ventas = $resultVentasIngredientes[$ingrediente->id] ?? 0;
                $stock_compras = $resultComprasIngredientes[$ingrediente->id] ?? 0;
                $stock_actual = $stock_inicial + $stock_compras - $stock_ventas;

                ReporteIngrediente::create([
                    'ingrediente_id' => $ingrediente->id,
                    'nombre' => $ingrediente->nombre,
                    'precio' => $ingrediente->precio ?? 0,
                    'fecha' => $fecha,
                    'stock_inicial' => $stock_inicial,
                    'stock_ventas' => $stock_ventas,
                    'stock_compras' => $stock_compras,
                    'stock_final' => $stock_actual,
                ]);
            }

            // AGRUPACION DE PRODUCTOS
            $resultVentasProductos = [];
            foreach ($listaVenta['productos'] as $item) {
                $id = $item['producto_id'];
                $stock = $item['stockDescontar'];
                if (isset($resultVentasProductos[$id])) {
                    $resultVentasProductos[$id] += $stock;
                } else {
                    $resultVentasProductos[$id] = $stock;
                }
            }

            $resultComprasProductos = [];
            foreach ($listaCompra['productos'] as $item) {
                $id = $item['producto_id'];
                $stock = $item['stockAumentar'];
                if (isset($resultComprasProductos[$id])) {
                    $resultComprasProductos[$id] += $stock;
                } else {
                    $resultComprasProductos[$id] = $stock;
                }
            }

            // PRODUCTOS
            $productos = Producto::whereNull('receta_id')->get();
            foreach ($productos as $producto) {
                $reporteAnterior = ReporteIngrediente::where('producto_id', $producto->id)->where('fecha', $diaAnterior)->orderBy('fecha', 'desc')->first();
                if (!$reporteAnterior) $stock_inicial = 0;
                else $stock_inicial = $reporteAnterior->stock_final;

                $stock_ventas = $resultVentasProductos[$producto->id] ?? 0;
                $stock_compras = $resultComprasProductos[$producto->id] ?? 0;
                $stock_actual = $stock_inicial + $stock_compras - $stock_ventas;

                ReporteIngrediente::create([
                    'producto_id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio ?? 0,
                    'fecha' => $fecha,
                    'stock_inicial' => $stock_inicial,
                    'stock_ventas' => $stock_ventas,
                    'stock_compras' => $stock_compras,
                    'stock_final' => $stock_actual,
                ]);
            }

            Log::info('Reporte de ingredientes generado correctamente');
        } catch (\Throwable $th) {
            Log::error('Error al generar el reporte de ingredientes: ' . $th->getMessage());
        }
    }
}
