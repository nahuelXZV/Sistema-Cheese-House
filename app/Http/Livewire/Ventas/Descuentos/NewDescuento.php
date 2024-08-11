<?php

namespace App\Http\Livewire\Ventas\Descuentos;

use App\Models\Descuento;
use Livewire\Component;
use tidy;

class NewDescuento extends Component
{
    public $descuentoArray = [];
    public $message = '';
    public $showMessage = false;

    public function mount()
    {
        $this->descuentoArray = [
            'nombre' => '',
            'porcentaje' => null,
            'estado' => true
        ];
    }

    public function save()
    {
        $this->validate(Descuento::$validate, Descuento::$messages);
        $new = Descuento::CreateDescuento($this->descuentoArray);
        if (!$new) {
            $this->message = 'Error al crear el descuento';
            $this->showMessage = true;
        }
        return redirect()->route('descuento.list');
    }
    public function render()
    {
        return view('livewire.ventas.descuentos.new-descuento');
    }
}
