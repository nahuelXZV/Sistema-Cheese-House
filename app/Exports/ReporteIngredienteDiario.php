<?php

namespace App\Exports;

use App\Models\ReporteIngrediente;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteIngredienteDiario implements FromCollection, WithHeadings, WithColumnWidths
{
    protected $encabezado;
    protected $fecha;

    public function headings(): array
    {
        return $this->encabezado;
    }

    public function __construct($fecha)
    {
        $this->fecha = $fecha;
        $this->encabezado = [
            '#',
            'Ingrediente',
            'Producto',
            'Nombre',
            'Fecha',
            'Stock Inicial',
            'Stock Ventas',
            'Stock Compras',
            'Stock Final',
        ];
    }

    public function collection()
    {
        return ReporteIngrediente::select(
            'id',
            DB::raw("CASE WHEN ingrediente_id IS NOT NULL THEN 'X' ELSE '' END as ingrediente_id_exists"),
            DB::raw("CASE WHEN producto_id IS NOT NULL THEN 'X' ELSE '' END as producto_id_exists"),
            'nombre',
            'fecha',
            'stock_inicial',
            'stock_ventas',
            'stock_compras',
            'stock_final',
        )->where('fecha', $this->fecha)
            ->orderBy('reporte_ingredientes.nombre', 'DESC')
            ->get();
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 12,
            'C' => 12,
            'D' => 30,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
        ];
    }
}
