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
            'Vendedor',
            'Cliente',
            'Fecha',
            'Hora',
            'Monto Total',
            'Metodo de Pago',
            'Procedencia',
            'Detalles',
        ];
    }

    public function collection()
    {
        return Pedido::join('users', 'users.id', '=', 'pedidos.user_id')
            ->select(
                'pedidos.id',
                'users.name as vendedor',
                'cliente',
                'fecha',
                'hora',
                'monto_total',
                'metodo_pago',
                'proveniente',
                'detalles',
            )->whereYear('pedidos.created_at', date('Y'))
            ->orderBy('pedidos.created_at', 'DESC')
            ->get();
    }
}
