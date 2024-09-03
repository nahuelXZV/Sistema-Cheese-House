<?php

namespace App\Http\Livewire\Ventas\Caja;

use App\Constants\CategoriasProductos;
use App\Constants\MetodoPagos;
use App\Models\DetallePedido;
use App\Services\CajaService;
use App\Services\PedidoService;
use Livewire\Component;

class ShowCaja extends Component
{
    public $caja;
    public $cajaAnterior;
    public $pedidosSinProcesar;
    public $pedidos;

    public $totalPizzasVendidas;
    public $cajero;

    public $cantidadPedidos;
    public $ventas;

    public $estadoCaja = [];
    public $cantidad_deposito;
    public $transpaso_caja_chica;
    public $adicion_caja_chica;
    public $caja_dia_siguiente;
    public $cortesia;
    public $falto;
    public $cajaInicial;

    public $message = '';
    public $showMessage = false;

    public function mount($caja)
    {
        $this->caja = CajaService::GetCaja($caja);
        $this->cantidad_deposito = $this->caja->cantidad_deposito;
        $this->transpaso_caja_chica = $this->caja->transpaso_caja_chica;
        $this->adicion_caja_chica = $this->caja->adicion_caja_chica;
        $this->caja_dia_siguiente = $this->caja->caja_dia_siguiente;
        $this->cortesia = $this->caja->cortesia;
        $this->falto = $this->caja->falto;

        $this->cajaAnterior = CajaService::GetCaja($caja - 1);
        if ($this->cajaAnterior) {
            $this->cajaInicial = $this->cajaAnterior->caja_dia_siguiente;
        } else {
            $this->cajaInicial = 0;
        }
        $this->pedidosSinProcesar = PedidoService::GetPedidosCaja($this->caja->fecha);
        $this->estadoCaja = [
            'efectivo' => 0,
            'tarjeta' => 0,
            'qr' => 0,
        ];
        $this->CalcularCantidadPizza();
    }

    public function CalcularCantidadPizza()
    {
        $this->totalPizzasVendidas = 0;
        $this->ventas = 0;
        $this->cantidadPedidos = count($this->pedidosSinProcesar);
        if (count($this->pedidosSinProcesar) == 0) return;
        $this->cajero = $this->pedidosSinProcesar[0]->user_name;
        foreach ($this->pedidosSinProcesar as $pedido) {
            $PedidoProcesado = $pedido;
            $this->ventas += $pedido->monto_total;
            // Ingresos por metodo de pago
            if ($pedido->metodo_pago == MetodoPagos::EFECTIVO)
                $this->estadoCaja['efectivo'] += $pedido->monto_total;
            else if ($pedido->metodo_pago == MetodoPagos::TARJETA)
                $this->estadoCaja['tarjeta'] += $pedido->monto_total;
            else if ($pedido->metodo_pago == MetodoPagos::QR)
                $this->estadoCaja['qr'] += $pedido->monto_total;

            $detalles = DetallePedido::where('pedido_id', $pedido->id)->get();
            foreach ($detalles as $detalle) {
                $esPizzaCompleta = $detalle->producto->categoria == CategoriasProductos::PIZZA;
                $esPizzaMitad = $detalle->producto->categoria == CategoriasProductos::MITAD;
                if ($esPizzaCompleta) {
                    $this->totalPizzasVendidas += $detalle->cantidad;
                    $PedidoProcesado->totalPizzasVendidas += $detalle->cantidad;
                } else if ($esPizzaMitad) {
                    $this->totalPizzasVendidas += $detalle->cantidad / 2;
                    $PedidoProcesado->totalPizzasVendidas += $detalle->cantidad / 2;
                } else {
                    $PedidoProcesado->totalPizzasVendidas += 0;
                }
            }
            $this->pedidos[] = $PedidoProcesado;
        }
    }

    public function update()
    {
        try {
            $this->caja->update(
                [
                    'cantidad_deposito' => $this->cantidad_deposito,
                    'transpaso_caja_chica' => $this->transpaso_caja_chica,
                    'adicion_caja_chica' => $this->adicion_caja_chica,
                    'caja_dia_siguiente' => $this->caja_dia_siguiente,
                    'cortesia' => $this->cortesia,
                    'falto' => $this->falto,
                ]
            );
            $this->message = 'Actualizado correctamente';
            $this->showMessage = true;
        } catch (\Throwable $th) {
            $this->message = 'Error al actualizar';
            $this->showMessage = true;
        }
    }

    public function render()
    {
        return view('livewire.ventas.caja.show-caja');
    }
}
