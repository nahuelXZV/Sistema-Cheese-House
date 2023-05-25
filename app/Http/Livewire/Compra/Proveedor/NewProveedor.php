<?php

namespace App\Http\Livewire\Compra\Proveedor;

use App\Models\Proveedor;
use Livewire\Component;

class NewProveedor extends Component
{
    public $proveedorArray = [];
    public $message = '';
    public $showMessage = false;

    public function mount()
    {
        $this->proveedorArray = [
            'nombre_empresa' => '',
            'nombre_encargado' => '',
            'telefono' => '',
            'correo' => '',
            'direccion' => '',
            'descripcion' => '',
        ];
    }

    public function save()
    {
        $this->validate(Proveedor::$validate, Proveedor::$messages);
        $new = Proveedor::CreateProveedor($this->proveedorArray);
        if (!$new) {
            $this->message = 'Error al crear el proveedor';
            $this->showMessage = true;
        }
        return redirect()->route('proveedores.list');
    }

    public function render()
    {
        return view('livewire.compra.proveedor.new-proveedor');
    }
}
