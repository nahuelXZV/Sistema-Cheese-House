<?php

namespace App\Http\Livewire\Inventario\Combo;

use App\Models\Combo;
use App\Services\ComboService;
use Livewire\Component;
use Livewire\WithPagination;

class ListCombos extends Component
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

    public function render()
    {
        $combos = ComboService::GetCombos($this->attribute, 'ASC', 20);
        return view('livewire.inventario.combo.list-combos', compact('combos'));
    }
}
