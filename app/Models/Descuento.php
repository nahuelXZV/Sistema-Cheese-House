<?php

namespace App\Models;

use App\Constants\EstadoDescuento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // TODO VALIDATIONS
    static public $validate = [
        'descuentoArray.nombre' => 'required|min:3|max:100',
        'descuentoArray.porcentaje' => 'required|numeric|min:1|max:100',
    ];
    static public $messages = [
        'descuentoArray.nombre.required' => 'El nombre es requerido',
        'descuentoArray.nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'descuentoArray.nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'descuentoArray.porcentaje.required' => 'El porcentaje es requerido',
        'descuentoArray.porcentaje.numeric' => 'El porcentaje debe ser un número',
        'descuentoArray.porcentaje.min' => 'El porcentaje debe ser mayor a 0',
        'descuentoArray.porcentaje.max' => 'El porcentaje debe ser menor a 100',
    ];

    // TODO FUNCTIONS
    static public function CreateDescuento(array $array)
    {
        $new = new Descuento([
            'nombre' => $array['nombre'],
            'porcentaje' => $array['porcentaje'],
            'estado' => $array['estado'] ? true : false,
        ]);
        $new->save();
        return $new;
    }

    static public function UpdateDescuento($id, array $array)
    {
        $descuento = Descuento::find($id);
        $descuento->fill(
            [
                'nombre' => $array['nombre'],
                'porcentaje' => $array['porcentaje'],
                'estado' => $array['estado'] ? true : false,
            ]
        );
        $descuento->save();
        return $descuento;
    }

    static public function DeleteDescuento($id)
    {
        $receta = Descuento::find($id);
        $receta->delete();
        return $receta;
    }

    static public function GetDescuentos($attribute, $order, $paginate)
    {
        $recetas = Descuento::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('nombre', 'desc')
            ->paginate($paginate);
        return $recetas;
    }

    static public function GetDescuento($id)
    {
        $receta = Descuento::find($id);
        return $receta;
    }

    static public function GetDescuentosAll()
    {
        $recetas = Descuento::where('estado', true)->get();
        return $recetas;
    }
}
