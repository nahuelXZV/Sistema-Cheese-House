<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Models\Pedido;
use Livewire\Component;

class ShowPantalla extends Component
{
    public $pedidos;

    public function refreshComponent()
    {
        $this->emit('refreshComponent');
    }

    public function render()
    {
        $this->pedidos = Pedido::where('estado', 'Finalizado')->whereDay('created_at', date('d'))->orderBy('created_at', 'desc')->limit(2)->get();
        return view('livewire.ventas.pedido.show-pantalla')->layout('layouts.pantalla');
    }
}
