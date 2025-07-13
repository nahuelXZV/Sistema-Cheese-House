<?php

namespace App\Http\Livewire\Compra\Compra;

use App\Models\NotaCompra;
use Livewire\Component;
use Livewire\WithPagination;

class ListCompra extends Component
{
    use WithPagination;
    public $attribute = '';
    public $message = '';
    public $showMessage = false;
    public $mouthReport = "";

    public function mount()
    {
        $this->mouthReport = now()->format('Y-m');
    }

    //Metodo de reinicio de buscador
    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $compra = NotaCompra::DeleteNotaCompra($id);
        if ($compra) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $compras = NotaCompra::GetNotaCompras($this->attribute, 'ASC', 20);
        return view('livewire.compra.compra.list-compra', compact('compras'));
    }
}
