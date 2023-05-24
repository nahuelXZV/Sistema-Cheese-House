<?php

namespace App\Http\Livewire\Inventario\Receta;

use App\Models\Receta;
use Livewire\Component;
use Livewire\WithPagination;

class ListReceta extends Component
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
        $user = Receta::DeleteReceta($id);
        if ($user) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $recetas = Receta::GetRecetas($this->attribute, 'ASC', 20);
        return view('livewire.inventario.receta.list-receta', compact('recetas'));
    }
}
