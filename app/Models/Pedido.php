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
    static public $validate = [];
    static public $messages = [];



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
    static public function CreateNotaCompra(array $array)
    {
        $productos = $array['productos'];
        unset($array['productos']);
        $array['user_id'] = auth()->user()->id;
        $new = new Pedido($array);
        $new->save();

        foreach ($productos as $producto) {
            $detalleCompra = [
                'pedido_id' => $new->id,
                'producto_id' => intval($producto['producto_id']),
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'monto_total' => $producto['monto_total'],
                'descripcion' => $producto['detalles'],
                'mitad_uno' => intval($producto['mitad_uno']) == 0 ? null : intval($producto['mitad_uno']),
                'mitad_dos' => intval($producto['mitad_dos']) == 0 ? null : intval($producto['mitad_dos']),
            ];
            // DetallePedido::CreateDetalleCompra($detalleCompra);
        }
        return $new;
    }

    static public function UpdateNotaCompra($id, array $array)
    {
        $notaCompra = NotaCompra::find($id);

        $productos = $array['productos'];
        unset($array['productos']);

        $notaCompra->fill($array);
        $notaCompra->save();

        DetalleCompra::DeleteAllByNotaCompra($notaCompra->id);
        foreach ($productos as $producto) {
            $detalleCompra = [
                'pedido_id' => $notaCompra->id,
                'producto_id' => intval($producto['producto_id']),
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'monto_total' => $producto['monto_total'],
                'descripcion' => $producto['detalles'],
                'mitad_uno' => intval($producto['mitad_uno']) == 0 ? null : intval($producto['mitad_uno']),
                'mitad_dos' => intval($producto['mitad_dos']) == 0 ? null : intval($producto['mitad_dos']),
            ];
            // DetalleCompra::CreateDetalleCompra($detalleCompra);
        }
        return $notaCompra;
    }

    static public function DeleteNotaCompra($id)
    {
        $notaCompra = Pedido::find($id);
        // foreach ($notaCompra->detalle_compras as $detalleCompra) {
        //     DetalleCompra::DeleteDetalleCompra($detalleCompra->id);
        // }
        $notaCompra->delete();
        return $notaCompra;
    }

    static public function GetNotaCompras($attribute, $order, $paginate)
    {
        $pedidos = Pedido::join('users', 'users.id', '=', 'pedidos.user_id')
            ->select('pedidos.*', 'users.name as user_name')
            ->orWhere('pedidos.id', 'LIKE', "%$attribute%")
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

    static public function GetNotaCompra($id)
    {
        $pedido = Pedido::find($id);
        return $pedido;
    }

    static public function GetNotaComprasAll()
    {
        $pedidos = Pedido::all();
        return $pedidos;
    }
}
