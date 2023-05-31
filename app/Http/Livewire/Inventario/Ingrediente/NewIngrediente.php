<?php

namespace App\Http\Livewire\Inventario\Ingrediente;

use App\Models\Ingrediente;
use Livewire\Component;

class NewIngrediente extends Component
{
    public $ingredienteArray = [];
    public $message = '';
    public $showMessage = false;

    public function mount()
    {
        $this->ingredienteArray = [
            'nombre' => '',
            'unidad' => '',
            'stock' => '',
            'precio_unidad' => '',
            'stock_minimo' => '',
            'stock_maximo' => 0,
            'descripcion' => ''
        ];
    }

    public function save()
    {
        $this->validate(Ingrediente::$validate, Ingrediente::$messages);
        $new = Ingrediente::CreateIngrediente($this->ingredienteArray);
        if (!$new) {
            $this->message = 'Error al crear el ingrediente';
            $this->showMessage = true;
        }
        return redirect()->route('ingredientes.list');
    }

    public function render()
    {
        return view('livewire.inventario.ingrediente.new-ingrediente');
    }
}
