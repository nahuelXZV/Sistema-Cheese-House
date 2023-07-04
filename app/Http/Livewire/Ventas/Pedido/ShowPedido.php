<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Models\Pedido;
use App\Models\Producto;
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
        $pedido = Pedido::GetPedido($pedido);
        $this->pedidoArray = [
            'fecha' => $pedido->fecha,
            'hora' => $pedido->hora,
            'monto_total' => $pedido->monto_total,
            'metodo_pago' => $pedido->metodo_pago,
            'cliente' => $pedido->cliente,
            'codigo_seguimiento' => $pedido->codigo_seguimiento,
            'proveniente' => $pedido->proveniente,
            'detalles' => $pedido->detalles,
            'productos' => [],
        ];
        $this->resetProductoArray();
        foreach ($pedido->detalle_pedidos as $detalle) {
            $this->productosArray['producto_id'] = $detalle->producto_id;
            $this->productosArray['cantidad'] = $detalle->cantidad;
            $this->productosArray['precio'] = $detalle->precio;
            $this->productosArray['monto_total'] = $detalle->monto_total;
            if ($detalle->mitad_uno && $detalle->mitad_dos) {
                $this->productosArray['mitad_uno'] = $detalle->mitad_uno;
                $this->productosArray['mitad_dos'] = $detalle->mitad_dos;
                $this->productosArray['nombre_uno'] = Producto::GetProducto($detalle->mitad_uno)->nombre;
                $this->productosArray['nombre_dos'] = Producto::GetProducto($detalle->mitad_dos)->nombre;
            }
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
            'mitad_uno' => '',
            'mitad_dos' => '',
            'nombre_uno' => '',
            'nombre_dos' => '',
        ];
    }

    public function render()
    {
        return view('livewire.ventas.pedido.show-pedido');
    }
}
