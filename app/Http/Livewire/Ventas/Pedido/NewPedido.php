<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Models\Pedido;
use App\Models\Producto;
use Livewire\Component;

class NewPedido extends Component
{
    public $pedidoArray = [];
    public $productosArray = [];
    public $mostrarProductos = [];
    public $message = '';
    public $showMessage = false;

    public $pizzas = [];
    public $bebidas = [];
    public $postres = [];
    public $otros = [];

    public function mount()
    {
        $this->pizzas = Producto::GetProductosAll('Pizza')->toArray();
        $this->bebidas = Producto::GetProductosAll('Bebida')->toArray();
        $this->postres = Producto::GetProductosAll('Postre')->toArray();
        $this->otros = Producto::GetProductosAll('Otro')->toArray();

        $numeroSeguimiento = $this->getNumeroSeguimiento();
        $this->pedidoArray = [
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i'),
            'estado' => 'Pendiente',
            'monto_total' => 0.00,
            'metodo_pago' => '',
            'descripcion' => '',
            'cliente' => '',
            'codigo_seguimiento' => $numeroSeguimiento,
            'proveniente' => '',
            'detalles' => '',
            'productos' => [],
        ];
        $this->resetProductoArray();
    }

    public function getNumeroSeguimiento()
    {
        $ultimoPedido = Producto::GetLastNumeroSeguimiento();
        $numeroSeguimiento = ($ultimoPedido) ? $ultimoPedido->codigo_seguimiento + 1 : 1;
        return $numeroSeguimiento;
    }

    public function save()
    {
        $this->validate(Pedido::$validate, Pedido::$messages);
        $new = Pedido::CreatePedido($this->pedidoArray);
        if (!$new) {
            $this->message = 'Error al crear el pedido';
            $this->showMessage = true;
        }
        return redirect()->route('pedidos.show', $new->id);
    }


    public function addProductos()
    {
        $this->validate(Pedido::$validateProductos, Pedido::$messageProductos);
        $producto = Producto::GetProducto($this->productosArray['producto_id']);
        $this->productosArray['nombre'] = $producto->nombre;
        $this->productosArray['cantidad'] = $this->productosArray['cantidad'];
        $this->productosArray['precio'] = $producto->precio;
        $this->productosArray['monto_total'] += $this->productosArray['cantidad'] * $producto->precio;
        $this->pedidoArray['monto_total'] += $this->productosArray['monto_total'];
        array_push($this->pedidoArray['productos'], $this->productosArray);
        $this->resetProductoArray();
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
        ];
    }

    public function deleteProductos($producto_id, $monto_total)
    {
        $producto = Producto::GetProducto($producto_id);
        $this->pedidoArray['monto_total'] -= $monto_total;
        $this->pedidoArray['productos'] = array_filter($this->pedidoArray['productos'], function ($item) use ($producto_id) {
            return $item['producto_id'] != $producto_id;
        });
    }


    public function render()
    {
        $this->pedidoArray['codigo_seguimiento'] = $this->getNumeroSeguimiento();
        return view('livewire.ventas.pedido.new-pedido')->layout('layouts.venta');
    }
}
