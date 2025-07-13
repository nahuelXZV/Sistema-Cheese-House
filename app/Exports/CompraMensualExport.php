<?php

namespace App\Exports;

use App\Models\NotaCompra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompraMensualExport implements FromCollection, WithHeadings
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
            'Proveedor',
            'Fecha',
            'Hora',
            'Monto Total',
            'Estado',
            'Descripción',
            'Tipo de Pago',
        ];
    }

    public function collection()
    {
        return NotaCompra::join('users', 'users.id', '=', 'nota_compras.user_id')
            ->join('proveedors', 'proveedors.id', '=', 'nota_compras.proveedor_id')
            ->select(
                'nota_compras.id',
                'users.name as vendedor',
                'proveedors.nombre_empresa as cliente',
                'fecha',
                'hora',
                'monto_total',
                'estado',
                'nota_compras.descripcion',
                'tipo_pago',
            )->whereMonth('nota_compras.created_at', $this->mes)->whereYear('nota_compras.created_at', $this->anio)
            ->orderBy('nota_compras.created_at', 'DESC')
            ->get();
    }
}
