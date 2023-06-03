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
            'monto_total' => 0,
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
            if ($detalle->mitad_uno && $detalle->mitad_dos) {
                $this->productosArray['mitad_uno'] = $detalle->mitad_uno;
                $this->productosArray['mitad_dos'] = $detalle->mitad_dos;
                $this->productosArray['nombre_uno'] = Producto::GetProducto($detalle->mitad_uno)->nombre;
                $this->productosArray['nombre_dos'] = Producto::GetProducto($detalle->mitad_dos)->nombre;
            }
            $this->addProductos();
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

    public function addProductos()
    {
        $this->validate(Pedido::$validateProductos, Pedido::$messageProductos);
        $producto = Producto::GetProducto($this->productosArray['producto_id']);
        $this->productosArray['nombre'] = $producto->nombre;
        $this->productosArray['cantidad'] = $this->productosArray['cantidad'];
        if ($this->productosArray['mitad_uno'] != '' && $this->productosArray['mitad_dos'] != '') {
            $mitad_uno = Producto::GetProducto($this->productosArray['mitad_uno']);
            $mitad_dos = Producto::GetProducto($this->productosArray['mitad_dos']);
            $this->productosArray['precio'] = $mitad_uno->precio / 2 + $mitad_dos->precio / 2;
            $this->productosArray['nombre_uno'] = Producto::GetProducto($this->productosArray['mitad_uno'])->nombre;
            $this->productosArray['nombre_dos'] = Producto::GetProducto($this->productosArray['mitad_dos'])->nombre;
        } else {
            $this->productosArray['precio'] = $producto->precio;
        }
        $this->productosArray['monto_total'] += $this->productosArray['cantidad'] * $this->productosArray['precio'];
        $this->pedidoArray['monto_total'] += $this->productosArray['monto_total'];
        array_push($this->pedidoArray['productos'], $this->productosArray);
        $this->resetProductoArray();
    }

    public function render()
    {
        return view('livewire.ventas.pedido.show-pedido');
    }
}
