<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Models\Producto;
use App\Services\PedidoService;
use Livewire\Component;

class ShowPedido extends Component
{
    public $pedido;
    public $pedidoArray = [];
    public $productosArray = [];
    public $mostrarProductos = [];
    public $message = '';
    public $showMessage = false;

    public function mount($pedido)
    {
        $pedido = PedidoService::GetPedido($pedido);
        $this->pedidoArray = [
            'fecha' => $pedido->fecha,
            'hora' => $pedido->hora,
            'monto_total' => $pedido->monto_total,
            'metodo_pago' => $pedido->metodo_pago,
            'cliente' => $pedido->cliente,
            'codigo_seguimiento' => $pedido->codigo_seguimiento,
            'proveniente' => $pedido->proveniente,
            'detalles' => $pedido->detalles,
            'tipo_pedido' => $pedido->tipo_pedido,
            'descuento' => $pedido->descuento,
            'nombre_descuento' => $pedido->nombre_descuento,
            'productos' => [],
        ];
        $this->resetProductoArray();
        foreach ($pedido->detalle_pedidos as $detalle) {
            $this->productosArray['producto_id'] = $detalle->producto_id;
            $this->productosArray['cantidad'] = $detalle->cantidad;
            $this->productosArray['precio'] = $detalle->precio;
            $this->productosArray['monto_total'] = $detalle->monto_total;
            $this->productosArray['sub_total'] = $detalle->sub_total;
            $this->productosArray['descuento'] = $detalle->descuento;
            $producto = Producto::GetProducto($this->productosArray['producto_id']);
            $this->productosArray['nombre'] = $producto->nombre;
            array_push($this->pedidoArray['productos'], $this->productosArray);
            $this->resetProductoArray();
        }
        $this->pedido = $pedido;
    }

    private function resetProductoArray()
    {
        $this->productosArray = [
            "producto_id" => '',
            "cantidad" => '',
            'precio' => 0.00,
            'nombre' => '',
            "monto_total" => 0.00,
            "sub_total" => 0.00,
            "descuento" => 0.00,
        ];
    }

    public function render()
    {
        return view('livewire.ventas.pedido.show-pedido');
    }
}
