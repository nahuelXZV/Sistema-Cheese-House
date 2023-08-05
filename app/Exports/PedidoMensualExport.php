<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PedidoMensualExport implements FromCollection, WithHeadings
{
    protected $encabezado;
    protected $mes;
    protected $anio;

    public function headings(): array
    {
        return $this->encabezado;
    }

    public function __construct($mouth)
    {
        $this->mes = date('m', strtotime($mouth));
        $this->anio = date('Y', strtotime($mouth));
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
            )->whereMonth('pedidos.created_at', $this->mes)->whereYear('pedidos.created_at', $this->anio)
            ->orderBy('pedidos.created_at', 'DESC')
            ->get();
    }
}
