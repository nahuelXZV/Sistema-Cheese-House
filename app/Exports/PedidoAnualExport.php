<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PedidoAnualExport implements FromCollection, WithHeadings
{
    protected $encabezado;

    public function headings(): array
    {
        return $this->encabezado;
    }

    public function __construct()
    {
        $this->encabezado = [
            'ID',
            'Cliente',
            'Fecha',
            'Hora',
            'Monto Total',
            'Metodo de Pago',
            'Procedencia',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }

    public function collection()
    {
        return Pedido::select(
            'id',
            'cliente',
            'fecha',
            'hora',
            'monto_total',
            'metodo_pago',
            'proveniente',
            'created_at',
            'updated_at'
        )->whereYear('created_at', date('Y'))->get();
    }
}
