<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'unidad',
        'stock',
        'precio_unidad',
        'stock_minimo',
        'stock_maximo',
        'descripcion',
    ];

    // TODO VALIDATIONS
    static public $validate = [
        'ingredienteArray.nombre' => 'required|string|max:150',
        'ingredienteArray.unidad' => 'required|string|max:20',
        'ingredienteArray.stock' => 'required|numeric|min:0',
        'ingredienteArray.precio_unidad' => 'required|numeric|min:0',
        'ingredienteArray.stock_minimo' => 'required|numeric|min:0',
        'ingredienteArray.stock_maximo' => 'required|numeric|min:0',
        'ingredienteArray.descripcion' => 'required|string|max:255'
    ];
    static public $messages = [
        'ingredienteArray.nombre.required' => 'El nombre es requerido',
        'ingredienteArray.nombre.string' => 'El nombre debe ser una cadena de caracteres',
        'ingredienteArray.nombre.max' => 'El nombre debe tener máximo 150 caracteres',
        'ingredienteArray.unidad.required' => 'La unidad es requerida',
        'ingredienteArray.unidad.string' => 'La unidad debe ser una cadena de caracteres',
        'ingredienteArray.unidad.max' => 'La unidad debe tener máximo 20 caracteres',
        'ingredienteArray.stock.required' => 'El stock es requerido',
        'ingredienteArray.stock.numeric' => 'El stock debe ser un número',
        'ingredienteArray.stock.min' => 'El stock debe ser mínimo 0',
        'ingredienteArray.precio_unidad.required' => 'El precio por unidad es requerido',
        'ingredienteArray.precio_unidad.numeric' => 'El precio por unidad debe ser un número',
        'ingredienteArray.precio_unidad.min' => 'El precio por unidad debe ser mínimo 0',
        'ingredienteArray.stock_minimo.required' => 'El stock mínimo es requerido',
        'ingredienteArray.stock_minimo.numeric' => 'El stock mínimo debe ser un número',
        'ingredienteArray.stock_minimo.min' => 'El stock mínimo debe ser mínimo 0',
        'ingredienteArray.stock_maximo.required' => 'El stock máximo es requerido',
        'ingredienteArray.stock_maximo.numeric' => 'El stock máximo debe ser un número',
        'ingredienteArray.stock_maximo.min' => 'El stock máximo debe ser mínimo 0',
        'ingredienteArray.descripcion.required' => 'La descripción es requerida',
        'ingredienteArray.descripcion.string' => 'La descripción debe ser una cadena de caracteres',
        'ingredienteArray.descripcion.max' => 'La descripción debe tener máximo 255 caracteres',
    ];
    // TODO RELATIONS
    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'preparacions', 'ingrediente_id', 'receta_id')
            ->withPivot('cantidad', 'costo');
    }


    // TODO FUNCTIONS
    static public function CreateIngrediente(array $array)
    {
        $new = new Ingrediente($array);
        $new->save();
        return $new;
    }

    static public function UpdateIngrediente($id, array $array)
    {
        $ingrediente = Ingrediente::find($id);
        $ingrediente->fill($array);
        $ingrediente->save();
        return $ingrediente;
    }

    static public function DeleteIngrediente($id)
    {
        $ingrediente = Ingrediente::find($id);
        $ingrediente->delete();
        return $ingrediente;
    }

    static public function GetIngredientes($attribute, $order, $paginate)
    {
        $ingredientes = Ingrediente::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('unidad', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('descripcion', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', 'desc')
            ->paginate($paginate);
        return $ingredientes;
    }

    static public function GetIngredientesAll()
    {
        $ingredientes = Ingrediente::all();
        return $ingredientes;
    }

    static public function GetIngrediente($id)
    {
        $ingrediente = Ingrediente::find($id);
        return $ingrediente;
    }

    static public function UpdateStock($id, $stock)
    {
        $ingrediente = Ingrediente::find($id);
        $ingrediente->stock = $ingrediente->stock + $stock;
        $ingrediente->save();
        return $ingrediente;
    }
}
