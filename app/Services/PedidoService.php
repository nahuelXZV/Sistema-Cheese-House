<?php

namespace App\Services;

use App\Constants\CategoriasProductos;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Receta;
use Illuminate\Support\Facades\DB;

class PedidoService
{
    public function __construct() {}

    static public function CreatePedido(array $array)
    {
        try {
            return DB::transaction(function () use ($array) {
                $productos = $array['productos'];
                unset($array['productos']);
                $array['user_id'] = auth()->user()->id;
                $new = new Pedido($array);
                $new->save();
                // Guardar Detalles del Pedido
                foreach ($productos as $producto) {
                    $detallePedido = [
                        'pedido_id' => $new->id,
                        'producto_id' => intval($producto['producto_id']),
                        'cantidad' => floatval($producto['cantidad']),
                        'precio' => floatval($producto['precio']),
                        'monto_total' => $producto['monto_total'],
                        'sub_total' => $producto['subTotal'],
                        'descuento' => $producto['descuento'],
                    ];
                    $detalle_pedido = DetallePedido::create($detallePedido);
                    // CATEGORIAS
                    $listaProductosRecetas = CategoriasProductos::getConReceta();
                    $listaProductoSinRecetas = CategoriasProductos::getSinReceta();
                    // STOCK
                    $producto = Producto::find($detalle_pedido->producto_id);
                    if (in_array($producto->categoria, $listaProductoSinRecetas)) {
                        $producto->stock = floatval($producto->stock) - floatval($detalle_pedido->cantidad);
                        $producto->save();
                        continue;
                    }
                    if (!in_array($producto->categoria, $listaProductosRecetas)) continue;
                    $receta = Receta::find($producto->receta_id);
                    foreach ($receta->ingredientes as $ingrediente) {
                        $ingrediente->stock = floatval($ingrediente->stock) - (floatval($detalle_pedido->cantidad) * floatval($ingrediente->pivot->cantidad));
                        $ingrediente->save();
                    }
                }
                return $new;
            });
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }

    static public function UpdatePedido($id, array $array)
    {
        try {
            return DB::transaction(function () use ($id, $array) {
                // CATEGORIAS
                $listaProductosRecetas = CategoriasProductos::getConReceta();
                $listaProductoSinRecetas = CategoriasProductos::getSinReceta();

                $pedido = Pedido::find($id);
                $productos = $array['productos'];
                unset($array['productos']);

                $pedido->fill($array);
                $pedido->save();

                // Eliminar detalles
                $detalle_pedido = DetallePedido::where('pedido_id', $id)->get();
                foreach ($detalle_pedido as $detalle) {
                    $producto = Producto::find($detalle->producto_id);
                    if (in_array($producto->categoria, $listaProductoSinRecetas)) {
                        $producto->stock = floatval($producto->stock) + floatval($detalle->cantidad);
                        $producto->save();
                    }
                    if (in_array($producto->categoria, $listaProductosRecetas)) {
                        $receta = Receta::find($producto->receta_id);
                        foreach ($receta->ingredientes as $ingrediente) {
                            $ingrediente->stock = floatval($ingrediente->stock) + (floatval($detalle->cantidad) * floatval($ingrediente->pivot->cantidad));
                            $ingrediente->save();
                        }
                    };
                    $detalle->delete();
                }
                // Guardar Detalles del Pedido
                foreach ($productos as $producto) {
                    $detallePedido = [
                        'pedido_id' => $pedido->id,
                        'producto_id' => intval($producto['producto_id']),
                        'cantidad' => floatval($producto['cantidad']),
                        'precio' => floatval($producto['precio']),
                        'monto_total' => $producto['monto_total'],
                        'sub_total' => $producto['subTotal'],
                        'descuento' => $producto['descuento'],
                    ];
                    $detalle_pedido = DetallePedido::create($detallePedido);
                    // STOCK
                    $producto = Producto::find($detalle_pedido->producto_id);
                    if (in_array($producto->categoria, $listaProductoSinRecetas)) {
                        $producto->stock = floatval($producto->stock) - floatval($detalle_pedido->cantidad);
                        $producto->save();
                        continue;
                    }
                    if (!in_array($producto->categoria, $listaProductosRecetas)) continue;
                    $receta = Receta::find($producto->receta_id);
                    foreach ($receta->ingredientes as $ingrediente) {
                        $ingrediente->stock = floatval($ingrediente->stock) - (floatval($detalle_pedido->cantidad) * floatval($ingrediente->pivot->cantidad));
                        $ingrediente->save();
                    }
                }
                return $pedido;
            });
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function DeletePedido($id)
    {
        $pedido = Pedido::find($id);
        foreach ($pedido->detalle_pedidos as $detalle) {
            DetallePedido::DeleteDetallePedido($detalle->id);
        }
        $pedido->delete();
        return $pedido;
    }

    static public function GetPedidos($attribute, $order, $paginate)
    {
        $pedidos = Pedido::join('users', 'users.id', '=', 'pedidos.user_id')
            ->select('pedidos.*', 'users.name as user_name')
            ->orWhere('pedidos.fecha', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.hora', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.estado', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.monto_total', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.metodo_pago', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.detalles', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.proveniente', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('users.name', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('pedidos.fecha', 'DESC')
            ->orderBy('pedidos.hora', 'ASC')
            ->paginate($paginate);
        return $pedidos;
    }

    static public function GetPedido($id)
    {
        $pedido = Pedido::find($id);
        return $pedido;
    }

    static public function GetPedidoAll()
    {
        $pedidos = Pedido::all();
        return $pedidos;
    }
}
