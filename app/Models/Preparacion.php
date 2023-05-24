<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preparacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'receta_id',
        'preparacion_id',
        'cantidad',
        'costo'
    ];

    // TODO VALIDATIONS
    static public $validate = [];
    static public $messages = [];

    // TODO RELATIONS
    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function ingredientes()
    {
        return $this->belongsTo(Ingrediente::class);
    }


    // TODO FUNCTIONS
    static public function CreatePreparacion(array $array)
    {
        $new = new Preparacion($array);
        $new->save();
        return $new;
    }

    static public function UpdatePreparacion($id, array $array)
    {
        $preparacion = Preparacion::find($id);
        $preparacion->fill($array);
        $preparacion->save();
        return $preparacion;
    }

    static public function DeletePreparacion($id)
    {
        $preparacion = Preparacion::find($id);
        $preparacion->delete();
        return $preparacion;
    }

    static public function GetPreparacion()
    {
        $preparacions = Preparacion::all();
        return $preparacions;
    }

    static public function GetPreparacionAll($id)
    {
        $preparacion = Preparacion::find($id);
        return $preparacion;
    }
}
