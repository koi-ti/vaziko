<?php

namespace App\Classes\Reports\Accounting;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class RelacionImpuestos extends FPDF
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
        $user = utf8_decode(Auth::user()->username);
        $date = date('Y-m-d H:i:s');

        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Pág ').$this->PageNo().'/{nb}',0,0,'L');
        $this->Cell(0,10,"Usuario: $user - Fecha: $date",0,0,'R');
    }

    function headerTable() {
        $this->SetFont('Arial','B',8);
        $this->Cell(20,5,'NIT',1);
        $this->Cell(95,5,'NOMBRE',1);
        $this->Cell(20,5,'BASE',1);
        $this->Cell(20,5,utf8_decode('DÉBITO'),1);
        $this->Cell(20,5,utf8_decode('CRÉDITO'),1);
        $this->Cell(95,5,utf8_decode('DIRECCIÓN'),1);
        $this->Ln();
    }

    function bodyTable($data) {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $this->SetFont('Arial', '', 8);
        $cuenta = '' ;
        $debito = $credito = $tbase = $tdebito = $tcredito = 0;
        foreach($data as $key => $item){
            if ($cuenta != $item->plancuentas_cuenta) {
                if ($key > 0) {
                    $this->totalAccount($tbase, $tdebito, $tcredito);
                    $tbase = $tdebito = $tcredito = 0;
                }
                $this->SetFont('Arial', 'B', 8);
                $nombre = $item->plancuentas_nombre;
                $this->Cell(280,5,"$item->plancuentas_cuenta -  $nombre : Tasa $item->plancuentas_tasa %",0,0,'');
                $this->Ln();
            }

            $this->SetFont('Arial', '', 7);
            $fill = !$fill;
            $this->Cell(20,4,$item->tercero_nit,'',0,'',$fill);
            $this->Cell(95,4,utf8_decode($item->tercero_nombre),'',0,'',$fill);
            $this->Cell(20,4,number_format ($item->base,2,',' , '.'),'',0,'',$fill);
            $this->Cell(20,4,number_format ($item->debito,2,',' , '.'),'',0,'',$fill);
            $this->Cell(20,4,number_format ($item->credito,2,',' , '.'),'',0,'',$fill);
            $this->Cell(95,4,utf8_decode("$item->tercero_direccion|$item->municipio_nombre|$item->tercero_telefono1"),'',0,'',$fill);
            $this->Ln();

            $cuenta = $item->plancuentas_cuenta;
            $debito += $item->debito;
            $credito += $item->credito;
            $tbase += $item->base;
            $tdebito += $item->debito;
            $tcredito +=  $item->credito;

            if ($key == $data->count()-1) {
                $this->totalAccount($tbase, $tdebito, $tcredito);
                $tbase = $tdebito = $tcredito = 0;
            }
        }
        $this->totalNaturaleza($debito, $credito);
        $this->Output('d',sprintf('%s_%s.pdf', 'relacion_impuestos', date('Y_m_d H_i_s')));
    }

    function totalAccount($tbase, $tdebito, $tcredito) {
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(115,5,'Total',0,0,'R');
        $this->Cell(20,5,number_format ($tbase,2,',' , '.'),0,0,'');
        $this->Cell(20,5,number_format ($tdebito,2,',' , '.'),0,0,'');
        $this->Cell(20,5,number_format ($tcredito,2,',' , '.'),0,0,'');
        $this->Ln();
    }

    function totalNaturaleza($debito, $credito) {
        $total = number_format ($debito - $credito,2,',' , '.');
        if ($debito < $credito)
            $total = number_format ($credito - $debito,2,',' , '.'). ' CR';

        $this->SetFont('Arial', 'B', 7);
        $this->Ln();
        $this->Cell(135,5,utf8_decode('Total CRÉDITO ó DÉBITO'),0,0,'R');
        $this->Cell(40,5,$total,0,0,'R');
        $this->Ln();
    }
}
