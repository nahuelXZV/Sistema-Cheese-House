<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'hora',
        'estado',
        'monto_total',
        'metodo_pago',
        'descripcion',
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
    ];
    static public $validateProductos = [];
    static public $messageProductos = [];


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
                'descripcion' => $producto['detalles'],
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
            ->orWhere('pedidos.fecha', 'LIKE', "%$attribute%")
            ->orWhere('pedidos.hora', 'LIKE', "%$attribute%")
            ->orWhere('pedidos.estado', 'LIKE', "%$attribute%")
            ->orWhere('pedidos.monto_total', 'LIKE', "%$attribute%")
            ->orWhere('pedidos.metodo_pago', 'LIKE', "%$attribute%")
            ->orWhere('pedidos.descripcion', 'LIKE', "%$attribute%")
            ->orWhere('pedidos.proveniente', 'LIKE', "%$attribute%")
            ->orWhere('users.name', 'LIKE', "%$attribute%")
            ->orderBy('nota_compras.id', 'DESC')
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
