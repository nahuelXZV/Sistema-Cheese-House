<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $fillable = [
        'cantidad',
        'precio_unidad',
        'detalles',
        'monto_total',
        'nota_compra_id',
        'producto_id',
        'ingrediente_id',
    ];

    // TODO VALIDATIONS
    static public $validate = [];
    static public $messages = [];

    // TODO RELATIONS
    public function nota_compra()
    {
        return $this->belongsTo(NotaCompra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }

    // TODO FUNCTIONS
    static private function UpdateStockProductos($ingrediente_id, $producto_id, $cantidad, $precio_unidad)
    {
        if ($ingrediente_id != null)
            Ingrediente::UpdateStock($ingrediente_id, $cantidad, $precio_unidad);
        if ($producto_id != null)
            Producto::UpdateStock($producto_id, $cantidad, $precio_unidad);
    }

    static public function CreateDetalleCompra(array $array)
    {
        $new = new DetalleCompra($array);
        $new->save();
        self::UpdateStockProductos($array['ingrediente_id'], $array['producto_id'], $array['cantidad'], $array['precio_unidad']);
        return $new;
    }

    static public function UpdateDetalleCompra($id, array $array)
    {
        $detalle_compra = DetalleCompra::find($id);
        $detalle_compra->fill($array);
        $detalle_compra->save();
        self::UpdateStockProductos($array['ingrediente_id'], $array['producto_id'], $array['cantidad'], $array['precio_unidad']);
        return $detalle_compra;
    }

    static public function DeleteDetalleCompra($id)
    {
        $detalle_compra = DetalleCompra::find($id);
        $detalle_compra->delete();
        self::UpdateStockProductos($detalle_compra->ingrediente_id, $detalle_compra->producto_id, -$detalle_compra->cantidad, $detalle_compra->precio_unidad);
        return $detalle_compra;
    }

    static public function DeleteAllByNotaCompra($id)
    {
        $detalle_compras = DetalleCompra::where('nota_compra_id', $id)->get();
        foreach ($detalle_compras as $detalle_compra) {
            self::UpdateStockProductos($detalle_compra->ingrediente_id, $detalle_compra->producto_id, -$detalle_compra->cantidad, $detalle_compra->precio_unidad);
            $detalle_compra->delete();
        }
        return $detalle_compras;
    }

    static public function GetDetalleCompras($attribute, $order, $paginate)
    {
        $detalle_compras = DetalleCompra::orderBy($attribute, $order)->paginate($paginate);
        return $detalle_compras;
    }

    static public function GetDetalleCompra($id)
    {
        $detalle_compra = DetalleCompra::find($id);
        return $detalle_compra;
    }
}
