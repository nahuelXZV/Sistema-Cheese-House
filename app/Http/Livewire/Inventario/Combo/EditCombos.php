<?php

namespace App\Http\Livewire\Inventario\Combo;

use App\Models\Combo;
use App\Models\Producto;
use App\Services\ComboService;
use Livewire\Component;

class EditCombos extends Component
{
    public $comboArray = [];
    public $productosArray = [];
    public $message = '';
    public $showMessage = false;
    public $productos = [];
    public $combo;
    private $validateProducto = [
        'productosArray.producto_id' => 'required',
        'productosArray.cantidad' => 'required|numeric|min:0'
    ];
    private $messagesProductos = [
        'productosArray.producto_id.required' => 'El producto es requerido',
        'productosArray.cantidad.required' => 'La cantidad es requerida',
        'productosArray.cantidad.numeric' => 'La cantidad debe ser numerica',
        'productosArray.cantidad.min' => 'La cantidad debe ser mayor a 0',
    ];

    public function mount($combo)
    {
        $this->combo = ComboService::GetCombo($combo);
        $this->productos = Producto::GetAll()->toArray();
        $this->comboArray = [
            'nombre' => $this->combo->nombre,
            'costo_total' => 0.00,
            'activo' => $this->combo->activo,
            'descripcion' => $this->combo->descripcion,
            'productos' => []
        ];
        $this->productosArray = [
            "producto_id" => '',
            "nombre" => '',
            "cantidad" => '',
            "precio_unidad" => 0.00
        ];
        foreach ($this->combo->productos as $producto) {
            $this->productosArray = [
                "producto_id" => $producto->id,
                "cantidad" => $producto->pivot->cantidad,
            ];
            $this->addIngrediente();
        }
        $this->comboArray['costo_total'] = $this->combo->costo_total;
    }

    public function save()
    {
        $this->validate(Combo::$validate, Combo::$messages);
        $this->comboArray['activo'] = $this->comboArray['activo'] == 1 ? true : false;
        $new = ComboService::UpdateCombo($this->combo->id, $this->comboArray);
        if (!$new) {
            $this->message = 'Error al crear el combo';
            $this->showMessage = true;
        }
        return redirect()->route('combos.list');
    }


    public function addIngrediente()
    {
        $this->validate($this->validateProducto, $this->messagesProductos);

        $producto = Producto::GetProducto($this->productosArray['producto_id']);
        $this->productosArray['nombre'] = $producto->nombre;
        $this->productosArray['precio_unidad'] = $producto->precio;
        array_push($this->comboArray['productos'], $this->productosArray);

        $this->productos = array_filter($this->productos, function ($item) {
            return $item['id'] != $this->productosArray['producto_id'];
        });
        $this->comboArray['costo_total'] += $this->productosArray['cantidad'] * $this->productosArray['precio_unidad'];
        $this->productosArray = [
            "producto_id" => '',
            "nombre" => '',
            "cantidad" => '',
            "precio_unidad" => ''
        ];
    }

    public function deleteIngrediente($id, $cantidad)
    {
        $producto = Producto::GetProducto($id);
        $this->comboArray['costo_total'] -= $cantidad * $producto->precio;
        $this->comboArray['productos'] = array_filter($this->comboArray['productos'], function ($item) use ($id) {
            return $item['producto_id'] != $id;
        });
        array_push($this->productos, $producto);
    }

    public function render()
    {
        return view('livewire.inventario.combo.edit-combos');
    }
}
