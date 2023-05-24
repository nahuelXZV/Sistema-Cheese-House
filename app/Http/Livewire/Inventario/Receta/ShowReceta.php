<?php

namespace App\Http\Livewire\Inventario\Receta;

use App\Models\Receta;
use Livewire\Component;

class ShowReceta extends Component
{
    public $receta;

    public function mount($receta)
    {
        $this->receta = Receta::GetReceta($receta);
    }

    public function render()
    {
        return view('livewire.inventario.receta.show-receta');
    }
}
