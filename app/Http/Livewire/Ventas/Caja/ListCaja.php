<?php

namespace App\Http\Livewire\Ventas\Caja;

use App\Services\CajaService;
use Livewire\Component;
use Livewire\WithPagination;

class ListCaja extends Component
{
    use WithPagination;

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function render()
    {
        $cajas = CajaService::GetCajas();
        return view('livewire.ventas.caja.list-caja', compact('cajas'));
    }
}
