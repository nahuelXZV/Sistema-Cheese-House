<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class ReporteController extends Controller
{
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function reportesVentasAnuales()
    {
        $name = date('d-m-Y') . '-ventas-anuales.xlsx';
        return $this->excel->download(new \App\Exports\PedidoAnualExport, $name);
    }

    public function reportesVentasMensuales($mouth)
    {
        $name = $mouth . '-ventas-mensuales.xlsx';
        return $this->excel->download(new \App\Exports\PedidoMensualExport($mouth), $name);
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
