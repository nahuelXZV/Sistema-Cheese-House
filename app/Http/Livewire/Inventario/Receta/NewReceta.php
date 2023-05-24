<?php

namespace App\Http\Livewire\Inventario\Receta;

use App\Models\Ingrediente;
use App\Models\Receta;
use Livewire\Component;

class NewReceta extends Component
{
    public $recetaArray = [];
    public $message = '';
    public $showMessage = false;
    public $ingredientes = [];

    public function mount()
    {
        $this->ingredientes = Ingrediente::GetIngredientesAll();
        $this->recetaArray = [
            'nombre' => '',
            'costo' => '',
            'descripcion' => '',
            'ingredientes' => []
        ];
    }

    public function save()
    {
        $this->validate(Receta::$validate, Receta::$messages);
        $new = Receta::CreateReceta($this->ingredienteArray);
        if (!$new) {
            $this->message = 'Error al crear la receta';
            $this->showMessage = true;
        }
        return redirect()->route('ingredientes.list');
    }


    public function addIngrediente($ingrediente)
    {
        array_merge($this->recetaArray['ingredientes'], [$ingrediente]);
    }

    public function render()
    {
        return view('livewire.inventario.receta.new-receta');
    }
}
