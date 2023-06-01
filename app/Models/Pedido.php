<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = [
        'cliente',
        'codigo_seguimiento',
        'fecha',
        'hora',
        'estado',
        'monto_total',
        'metodo_pago',
        'detalles',
        'proveniente',
        'user_id',
    ];

    // TODO VALIDATIONS
    static public $validate = [
        'pedidoArray.fecha' => 'required|date',
        'pedidoArray.hora' => 'required|date_format:H:i',
        'pedidoArray.estado' => 'required',
        'pedidoArray.monto_total' => 'required|numeric|min:0',
        'pedidoArray.metodo_pago' => 'required',
        'pedidoArray.proveniente' => 'required',
        'pedidoArray.cliente' => 'required',
        'pedidoArray.codigo_seguimiento' => 'required'
    ];
    static public $messages = [
        'pedidoArray.fecha.required' => 'El campo fecha es requerido',
        'pedidoArray.fecha.date' => 'El campo fecha debe ser una fecha',
        'pedidoArray.hora.required' => 'El campo hora es requerido',
        'pedidoArray.hora.date_format' => 'El campo hora debe ser una hora',
        'pedidoArray.estado.required' => 'El campo estado es requerido',
        'pedidoArray.monto_total.required' => 'El campo monto total es requerido',
        'pedidoArray.monto_total.numeric' => 'El campo monto total debe ser un numero',
        'pedidoArray.monto_total.min' => 'El campo monto total debe ser mayor a 0',
        'pedidoArray.metodo_pago.required' => 'El campo metodo de pago es requerido',
        'pedidoArray.proveniente.required' => 'El campo proveniente es requerido',
        'pedidoArray.cliente.required' => 'El campo cliente es requerido',
        'pedidoArray.codigo_seguimiento.required' => 'El campo codigo de seguimiento es requerido'
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
    static public function CreatePedido(array $array)
    {
        $productos = $array['productos'];
        unset($array['productos']);
        $array['user_id'] = auth()->user()->id;
        $new = new Pedido($array);
        $new->save();

        foreach ($productos as $producto) {
            $detallePedido = [
                'pedido_id' => $new->id,
                'producto_id' => intval($producto['producto_id']),
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'monto_total' => $producto['monto_total'],
                'mitad_uno' => intval($producto['mitad_uno']) == 0 ? null : intval($producto['mitad_uno']),
                'mitad_dos' => intval($producto['mitad_dos']) == 0 ? null : intval($producto['mitad_dos']),
            ];
            DetallePedido::CreateDetallePedido($detallePedido);
        }
        return $new;
    }

    static public function UpdatePedido($id, array $array)
    {
        $pedido = Pedido::find($id);

        $productos = $array['productos'];
        unset($array['productos']);

        $pedido->fill($array);
        $pedido->save();

        DetallePedido::DeleteAllByPedido($pedido->id);
        foreach ($productos as $producto) {
            $detallePedido = [
                'pedido_id' => $pedido->id,
                'producto_id' => intval($producto['producto_id']),
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'monto_total' => $producto['monto_total'],
                'descripcion' => $producto['detalles'],
                'mitad_uno' => intval($producto['mitad_uno']) == 0 ? null : intval($producto['mitad_uno']),
                'mitad_dos' => intval($producto['mitad_dos']) == 0 ? null : intval($producto['mitad_dos']),
            ];
            DetalleCompra::CreateDetalleCompra($detallePedido);
        }
        return $pedido;
    }

    static public function DeletePedido($id)
    {
        $pedido = Pedido::find($id);
        foreach ($pedido->detalle_pedidos as $detalle) {
            DetallePedido::DeleteDetallePedido($detalle->id);
        }
        $pedido->delete();
        return $pedido;
    }

    static public function GetPedidos($attribute, $order, $paginate)
    {
        $pedidos = Pedido::join('users', 'users.id', '=', 'pedidos.user_id')
            ->select('pedidos.*', 'users.name as user_name')
            ->orWhere('pedidos.fecha', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.hora', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.estado', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.monto_total', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.metodo_pago', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.detalles', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('pedidos.proveniente', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('users.name', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('pedidos.id', 'DESC')
            ->paginate($paginate);
        return $pedidos;
    }

    static public function GetPedido($id)
    {
        $pedido = Pedido::find($id);
        return $pedido;
    }

    static public function GetPedidoAll()
    {
        $pedidos = Pedido::all();
        return $pedidos;
    }
}
