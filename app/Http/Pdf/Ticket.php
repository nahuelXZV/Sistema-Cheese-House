<?php

namespace App\Http\Pdf;

use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Pedido;

class Ticket extends Fpdf
{
    protected $fpdf;
    public $margin = 10;
    public $width = 70;
    public $space = 4;

    public function __construct()
    {
        $this->fpdf = new Fpdf('P', 'mm', array(80, 175));
    }

    private function fechaLiteral($fecha)
    {
        $fecha = explode('/', $fecha);
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];
        return $fecha[0] . ' de ' . $meses[$fecha[1]] . ' de ' . $fecha[2];
    }

    function formatearNumero($numero)
    {
        $numero = str_replace(',', '', $numero);
        if (strpos($numero, '.') !== false) {
            $numero = rtrim($numero, '0');
            if (substr($numero, -1) === '.') {
                $numero = rtrim($numero, '.'); // Remover el punto decimal final
            }
        }
        return $numero;
    }


    public function crear($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        $fecha = date('d/m/Y', strtotime($pedido->fecha));
        $fechaLiteral = $this->fechaLiteral($fecha);
        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(5, 0, 5);
        $this->fpdf->SetAutoPageBreak(true, 10);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("CHEESE HOUSE         "), 0, 'C', 0);
        $this->fpdf->Ln(3);

        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Av. Paragua esq Los Socoris entre 2do y 3er anillo."), 0, 'C', 0);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Tel. 64881234."), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("RECIBO DE COMPRA"), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Nro Pedido: " . $pedido->codigo_seguimiento), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Cliente: " . $pedido->cliente), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Metodo de pago: " . $pedido->metodo_pago), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Fecha: " . $fechaLiteral), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Hora: " . $pedido->hora), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(40, 5, utf8_decode("DESCRIPCION"), 0,  0, 'L');
        $this->fpdf->Cell(10, 5, utf8_decode("Cnt"), 0, 0, 'R');
        $this->fpdf->Cell(20, 5, utf8_decode("Impt"), 0, 0, 'R');
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->Ln(5);
        foreach ($pedido->detalle_pedidos as $detalle_pedido) {
            $nombre = $detalle_pedido->producto->nombre;
            if (strlen($nombre) > 22) $nombre = substr($nombre, 0, 22) . "...";
            $this->fpdf->Cell(40, 5, utf8_decode($nombre), 0,  0, 'L');
            $this->fpdf->Cell(10, 5, utf8_decode($detalle_pedido->cantidad), 0, 0, 'R');
            $monto = $this->formatearNumero($detalle_pedido->monto_total);
            $this->fpdf->Cell(20, 5, utf8_decode($monto . " Bs"), 0, 0, 'R');
            $this->fpdf->Ln(5);
        }
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', '', 12);
        $monto =  $this->formatearNumero($pedido->monto_total);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Total: " . $monto . " Bs"), 0, 'R', 0);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Gracias por su compra"), 0, 'C', 0);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Vuelva pronto"), 0, 'C', 0);
        $this->fpdf->Output("I", "ticket.pdf");
    }
}
