<?php

namespace App\Classes\Reports\Receivable;

use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;

class EstadoCartera extends FPDF
{
    function buldReport($data, $title) {
        $this->SetMargins(5,5,5);
        $this->SetTitle($title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->bodyTable($data);
    }

    function Header() {
        $empresa = Empresa::getEmpresa();
        $this->SetXY(0,10);
		$this->SetFont('Arial','B',13);
        $this->Cell(280,5,utf8_decode($empresa->tercero_razonsocial),0,0,'C');
		$this->SetXY(75,17);
		$this->SetFont('Arial','B',8);
        $this->Cell(130,5,"NIT: $empresa->tercero_nit",0,0,'C');
		$this->Line(10,22,270,22);;
		$this->SetXY(85,23);
        $this->Cell(110, 5, utf8_decode($this->metadata['Title']), 0, 0,'C');
        $this->Ln(5);
        $this->headerTable();
    }

    function Footer() {
        $user = utf8_decode(auth()->user()->username);
        $date = date('Y-m-d H:i:s');

        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Pág ').$this->PageNo().'/{nb}',0,0,'L');
        $this->Cell(0,10,"Usuario: $user - Fecha: $date",0,0,'R');
    }

    function headerTable() {
        $this->SetFont('Arial','B',8);
        $this->Cell(35,5,'DOCUMENTO',1);
        $this->Cell(30,5,'FECHA',1);
        $this->Cell(130,5,'DETALLE',1);
        $this->Cell(30,5,'VENCIMIENTO',1);
        $this->Cell(15,5,utf8_decode('N° DÍAS'),1);
        $this->Cell(30,5,'SALDO',1);
        $this->Ln();
    }

    function bodyTable($data) {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $tercero = '' ;
        $tsaldo = 0;
        foreach($data as $key => $item){
            if ($tercero != $item->tercero_nit) {
                if ($key > 0) {
                    $this->totalSaldo($tsaldo);
                    $tsaldo = 0;
                }
                $this->SetFont('Arial', 'B', 8);
                $encabezado = utf8_decode("$item->tercero_nit $item->tercero_nombre | $item->tercero_telefono1 | $item->tercero_direccion | $item->municipio_nombre");
                $this->Cell(280, 5, $encabezado,0 ,0, '');
                $this->Ln();
            }
            $this->SetFont('Arial', '', 7);
            $fill = !$fill;
            $obs = utf8_decode($item->orden_observaciones);
            $this->Cell(35,5,"$item->factura1_numero -  $item->factura1_prefijo",'', 0, '', $fill);
            $this->Cell(30,5,"$item->factura1_fecha",'', 0, '', $fill);
            $this->Cell(130,5,"$item->orden_codigo | $obs" ,'', 0, '', $fill);
            $this->Cell(30,5,$item->factura4_vencimiento,'', 0, '', $fill);
            $this->Cell(15,5,$item->days,'', 0, '', $fill);
            $this->Cell(30,5,number_format($item->factura4_saldo,2,',' , '.'),'', 0, 'R', $fill);
            $this->Ln();

            $tercero = $item->tercero_nit;
            $tsaldo += $item->factura4_saldo;

            if ($key == $data->count()-1) {
                $this->totalSaldo($tsaldo);
                $tsaldo = 0;
            }
        }
        $this->Output('d',sprintf('%s_%s.pdf', 'estado_cartera', date('Y_m_d H_i_s')));
    }

    function totalSaldo($tsaldo) {
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(240,5,'Total',0,0,'R');
        $this->Cell(30,5,number_format ($tsaldo,2,',' , '.'),0,0,'R');
        $this->Ln();
    }
}
