<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Constants\CategoriasProductos;
use App\Constants\MetodoPagos;
use App\Constants\ProvenienciaVenta;
use App\Constants\TipoVenta;
use App\Models\Descuento;
use App\Models\Pedido;
use App\Models\Producto;
use App\Services\PedidoService;
use Livewire\Component;

class EditPedido extends Component
{
    public $pedido;
    public $pedidoArray = [];
    public $productosArray = [];
    public $mostrarProductos = [];
    public $message = '';
    public $showMessage = false;
    public $pedido_id;
    public $filter;

    public $metodoPagos = [];
    public $proveniencias = [];
    public $tipos = [];
    public $descuentos = [];
    public $categoriasDescuentos = [];
    public $productoCheck;
    public $descuentoCheck;
    public $descuentoAplicado;
    public $montoDescuento = 0.00;

    public function mount($pedido)
    {
        $this->filter = CategoriasProductos::PIZZA;
        $pedido = PedidoService::GetPedido($pedido);
        $this->pedidoArray = [
            'fecha' => $pedido->fecha,
            'hora' => $pedido->hora,
            'monto_total' => $pedido->monto_total,
            'metodo_pago' => $pedido->metodo_pago,
            'cliente' => $pedido->cliente,
            'codigo_seguimiento' => $pedido->codigo_seguimiento,
            'proveniente' => $pedido->proveniente,
            'tipo_pedido' => $pedido->tipo_pedido,
            'descuento' => $pedido->descuento,
            'nombre_descuento' => $pedido->nombre_descuento,
            'detalles' => $pedido->detalles,
            'descuento_id' => $pedido->descuento_id,
            'productos' => [],
        ];
        $this->pedido = $pedido;
        $this->descuentoCheck = $pedido->descuento_id;
        $this->resetProductoArray();
        $monto_temporal = 0;
        foreach ($pedido->detalle_pedidos as $detalle) {
            $this->productosArray['key'] = $detalle->id . now()->timestamp;
            $this->productosArray['producto_id'] = $detalle->producto_id;
            $this->productosArray['cantidad'] = $detalle->cantidad;
            $this->productosArray['precio'] = $detalle->precio;
            $this->productosArray['monto_total'] = $detalle->monto_total;
            $this->productosArray['subTotal'] = $detalle->sub_total;
            $this->productosArray['descuento'] = $detalle->descuento;
            $producto = Producto::GetProducto($this->productosArray['producto_id']);
            $this->productosArray['categoria'] = $producto->categoria;
            $this->productosArray['nombre'] = $producto->nombre;
            $monto_temporal += $this->productosArray['monto_total'];
            array_push($this->pedidoArray['productos'], $this->productosArray);
            $this->resetProductoArray();
        }
        if ($monto_temporal != $this->pedidoArray['monto_total']) {
            $this->pedidoArray['monto_total'] = $monto_temporal;
        }
        $this->metodoPagos = MetodoPagos::getMetodoPagos();
        $this->proveniencias = ProvenienciaVenta::getProveniencias();
        $this->tipos = TipoVenta::getTipoVentas();
        $this->descuentos = Descuento::GetDescuentosAll();
        $this->categoriasDescuentos = [CategoriasProductos::PIZZA, CategoriasProductos::POSTRE, CategoriasProductos::MITAD];
    }

    public function save()
    {
        $this->validate(Pedido::$validate, Pedido::$messages);
        $descuento = Descuento::getDescuento($this->descuentoCheck);
        $this->pedidoArray['descuento'] = $descuento->porcentaje;
        $this->pedidoArray['nombre_descuento'] = $descuento->nombre;
        $new = PedidoService::UpdatePedido($this->pedido->id, $this->pedidoArray);
        if (!$new) {
            $this->message = 'Error al actualizar el pedido';
            $this->showMessage = true;
        }
        return redirect()->route('pedidos.show', $new->id);
    }


    // NICE
    public function add()
    {
        $producto = Producto::GetProducto($this->productoCheck);
        $this->productosArray['producto_id'] = $producto->id;
        $this->productosArray['categoria'] = $producto->categoria;
        $this->productosArray['cantidad'] = 1;
        $this->productosArray['nombre'] = $producto->nombre;
        $this->productosArray['key'] = $producto->id . now()->timestamp;
        $this->productosArray['precio'] = $producto->precio;
        $this->productosArray['subTotal'] += $this->productosArray['cantidad'] * $this->productosArray['precio'];
        $this->productosArray['monto_total'] += $this->productosArray['cantidad'] * $this->productosArray['precio'];
        $this->pedidoArray['monto_total'] += $this->productosArray['monto_total'];
        array_push($this->pedidoArray['productos'], $this->productosArray);
        $this->resetProductoArray();
    }
    private function resetProductoArray()
    {
        $this->productosArray = [
            "key" => '',
            "producto_id" => '',
            "categoria" => '',
            "cantidad" => '1',
            'precio' => 0.00,
            'nombre' => '',
            "subTotal" => 0.00,
            "monto_total" => 0.00,
            "descuento" => 0.00,
        ];
    }
    // NICE
    public function deleteProductos($key)
    {
        $this->pedidoArray['productos'] = array_filter($this->pedidoArray['productos'], function ($item) use ($key) {
            if ($item['key'] == $key) $this->pedidoArray['monto_total'] -= $item['monto_total'];
            return $item['key'] != $key;
        });
    }

    // NICE
    public function checkProducto($producto_id)
    {
        $this->productoCheck = $producto_id;
        $this->resetProductoArray();
    }

    // NICE
    public function increment($key)
    {
        $this->pedidoArray['productos'] = array_map(function ($item) use ($key) {
            if ($item['key'] != $key) return $item;
            $item['cantidad'] += 1;
            $item['subTotal'] = floatval($item['cantidad']) * floatval($item['precio']);
            $item['monto_total'] = floatval($item['cantidad']) * floatval($item['precio']);
            return $item;
        }, $this->pedidoArray['productos']);
        $this->pedidoArray['monto_total'] = array_sum(array_column($this->pedidoArray['productos'], 'monto_total'));
    }

    // NICE
    public function decrement($key)
    {
        $this->pedidoArray['productos'] = array_map(function ($item) use ($key) {
            if ($item['key'] != $key) return $item;
            $item['cantidad'] -= 1;
            $item['subTotal'] = floatval($item['cantidad']) * floatval($item['precio']);
            $item['monto_total'] = floatval($item['cantidad']) * floatval($item['precio']);
            return $item;
        }, $this->pedidoArray['productos']);
        $this->pedidoArray['monto_total'] = array_sum(array_column($this->pedidoArray['productos'], 'monto_total'));
    }

    public function aplicarDescuentoLista()
    {
        $this->montoDescuento = 0.00;
        $this->pedidoArray['productos'] = array_map(function ($item) {
            $aplicaDescuento = in_array($item['categoria'], $this->categoriasDescuentos);
            if ($this->descuentoAplicado && $this->descuentoAplicado && $aplicaDescuento) {
                $descuento = $item['subTotal'] * $this->descuentoAplicado / 100;
                $item['descuento'] =  $descuento;
                $item['monto_total'] = $item['subTotal'] - $descuento;
                $this->montoDescuento += $descuento;
            }
            return $item;
        }, $this->pedidoArray['productos']);
        $this->pedidoArray['monto_total'] = array_sum(array_column($this->pedidoArray['productos'], 'monto_total'));
    }

    public function render()
    {
        $productos = Producto::GetProductosFilter($this->filter);
        if ($this->descuentoCheck) {
            $this->descuentoAplicado = Descuento::getDescuento($this->descuentoCheck)->porcentaje;
            $this->aplicarDescuentoLista();
        }
        return view('livewire.ventas.pedido.edit-pedido', compact('productos'))->layout('layouts.venta');
    }
}
