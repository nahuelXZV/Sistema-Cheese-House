<?php

namespace App\Http\Livewire\Inventario\Ingrediente;

use App\Models\Ingrediente;
use Livewire\Component;

class EditIngrediente extends Component
{
    public $ingredienteArray = [];
    public $message = '';
    public $showMessage = false;
    public $ingrediente;

    public function mount($ingrediente)
    {
        $this->ingrediente = Ingrediente::GetIngrediente($ingrediente);
        $this->ingredienteArray = $this->ingrediente->toArray();
    }

    public function save()
    {
        $this->validate(Ingrediente::$validate, Ingrediente::$messages);
        $new = Ingrediente::UpdateIngrediente($this->ingrediente->id, $this->ingredienteArray);
        if (!$new) {
            $this->message = 'Error al actualizar el ingrediente';
            $this->showMessage = true;
        }
        return redirect()->route('ingredientes.list');
    }

    public function render()
    {
        return view('livewire.inventario.ingrediente.edit-ingrediente');
    }
}
