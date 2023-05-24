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
    static public $validate = [];
    static public $messages = [];


    // TODO RELATIONS
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'preparacions', 'receta_id', 'ingrediente_id')
            ->withPivot('cantidad', 'costo');
    }

    // TODO FUNCTIONS
    static public function CreateReceta(array $array)
    {
        $new = new Receta($array);
        $new->save();
        return $new;
    }

    static public function UpdateReceta($id, array $array)
    {
        $receta = Receta::find($id);
        $receta->fill($array);
        $receta->save();
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
}
