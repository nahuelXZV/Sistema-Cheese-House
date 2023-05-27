<?php

namespace App\Http\Livewire\Compra\Compra;

use App\Models\NotaCompra;
use Livewire\Component;

class ShowCompra extends Component
{
    public $message = '';
    public $showMessage = false;
    public $notaCompra;

    public function mount($compra)
    {
        $this->notaCompra = NotaCompra::GetNotaCompra($compra);
    }

    public function render()
    {
        return view('livewire.compra.compra.show-compra');
    }
}
