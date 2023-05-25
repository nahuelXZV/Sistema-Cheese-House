<?php

namespace App\Http\Livewire\Compra\Proveedor;

use App\Models\NotaCompra;
use App\Models\Proveedor;
use Livewire\Component;

class ShowProveedor extends Component
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

    public function render()
    {
        $compras = NotaCompra::GetNotaCompraByProveedor($this->proveedor->id);
        return view('livewire.compra.proveedor.show-proveedor', compact('compras'));
    }
}
