<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Models\Pedido;
use App\Services\PedidoService;
use Livewire\Component;
use Livewire\WithPagination;

class ListPedido extends Component
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
        $pedido = PedidoService::DeletePedido($id);
        if ($pedido) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $pedidos = PedidoService::GetPedidos($this->attribute, 'ASC', 20);
        return view('livewire.ventas.pedido.list-pedido', compact('pedidos'));
    }
}
