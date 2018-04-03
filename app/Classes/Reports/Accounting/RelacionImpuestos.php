<?php

namespace App\Classes\Reports\Accounting;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class RelacionImpuestos extends FPDF
{

    function buldReport($data, $title)
    {
        $this->SetMargins(5,5,5);
        $this->SetTitle($title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->bodyTable($data);
    }
    function Header()
    {
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
    function Footer()
    {
        $user = utf8_decode(Auth::user()->username);
        $date = date('Y-m-d H:m:s');

        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Pág ').$this->PageNo().'/{nb}',0,0,'L');
        $this->Cell(0,10,"Usuario: $user - Fecha: $date",0,0,'R');
    }

    function headerTable()
    {
        $this->SetFont('Arial','B',8);
        $this->Cell(25,5,'NIT',1);
        $this->Cell(100,5,'NOMBRE',1);
        $this->Cell(30,5,'BASE',1);
        $this->Cell(30,5,'IMPUESTOS',1);
        $this->Cell(85,5,utf8_decode('DIRECCIÓN'),1);
        $this->Ln();
    }

    function bodyTable($data)
    {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $this->SetFont('Arial', '', 8);
        $cuenta = '' ;
        $tbase = $timpuesto = 0;
        foreach($data as $key => $item){
            if ($cuenta != $item->plancuentas_cuenta) {
                $this->SetFont('Arial', 'B', 8);
                if ($key > 0) {
                    $this->Cell(125,5,'Total',0,0,'R');
                    $this->Cell(30,5,number_format ($tbase,2,',' , '.'),0,0,'');
                    $this->Cell(30,5,number_format ($timpuesto,2,',' , '.'),0,0,'');
                    $this->Ln();
                    $tbase = $timpuesto = 0;
                }
                $nombre = $item->plancuentas_nombre;
                $this->Cell(280,5,"$item->plancuentas_cuenta -  $nombre : Tasa $item->plancuentas_tasa %",0,0,'');
                $this->Ln();
            }
            $tbase += $item->base;
            $timpuesto += $item->impuesto;

            $this->SetFont('Arial', '', 7);
            $fill = !$fill;
            $this->Cell(25,4,$item->tercero_nit,'',0,'',$fill);
            $this->Cell(100,4,utf8_decode($item->tercero_nombre),'',0,'',$fill);
            $this->Cell(30,4,number_format ($item->base,2,',' , '.'),'',0,'',$fill);
            $this->Cell(30,4,number_format ($item->impuesto,2,',' , '.'),'',0,'',$fill);
            $this->Cell(85,4,$item->tercero_direccion,'',0,'',$fill);
            $this->Ln();
            $cuenta = $item->plancuentas_cuenta;

            if ($key == $data->count()-1) {
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(125,5,'Total',0,0,'R');
                $this->Cell(30,5,number_format ($tbase,2,',' , '.'),0,0,'');
                $this->Cell(30,5,number_format ($timpuesto,2,',' , '.'),0,0,'');
                $tbase = $timpuesto = 0;
            }
        }
        $this->Output(sprintf('%s_%s_%s.pdf', 'relacion_impuestos', date('Y_m_d'), date('H_m_s')),'d');
    }
}
