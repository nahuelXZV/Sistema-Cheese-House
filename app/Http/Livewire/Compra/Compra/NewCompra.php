<?php

namespace App\Http\Livewire\Compra\Compra;

use App\Models\Ingrediente;
use App\Models\NotaCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use Livewire\Component;

class NewCompra extends Component
{
    public $compraArray = [];
    public $productosArray = [];
    public $mostrarProductos = [];
    public $message = '';
    public $showMessage = false;

    public $productos = [];
    public $ingredientes = [];
    public $proveedores = [];


    public function mount()
    {
        $this->ingredientes = Ingrediente::GetIngredientesAll()->toArray();
        $this->productos = Producto::GetProductosAll()->toArray();
        $this->proveedores = Proveedor::GetProveedorsAll();
        $this->compraArray = [
            'fecha' => date('Y-m-d'),
            'hora' => date('H:i'),
            'monto_total' => 0.00,
            'descripcion' => '',
            'proveedor_id' => '',
            'productos' => [],
            'estado' => 'finalizado',
        ];
        $this->resetProductoArray();
    }

    public function save()
    {
        $this->validate(NotaCompra::$validate, NotaCompra::$messages);
        $new = NotaCompra::CreateNotaCompra($this->compraArray);
        if (!$new) {
            $this->message = 'Error al crear la compra';
            $this->showMessage = true;
        }
        return redirect()->route('compras.list');
    }


    public function addProductos()
    {
        $this->validate(NotaCompra::$validateProductos, NotaCompra::$messageProductos);
        $ingrediente = null;
        $producto = null;
        if ($this->productosArray['ingrediente_id'] != '') {
            $ingrediente = Ingrediente::GetIngrediente($this->productosArray['ingrediente_id']);
            $this->productosArray['nombre'] = $ingrediente->nombre;
            $this->productosArray['unidad'] = $ingrediente->unidad;
            $this->productosArray['precio_unidad'] = $ingrediente->precio_unidad;
            $this->productosArray['tipo'] = 'ingrediente';
            $this->productosArray['monto_total'] += $this->productosArray['cantidad'] * $this->productosArray['precio_unidad'];
            $this->compraArray['monto_total'] += $this->productosArray['monto_total'];
            array_push($this->compraArray['productos'], $this->productosArray);
            $this->ingredientes = array_filter($this->ingredientes, function ($item) {
                return $item['id'] != $this->productosArray['ingrediente_id'];
            });
        }

        if ($this->productosArray['producto_id'] != '') {
            $producto = Producto::GetProducto($this->productosArray['producto_id']);
            $this->productosArray['nombre'] = $producto->nombre;
            $this->productosArray['unidad'] = 'unidad';
            $this->productosArray['precio_unidad'] = $producto->precio;
            $this->productosArray['tipo'] = 'producto';
            $this->productosArray['monto_total'] += $this->productosArray['cantidad'] * $this->productosArray['precio_unidad'];
            $this->compraArray['monto_total'] += $this->productosArray['monto_total'];
            array_push($this->compraArray['productos'], $this->productosArray);
            $this->productos = array_filter($this->productos, function ($item) {
                return $item['id'] != $this->productosArray['producto_id'];
            });
        }
        $this->resetProductoArray();
    }

    private function resetProductoArray()
    {
        $this->productosArray = [
            'ingrediente_id' => '',
            "producto_id" => '',
            "cantidad" => '',
            "detalles" => '',
            "monto_total" => 0.00,
            "precio_unidad" => '',
            'tipo' => '',
        ];
    }

    public function deleteProductos($ingrediente_id, $producto_id, $monto_total)
    {
        if ($ingrediente_id != 0) {
            $ingrediente = Ingrediente::GetIngrediente($ingrediente_id);
            $this->compraArray['monto_total'] -= $monto_total;
            $this->compraArray['productos'] = array_filter($this->compraArray['productos'], function ($item) use ($ingrediente_id) {
                return $item['ingrediente_id'] != $ingrediente_id;
            });
            array_push($this->ingredientes, $ingrediente);
        };
        if ($producto_id != 0) {
            $producto = Producto::GetProducto($producto_id);
            $this->compraArray['monto_total'] -= $monto_total;
            $this->compraArray['productos'] = array_filter($this->compraArray['productos'], function ($item) use ($producto_id) {
                return $item['producto_id'] != $producto_id;
            });
            array_push($this->productos, $producto);
        };
    }


    public function render()
    {
        return view('livewire.compra.compra.new-compra');
    }
}
