<?php

namespace App\Console\Commands;

use App\Models\Caja;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateCaja extends Command
{
    protected $signature = 'app:create-caja';
    protected $description = 'Command description';

    private function transtaleDay($day)
    {
        $days = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miercoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sabado',
            'Sunday' => 'Domingo',
        ];
        return $days[$day];
    }

    public function handle()
    {
        Log::info('Entro a generar la caja');
        try {
            $fecha = now()->format('Y-m-d');
            $creado =  Caja::where('fecha', $fecha)->orderBy('fecha', 'desc')->first();
            if ($creado) return;
            Log::info('Generando caja para la fecha: ' . $fecha);
            $diaLiteral = $this->transtaleDay(now()->format('l'));
            $caja = new Caja();
            $caja->fecha = $fecha;
            $caja->dia = $diaLiteral;
            $caja->save();
            Log::info('Caja generada correctamente');
        } catch (\Throwable $th) {
            Log::error('Error al generar la caja: ' . $th->getMessage());
        }
    }
}
