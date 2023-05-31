<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'costo_total',
        'descripcion',
    ];

    // TODO VALIDATIONS
    static public $validate = [
        'recetaArray.nombre' => 'required|min:3|max:100',
        'recetaArray.descripcion' => 'min:3|max:255',
    ];
    static public $messages = [
        'recetaArray.nombre.required' => 'El nombre es requerido',
        'recetaArray.nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'recetaArray.nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'recetaArray.descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
        'recetaArray.descripcion.max' => 'La descripcion debe tener maximo 255 caracteres',
    ];

    // TODO RELATIONS
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'preparacions', 'receta_id', 'ingrediente_id')
            ->withPivot('cantidad', 'costo');
    }

    // TODO FUNCTIONS
    static public function CreateReceta(array $array)
    {
        $ingredientes = $array['ingredientes'];
        unset($array['ingredientes']);
        $new = new Receta($array);
        $new->save();
        foreach ($ingredientes as $ingrediente) {
            $new->ingredientes()->attach($ingrediente['ingrediente_id'], [
                'cantidad' => $ingrediente['cantidad'],
                'costo' => $ingrediente['cantidad'] * $ingrediente['precio_unidad']
            ]);
        }
        return $new;
    }

    static public function UpdateReceta($id, array $array)
    {
        $receta = Receta::find($id);
        $ingredientes = $array['ingredientes'];
        unset($array['ingredientes']);
        $receta->fill($array);
        $receta->save();
        foreach ($ingredientes as $ingrediente) {
            $receta->ingredientes()->syncWithoutDetaching([$ingrediente['ingrediente_id'] => [
                'cantidad' => $ingrediente['cantidad'],
                'costo' => $ingrediente['cantidad'] * $ingrediente['precio_unidad']
            ]]);
        }
        return $receta;
    }

    static public function DeleteReceta($id)
    {
        $receta = Receta::find($id);
        $receta->delete();
        return $receta;
    }

    static public function GetRecetas($attribute, $order, $paginate)
    {
        $recetas = Receta::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('descripcion', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', 'desc')
            ->paginate($paginate);
        return $recetas;
    }

    static public function GetReceta($id)
    {
        $receta = Receta::find($id);
        return $receta;
    }

    static public function GetRecetasAll()
    {
        $recetas = Receta::all();
        return $recetas;
    }
}
