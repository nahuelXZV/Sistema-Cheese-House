<?php

namespace App\Models;

use Carbon\Carbon;
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

    // TODO VALIDATIONS
    static public $validatePizzaPostre = [
        'productoArray.nombre' => 'required|min:3|max:100',
        'productoArray.descripcion' => 'min:3|max:255',
        'productoArray.precio' => 'required|numeric|min:0',
        'productoArray.tamaño' => 'required|min:3|max:100',
        'productoArray.is_active' => 'required',
        'productoArray.categoria' => 'required|min:3|max:100',
        'productoArray.receta_id' => 'required|numeric|min:1',
    ];
    static public $messagesPizzaPostre = [
        'productoArray.nombre.required' => 'El nombre es requerido',
        'productoArray.nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'productoArray.nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'productoArray.descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
        'productoArray.descripcion.max' => 'La descripcion debe tener maximo 255 caracteres',
        'productoArray.precio.required' => 'El precio es requerido',
        'productoArray.precio.numeric' => 'El precio debe ser numerico',
        'productoArray.precio.min' => 'El precio debe ser mayor a 0',
        'productoArray.tamaño.required' => 'El tamaño es requerido',
        'productoArray.tamaño.min' => 'El tamaño debe tener al menos 3 caracteres',
        'productoArray.tamaño.max' => 'El tamaño debe tener maximo 100 caracteres',
        'productoArray.is_active.required' => 'El estado es requerido',
        'productoArray.categoria.required' => 'La categoria es requerida',
        'productoArray.categoria.min' => 'La categoria debe tener al menos 3 caracteres',
        'productoArray.categoria.max' => 'La categoria debe tener maximo 100 caracteres',
        'productoArray.receta_id.required' => 'La receta es requerida',
        'productoArray.receta_id.numeric' => 'La receta debe ser numerica',
        'productoArray.receta_id.min' => 'La receta debe ser mayor a 0',
    ];

    static public $validateBebidaOtro = [
        'productoArray.nombre' => 'required|min:3|max:100',
        'productoArray.descripcion' => 'min:3|max:255',
        'productoArray.precio' => 'required|numeric|min:0',
        'productoArray.tamaño' => 'required|min:3|max:100',
        'productoArray.is_active' => 'required',
        'productoArray.categoria' => 'required|min:3|max:100',
        'productoArray.tipo_botella' => 'min:3|max:100',
        'productoArray.stock' => 'required|numeric|min:0',
        'productoArray.stock_minimo' => 'required|numeric|min:0',
        'productoArray.stock_maximo' => 'numeric|min:0',
    ];
    static public $messagesBebidaOtro = [
        'productoArray.nombre.required' => 'El nombre es requerido',
        'productoArray.nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'productoArray.nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'productoArray.descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
        'productoArray.descripcion.max' => 'La descripcion debe tener maximo 255 caracteres',
        'productoArray.precio.required' => 'El precio es requerido',
        'productoArray.precio.numeric' => 'El precio debe ser numerico',
        'productoArray.precio.min' => 'El precio debe ser mayor a 0',
        'productoArray.tamaño.required' => 'El tamaño es requerido',
        'productoArray.tamaño.min' => 'El tamaño debe tener al menos 3 caracteres',
        'productoArray.tamaño.max' => 'El tamaño debe tener maximo 100 caracteres',
        'productoArray.is_active.required' => 'El estado es requerido',
        'productoArray.categoria.required' => 'La categoria es requerida',
        'productoArray.categoria.min' => 'La categoria debe tener al menos 3 caracteres',
        'productoArray.categoria.max' => 'La categoria debe tener maximo 100 caracteres',
        'productoArray.tipo_botella.min' => 'El tipo de botella debe tener al menos 3 caracteres',
        'productoArray.tipo_botella.max' => 'El tipo de botella debe tener maximo 100 caracteres',
        'productoArray.stock.required' => 'El stock es requerido',
        'productoArray.stock.numeric' => 'El stock debe ser numerico',
        'productoArray.stock.min' => 'El stock debe ser mayor a 0',
        'productoArray.stock_minimo.required' => 'El stock minimo es requerido',
        'productoArray.stock_minimo.numeric' => 'El stock minimo debe ser numerico',
        'productoArray.stock_minimo.min' => 'El stock minimo debe ser mayor a 0',
        'productoArray.stock_maximo.required' => 'El stock maximo es requerido',
        'productoArray.stock_maximo.numeric' => 'El stock maximo debe ser numerico',
        'productoArray.stock_maximo.min' => 'El stock maximo debe ser mayor a 0',
    ];

    // TODO RELATIONS
    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    // TODO FUNCTIONS


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
            ->orWhere('precio', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', 'desc')
            ->paginate($paginate);
        return $productos;
    }

    static public function GetProducto($id)
    {
        $producto = Producto::find($id);
        return $producto;
    }

    static public function GetProductosAll($categoria = null)
    {
        $productos = [];
        if ($categoria)
            $productos = Producto::where('categoria', $categoria)->where('is_active', true)->orderBy('nombre', 'asc')->get();
        else
            $productos = Producto::where('is_active', true)->orderBy('nombre', 'asc')->get();
        return $productos;
    }

    static public function UpdateStock($id, $stock)
    {
        $producto = Producto::find($id);
        $producto->stock = $producto->stock + $stock;
        $producto->save();
        return $producto;
    }

    static public function GetLastNumeroSeguimiento()
    {
        $fechaActual = Carbon::now();
        return Pedido::whereDate('created_at', $fechaActual)->latest()->first();
    }
}
