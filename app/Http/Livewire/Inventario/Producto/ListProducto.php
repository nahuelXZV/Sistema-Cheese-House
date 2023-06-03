<?php

namespace App\Http\Livewire\Inventario\Producto;

use App\Models\Producto;
use Livewire\Component;
use Livewire\WithPagination;

class ListProducto extends Component
{
    use WithPagination;
    public $attribute = '';
    public $message = '';
    public $showMessage = false;


    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $producto = Producto::DeleteProducto($id);
        if ($producto) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $productos = Producto::GetProductos($this->attribute, 'ASC', 20);
        return view('livewire.inventario.producto.list-producto', compact('productos'));
    }
}
