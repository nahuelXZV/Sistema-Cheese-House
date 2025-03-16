<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // TODO RELATIONS
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'combo_productos', 'combo_id', 'producto_id')
            ->withPivot('cantidad');
    }

    // TODO VALIDATIONS
    static public $validate = [
        'comboArray.nombre' => 'required|min:3|max:100',
        'comboArray.descripcion' => 'min:3|max:255',
    ];
    static public $messages = [
        'comboArray.nombre.required' => 'El nombre es requerido',
        'comboArray.nombre.min' => 'El nombre debe tener al menos 3 caracteres',
        'comboArray.nombre.max' => 'El nombre debe tener maximo 100 caracteres',
        'comboArray.descripcion.min' => 'La descripcion debe tener al menos 3 caracteres',
        'comboArray.descripcion.max' => 'La descripcion debe tener maximo 255 caracteres',
    ];
}
