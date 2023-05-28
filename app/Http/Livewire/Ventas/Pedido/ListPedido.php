<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Models\Pedido;
use Livewire\Component;
use Livewire\WithPagination;

class ListPedido extends Component
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
        $pedido = Pedido::DeletePedido($id);
        if ($pedido) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $pedidos = Pedido::GetPedidos($this->attribute, 'ASC', 20);
        return view('livewire.ventas.pedido.list-pedido', compact('pedidos'));
    }
}
