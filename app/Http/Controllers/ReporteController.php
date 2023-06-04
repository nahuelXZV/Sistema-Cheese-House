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
        return $this->excel->download(new \App\Exports\PedidoAnualExport, 'ventas-anuales.xlsx');
    }

    public function reportesVentasMensuales()
    {
        return $this->excel->download(new \App\Exports\PedidoMensualExport, 'ventas-mensuales.xlsx');
    }

    public function reportesIngredientesAnuales()
    {
        return $this->excel->download(new \App\Exports\IngredienteAnualExport, 'inventario-anuales.xlsx');
    }

    public function reportesIngredientesMensuales()
    {
        return $this->excel->download(new \App\Exports\IngredienteMensualExport, 'inventario-mensuales.xlsx');
    }
}
