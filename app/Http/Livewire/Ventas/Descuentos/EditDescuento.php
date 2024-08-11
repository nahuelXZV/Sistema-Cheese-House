<?php

namespace App\Http\Livewire\Ventas\Descuentos;

use App\Models\Descuento;
use Livewire\Component;

class EditDescuento extends Component
{
    public $descuentoArray = [];
    public $message = '';
    public $showMessage = false;
    public $descuento;

    public function mount($descuento)
    {
        $this->descuento = Descuento::GetDescuento($descuento);
        $this->descuentoArray = $this->descuento->toArray();
    }

    public function save()
    {
        $this->validate(Descuento::$validate, Descuento::$messages);
        $new = Descuento::UpdateDescuento($this->descuento->id, $this->descuentoArray);
        if (!$new) {
            $this->message = 'Error al actualizar el descuento';
            $this->showMessage = true;
        }
        return redirect()->route('descuento.list');
    }

    public function render()
    {
        return view('livewire.ventas.descuentos.edit-descuento');
    }
}
