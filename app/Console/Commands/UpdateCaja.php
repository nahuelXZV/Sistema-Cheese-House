<?php

namespace App\Console\Commands;

use App\Models\Caja;
use App\Services\PedidoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateCaja extends Command
{
    protected $signature = 'app:update-caja';
    protected $description = 'Command description';

    public function handle()
    {
        Log::info('Entro a cerrar la caja');
        try {
            $fecha = now()->format('Y-m-d');
            $caja =  Caja::where('fecha', $fecha)->orderBy('fecha', 'desc')->first();
            if (!$caja) return;
            $pedidos = PedidoService::GetPedidosCaja($caja->fecha);
            $total = 0;
            foreach ($pedidos as $pedido) {
                $total += $pedido->monto_total;
            }
            $caja->total_ventas = $total;
            $caja->save();
            Log::info('Caja cerrada correctamente');
        } catch (\Throwable $th) {
            Log::error('Error al cerrar la caja: ' . $th->getMessage());
        }
    }
}
