<?php

namespace App\Http\Livewire\Ventas\Descuentos;

use App\Models\Descuento;
use Livewire\Component;
use Livewire\WithPagination;

class ListDescuento extends Component
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
        $user = Descuento::DeleteDescuento($id);
        if ($user) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $descuentos = Descuento::GetDescuentos($this->attribute, 'ASC', 20);
        return view('livewire.ventas.descuentos.list-descuento', compact('descuentos'));
    }
}
