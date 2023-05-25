<?php

namespace App\Http\Livewire\Compra\Proveedor;

use App\Models\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;

class ListProveedor extends Component
{
    use WithPagination;
    public $attribute = '';
    public $message = '';
    public $showMessage = false;

    //Metodo de reinicio de buscador
    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $proveedor = Proveedor::DeleteProveedor($id);
        if ($proveedor) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $proveedores = Proveedor::GetProveedors($this->attribute, 'ASC', 20);
        return view('livewire.compra.proveedor.list-proveedor', compact('proveedores'));
    }
}
