<?php

namespace App\Http\Livewire\Ventas\Pedido;

use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Livewire\Component;

class ShowCocina extends Component
{

    public function getNamePizza($id)
    {
        $pedido = Producto::find($id);
        return $pedido->nombre;
    }

    public function refreshComponent()
    {
        $this->emit('refreshComponent');
    }

    public function updateEstado($id)
    {
        $pedido = Pedido::find($id);
        $pedido->estado = 'Finalizado';
        $pedido->save();
        $this->refreshComponent();
    }

    public function render()
    {
        $pedidos = [];
        $pedidosDB = Pedido::where('estado', 'Pendiente')->whereDay('created_at', date('d'))->orderBy('created_at', 'asc')->get();
        foreach ($pedidosDB as $key => $pedido) {
            $pedidos[$key] = $pedido->toArray();
            $detalles = $pedido->detalle_pedidos()->get()->toArray();
            foreach ($detalles as $keyDetalle => $detalle) {
                if ($detalle['producto_id'] == 1) {
                    $detalles[$keyDetalle]['mitad_uno'] = Producto::find($detalle['mitad_uno'])->nombre;
                    $detalles[$keyDetalle]['mitad_dos'] = Producto::find($detalle['mitad_dos'])->nombre;
                }
                $detalles[$keyDetalle]['producto_id'] = Producto::find($detalle['producto_id'])->nombre;
            }
            $pedidos[$key]['detalles_pedidos'] = $detalles;
        }
        return view('livewire.ventas.pedido.show-cocina', compact('pedidos'))->layout('layouts.venta');
    }
}
