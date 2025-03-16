<?php

namespace App\Services;

use App\Models\Combo;
use App\Models\ComboProducto;
use Illuminate\Support\Facades\DB;

class ComboService
{
    public function __construct() {}

    static public function CreateCombo(array $array)
    {
        try {
            return DB::transaction(function () use ($array) {
                $productos = $array['productos'];
                unset($array['productos']);
                $new = new Combo($array);
                $new->save();

                // Guardar Detalles del Pedido
                foreach ($productos as $producto) {
                    $detalleCombo = [
                        'combo_id' => $new->id,
                        'producto_id' => intval($producto['producto_id']),
                        'cantidad' => floatval($producto['cantidad']),
                    ];
                    $detalle_pedido = ComboProducto::create($detalleCombo);
                    $detalle_pedido->save();
                }
                return $new;
            });
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function UpdateCombo($id, array $array)
    {

        try {
            return DB::transaction(function () use ($id, $array) {
                // CATEGORIAS
                $combo = Combo::find($id);
                $productos = $array['productos'];
                unset($array['productos']);

                $combo->fill($array);
                $combo->save();

                // Eliminar detalles
                $productoCombos = ComboProducto::where('combo_id', $id)->get();
                foreach ($productoCombos as $detalle) {
                    $detalle->delete();
                }

                // Guardar Detalles del Pedido
                foreach ($productos as $producto) {
                    $detalleCombo = [
                        'combo_id' => $combo->id,
                        'producto_id' => intval($producto['producto_id']),
                        'cantidad' => floatval($producto['cantidad']),
                    ];
                    $detalle_pedido = ComboProducto::create($detalleCombo);
                    $detalle_pedido->save();
                }
                return $combo;
            });
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function DeleteCombo(int $id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $combo = Combo::find($id);
                $combo->delete();
                return true;
            });
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function GetCombo(int $id)
    {
        $Combo = Combo::find($id);
        return $Combo;
    }

    static public function GetAllCombos()
    {
        $combos = Combo::all();
        return $combos;
    }

    static public function GetCombos($attribute, $order, $paginate)
    {
        $pedidos = Combo::Where('combos.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->paginate($paginate);
        return $pedidos;
    }
}
