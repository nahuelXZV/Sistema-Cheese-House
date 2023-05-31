<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_empresa',
        'nombre_encargado',
        'telefono',
        'direccion',
        'correo',
        'descripcion'
    ];

    // TODO VALIDATIONS
    static public $validate = [
        'proveedorArray.nombre_empresa' => 'required|string',
        'proveedorArray.nombre_encargado' => 'required|string',
        'proveedorArray.telefono' => 'required|string',
        'proveedorArray.direccion' => 'string',
        'proveedorArray.correo' => 'email',
        'proveedorArray.descripcion' => 'string',
    ];
    static public $messages = [
        'proveedorArray.nombre_empresa.required' => 'El nombre de la empresa es requerido',
        'proveedorArray.nombre_empresa.string' => 'El nombre de la empresa debe ser un texto',
        'proveedorArray.nombre_encargado.required' => 'El nombre del encargado es requerido',
        'proveedorArray.nombre_encargado.string' => 'El nombre del encargado debe ser un texto',
        'proveedorArray.telefono.required' => 'El telefono es requerido',
        'proveedorArray.telefono.string' => 'El telefono debe ser un texto',
        'proveedorArray.direccion.required' => 'La direccion es requerida',
        'proveedorArray.direccion.string' => 'La direccion debe ser un texto',
        'proveedorArray.correo.required' => 'El correo es requerido',
        'proveedorArray.correo.email' => 'El correo debe ser un correo valido',
        'proveedorArray.descripcion.string' => 'La descripcion debe ser un texto',
    ];

    // TODO RELATIONS
    public function compras()
    {
        return $this->hasMany(NotaCompra::class);
    }


    // TODO FUNCTIONS
    static public function CreateProveedor(array $array)
    {
        $new = new Proveedor($array);
        $new->save();
        return $new;
    }

    static public function UpdateProveedor($id, array $array)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->fill($array);
        $proveedor->save();
        return $proveedor;
    }

    static public function DeleteProveedor($id)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->delete();
        return $proveedor;
    }

    static public function GetProveedors($attribute, $order, $paginate)
    {
        $proveedor = Proveedor::where('nombre_empresa', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('nombre_encargado', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('telefono', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('direccion', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('correo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', 'desc')
            ->paginate($paginate);
        return $proveedor;
    }

    static public function GetProveedor($id)
    {
        $proveedor = Proveedor::find($id);
        return $proveedor;
    }

    static public function GetProveedorsAll()
    {
        $proveedor = Proveedor::all();
        return $proveedor;
    }
}
