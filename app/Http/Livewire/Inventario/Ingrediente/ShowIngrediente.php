<?php

namespace App\Http\Livewire\Inventario\Ingrediente;

use App\Models\Ingrediente;
use Livewire\Component;

class ShowIngrediente extends Component
{
    public $message = '';
    public $showMessage = false;
    public $ingrediente;
    public $recetas;

    public function mount($ingrediente)
    {
        $this->ingrediente = Ingrediente::GetIngrediente($ingrediente);
        $this->recetas = $this->ingrediente->recetas;
    }

    public function render()
    {
        return view('livewire.inventario.ingrediente.show-ingrediente');
    }
}
