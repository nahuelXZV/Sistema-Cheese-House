<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio',
        'monto_total',
        'detalles',
        'mitad_uno',
        'mitad_dos',
    ];

    // TODO VALIDATIONS
    static public $validate = [];
    static public $messages = [];

    // TODO RELATIONS
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }


    // TODO FUNCTIONS
    static private function UpdateStock($detalle_id, $multiplo)
    {
        $recetas = ['Pizza', 'Postre'];
        $sinReceta = ['Bebida', 'Otro'];
        $detalle_pedido = DetallePedido::find($detalle_id);
        $producto = Producto::find($detalle_pedido->producto_id);
        if (in_array($producto->categoria, $sinReceta)) {
            $producto->stock = $producto->stock + ($detalle_pedido->cantidad * $multiplo);
            $producto->save();
            return;
        }

        if (!in_array($producto->categoria, $recetas))  return;

        if (!$detalle_pedido->mitad_uno && !$detalle_pedido->mitad_dos) {
            $receta = Receta::find($producto->receta_id);
            foreach ($receta->ingredientes as $ingrediente) {
                $ingrediente->stock = $ingrediente->stock + ($detalle_pedido->cantidad * $ingrediente->pivot->cantidad * $multiplo);
                $ingrediente->save();
            }
            return;
        }


        $mitad_uno = Producto::find($detalle_pedido->mitad_uno);
        $receta_uno = Receta::find($mitad_uno->receta_id);
        $mitad_dos = Producto::find($detalle_pedido->mitad_dos);
        $receta_dos = Receta::find($mitad_dos->receta_id);
        foreach ($receta_uno->ingredientes as $ingrediente) {
            $ingrediente->stock = $ingrediente->stock + ($detalle_pedido->cantidad * $ingrediente->pivot->cantidad * $multiplo) / 2;
            $ingrediente->save();
        }
        foreach ($receta_dos->ingredientes as $ingrediente) {
            $ingrediente->stock = $ingrediente->stock + ($detalle_pedido->cantidad * $ingrediente->pivot->cantidad * $multiplo) / 2;
            $ingrediente->save();
        }
        return;
    }


    static public function CreateDetallePedido(array $array)
    {
        $new = new DetallePedido($array);
        $new->save();
        self::UpdateStock($new->id, -1);
        return $new;
    }

    static public function UpdateDetallePedido($id, array $array)
    {
        $detalle_pedido = DetallePedido::find($id);
        $detalle_pedido->fill($array);
        $detalle_pedido->save();
        self::UpdateStock($detalle_pedido->id, -1);
        return $detalle_pedido;
    }

    static public function DeleteDetallePedido($id)
    {
        $detalle_pedido = DetallePedido::find($id);
        self::UpdateStock($detalle_pedido->id, 1);
        $detalle_pedido->delete();
        return $detalle_pedido;
    }

    static public function DeleteAllByPedido($id)
    {
        $detalle_pedido = DetallePedido::where('pedido_id', $id)->get();
        foreach ($detalle_pedido as $detalle) {
            self::UpdateStock($detalle->id, 1);
            $detalle->delete();
        }
        return $detalle_pedido;
    }

    static public function GetDetallePedidos($attribute, $order, $paginate)
    {
        $detalle_pedido = DetallePedido::orderBy($attribute, $order)->paginate($paginate);
        return $detalle_pedido;
    }

    static public function GetDetallePedido($id)
    {
        $detalle_compra = DetallePedido::find($id);
        return $detalle_compra;
    }
}
