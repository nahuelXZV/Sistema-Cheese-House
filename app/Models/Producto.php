<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'tamaño',
        'url_imagen',
        'is_active',
        'categoria',
        'tipo_botella',
        'stock',
        'stock_minimo',
        'stock_maximo',
        'receta_id',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    static public function CreateProducto(array $array)
    {
        $new = new Producto($array);
        $new->save();
        return $new;
    }

    static public function UpdateProducto($id, array $array)
    {
        $producto = Producto::find($id);
        $producto->fill($array);
        $producto->save();
        return $producto;
    }

    static public function DeleteProducto($id)
    {
        $producto = Producto::find($id);
        $producto->delete();
        return $producto;
    }

    static public function GetProductos($attribute, $order, $paginate)
    {
        $productos = Producto::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('categoria', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('descripcion', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', 'desc')
            ->paginate($paginate);
        return $productos;
    }

    static public function GetProducto($id)
    {
        $producto = Producto::find($id);
        return $producto;
    }
}
