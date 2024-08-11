<?php

namespace App\Http\Livewire\Inventario\Ingrediente;

use App\Models\Ingrediente;
use Livewire\Component;
use Livewire\WithPagination;

class ListIngrediente extends Component
{
    use WithPagination;
    public $attribute = '';
    public $message = '';
    public $showMessage = false;
    public $date;
    public $diaAnterior;

    public function mount()
    {
        $this->date = now()->subDay()->format('Y-m-d');
        $this->diaAnterior = now()->subDay()->format('Y-m-d');
    }

    //Metodo de reinicio de buscador
    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $user = Ingrediente::DeleteIngrediente($id);
        if ($user) {
            $this->message = 'Eliminado correctamente';
        } else {
            $this->message = 'Error al eliminar';
        }
        $this->showMessage = true;
    }

    public function render()
    {
        $ingredientes = Ingrediente::GetIngredientes($this->attribute, 'ASC', 20);
        return view('livewire.inventario.ingrediente.list-ingrediente', compact('ingredientes'));
    }
}
