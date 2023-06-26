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

    public function crear($pedidoId)
    {
        $pedido = Pedido::find($pedidoId);
        $fecha = date('d/m/Y', strtotime($pedido->fecha));
        $fechaLiteral = $this->fechaLiteral($fecha);
        $this->fpdf->AddPage();
        $this->fpdf->SetMargins(5, 0, 5);
        $this->fpdf->SetAutoPageBreak(true, 10);
        // diseño del ticket donde se muestre el nombre de la empresa la fecha y el numero de pedido tambien los productos
        $this->fpdf->SetFont('Arial', 'B', 12);
        // $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("CHEESE HOUSE         "), 0, 'C', 0);
        // imagen con el logo
        $this->fpdf->Image('logo.png', 30, 8, 20, 20, 'PNG');
        $this->fpdf->Ln(20);

        // DIRECCION Y NUMERO
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Av. Paragua esq Los Socoris entre 2do y 3er anillo."), 0, 'C', 0);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Tel. 64881234."), 0, 'C', 0);
        $this->fpdf->Ln(5);
        // UN SEPARADOR
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("RECIBO DE COMPRA"), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);

        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Fecha: " . $fechaLiteral . ", " . $pedido->hora), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("No. Pedido: " . $pedido->codigo_seguimiento), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Cliente: " . $pedido->cliente), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Metodo de pago: " . $pedido->metodo_pago), 0, 'L', 0);
        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);

        $this->fpdf->Ln(2);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("DESCRIPCION"), 0, 'L', 0);
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Ln(2);
        foreach ($pedido->detalle_pedidos as $detalle_pedido) {
            $nombre = $detalle_pedido->producto->nombre;
            if (strlen($nombre) > 25) $nombre = substr($nombre, 0, 25) . "...";
            $this->fpdf->Cell(50, 5, utf8_decode($nombre), 0,  0, 'L');
            $this->fpdf->Cell(20, 5, utf8_decode($detalle_pedido->monto_total . " Bs"), 0, 0, 'R');
            $this->fpdf->Ln(5);
        }
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);
        $this->fpdf->Ln(3);
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Total: " . $pedido->monto_total . " Bs"), 0, 'R', 0);
        $this->fpdf->SetFont('Arial', 'B', 12);
        $this->fpdf->Ln(3);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("* * * * * * * * * * * * * * * * * * * * * * * *"), 0, 'C', 0);

        // AGRADECIMIETNO
        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Gracias por su compra"), 0, 'C', 0);
        $this->fpdf->MultiCell($this->width, $this->space, utf8_decode("Vuelva pronto"), 0, 'C', 0);
        $this->fpdf->Output("I", "ticket.pdf");
    }
}
