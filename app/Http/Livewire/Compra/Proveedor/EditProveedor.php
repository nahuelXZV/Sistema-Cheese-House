<?php

namespace App\Http\Livewire\Compra\Proveedor;

use App\Models\Proveedor;
use Livewire\Component;

class EditProveedor extends Component
{
    public $proveedorArray = [];
    public $message = '';
    public $showMessage = false;
    public $proveedor;

    public function mount($proveedor)
    {
        $this->proveedor = Proveedor::GetProveedor($proveedor);
        $this->proveedorArray = [
            'nombre_empresa' => $this->proveedor->nombre_empresa,
            'nombre_encargado' => $this->proveedor->nombre_encargado,
            'telefono' => $this->proveedor->telefono,
            'correo' => $this->proveedor->correo,
            'direccion' => $this->proveedor->direccion,
            'descripcion' => $this->proveedor->descripcion,
        ];
    }

    public function save()
    {
        $this->validate(Proveedor::$validate, Proveedor::$messages);
        $new = Proveedor::UpdateProveedor($this->proveedor->id, $this->proveedorArray);
        if (!$new) {
            $this->message = 'Error al actualizar el proveedor';
            $this->showMessage = true;
        }
        return redirect()->route('proveedores.list');
    }

    public function render()
    {
        return view('livewire.compra.proveedor.edit-proveedor');
    }
}
