<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Excel;

class ReporteController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function reportesVentasAnuales($year)
    {
        $name = date('Y', strtotime($year)) . '-ventas-anuales.xlsx';
        return $this->excel->download(new \App\Exports\PedidoAnualExport($year), $name);
    }

    public function reportesVentasMensuales($mouth)
    {
        $name = $mouth . '-ventas-mensuales.xlsx';
        return $this->excel->download(new \App\Exports\PedidoMensualExport($mouth), $name);
    }

    public function reportesComprasAnuales($year)
    {
        $name = date('Y', strtotime($year)) . '-compras-anuales.xlsx';
        return $this->excel->download(new \App\Exports\CompraAnualExport($year), $name);
    }

    public function reportesComprasMensuales($mouth)
    {
        $name = $mouth . '-compras-mensuales.xlsx';
        return $this->excel->download(new \App\Exports\CompraMensualExport($mouth), $name);
    }

    public function reportesIngredientesAnuales()
    {
        $name = date('d-m-Y') . '-inventario-anuales.xlsx';
        return $this->excel->download(new \App\Exports\IngredienteAnualExport, $name);
    }

    public function reportesIngredientesMensuales()
    {
        $name = date('d-m-Y') . '-inventario-mensuales.xlsx';
        return $this->excel->download(new \App\Exports\IngredienteMensualExport, $name);
    }

    public function reportesIngredientesDiarios($date)
    {
        $name = date('d-m-Y') . '-inventario-diarios.xlsx';
        return $this->excel->download(new \App\Exports\ReporteIngredienteDiario($date), $name);
    }
}
