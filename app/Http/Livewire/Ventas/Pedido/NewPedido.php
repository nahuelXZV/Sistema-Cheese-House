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

class NewPedido extends Component
{
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

    public function mount()
    {
        $this->filter = CategoriasProductos::PIZZA;
        $numeroSeguimiento = $this->getNumeroSeguimiento();
        $this->pedidoArray = [
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i'),
            'estado' => 'Pendiente',
            'monto_total' => 0.00,
            'metodo_pago' => '',
            'cliente' => '',
            'codigo_seguimiento' => $numeroSeguimiento,
            'proveniente' => '',
            'detalles' => '',
            'tipo_pedido' => '',
            'productos' => [],
            'descuento' => null,
            'nombre_descuento'  => '',
            'descuento_id' => null,
        ];
        $this->metodoPagos = MetodoPagos::getMetodoPagos();
        $this->proveniencias = ProvenienciaVenta::getProveniencias();
        $this->tipos = TipoVenta::getTipoVentas();
        $this->descuentos = Descuento::GetDescuentosAll();
        $this->categoriasDescuentos = [CategoriasProductos::PIZZA, CategoriasProductos::POSTRE, CategoriasProductos::MITAD];
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
        if ($this->descuentoCheck) {
            $descuento = Descuento::getDescuento($this->descuentoCheck);
            $this->pedidoArray['descuento'] = $descuento->porcentaje;
            $this->pedidoArray['nombre_descuento'] = $descuento->nombre;
            $this->pedidoArray['descuento_id'] = $descuento->id;
        }
        $new = PedidoService::CreatePedido($this->pedidoArray);
        if (!$new) {
            $this->message = 'Error al crear el pedido';
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

    // NICE
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
        $this->pedidoArray['codigo_seguimiento'] = $this->getNumeroSeguimiento();
        $productos = Producto::GetProductosFilter($this->filter);
        if ($this->descuentoCheck) {
            $this->descuentoAplicado = Descuento::getDescuento($this->descuentoCheck)->porcentaje;
            $this->aplicarDescuentoLista();
        }
        return view('livewire.ventas.pedido.new-pedido', compact('productos'))->layout('layouts.venta');
    }
}
