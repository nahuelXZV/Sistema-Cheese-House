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
    static public function CreateDetalleCompra(array $array)
    {
        $new = new DetalleCompra($array);
        $new->save();
        return $new;
    }

    static public function UpdateDetalleCompra($id, array $array)
    {
        $detalle_compra = DetalleCompra::find($id);
        $detalle_compra->fill($array);
        $detalle_compra->save();
        return $detalle_compra;
    }

    static public function DeleteDetalleCompra($id)
    {
        $detalle_compra = DetalleCompra::find($id);
        $detalle_compra->delete();
        return $detalle_compra;
    }

    static public function DeleteAllByNotaCompra($id)
    {
        $detalle_compras = DetalleCompra::where('nota_compra_id', $id)->get();
        foreach ($detalle_compras as $detalle_compra) {
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
