<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // TODO VALIDATIONS
    static public $validate = [
        'pedidoArray.fecha' => 'required|date',
        'pedidoArray.hora' => 'required|date_format:H:i',
        'pedidoArray.monto_total' => 'required|numeric|min:0',
        'pedidoArray.metodo_pago' => 'required',
        'pedidoArray.proveniente' => 'required',
        'pedidoArray.tipo_pedido' => 'required',
        'pedidoArray.cliente' => 'required',
    ];
    static public $messages = [
        'pedidoArray.fecha.required' => 'Campo requerido',
        'pedidoArray.fecha.date' => 'El campo fecha debe ser una fecha',
        'pedidoArray.hora.required' => 'Campo requerido',
        'pedidoArray.hora.date_format' => 'El campo hora debe ser una hora',
        'pedidoArray.estado.required' => 'Campo requerido',
        'pedidoArray.monto_total.required' => 'Campo requerido',
        'pedidoArray.monto_total.numeric' => 'El campo monto total debe ser un numero',
        'pedidoArray.monto_total.min' => 'El campo monto total debe ser mayor a 0',
        'pedidoArray.metodo_pago.required' => 'Campo requerido',
        'pedidoArray.proveniente.required' => 'Campo requerido',
        'pedidoArray.cliente.required' => 'Campo requerido',
        'pedidoArray.codigo_seguimiento.required' => 'El campo codigo de seguimiento es requerido',
        'pedidoArray.tipo_pedido.required' => 'Campo requerido',
    ];

    static public $validateProductos = [
        'productosArray.producto_id' => 'required',
        'productosArray.cantidad' => 'required|numeric|min:1',
    ];
    static public $messageProductos = [
        'productosArray.producto_id.required' => 'El campo producto es requerido',
        'productosArray.cantidad.required' => 'Requerido',
        'productosArray.cantidad.numeric' => 'Debe ser un numero',
        'productosArray.cantidad.min' => 'Debe ser mayor a 0',
    ];

    // TODO RELATIONS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalle_pedidos()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }

    // TODO FUNCTIONS

}
