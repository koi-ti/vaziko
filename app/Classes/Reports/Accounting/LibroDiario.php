<?php

namespace App\Classes\Reports\Accounting;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class LibroDiario extends FPDF
{
    function buldReport($data, $title) {
        $this->SetMargins(10,10,10);
        $this->SetTitle($title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->bodyTable($data);
    }

    function Header() {
        $empresa = Empresa::getEmpresa();
        $this->SetXY(0,10);
		$this->SetFont('Arial','B',13);
        $this->Cell(220,5,utf8_decode($empresa->tercero_razonsocial),0,0,'C');
		$this->SetXY(75,17);
		$this->SetFont('Arial','B',8);
        $this->Cell(70,5,"NIT: $empresa->tercero_nit",0,0,'C');
		$this->Line(10,22,200,22);;
		$this->SetXY(85,23);
        $this->Cell(50, 5, $this->metadata['Title'], 0, 0,'C');
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
        $this->Cell(40,5,'Cuenta',1);
        $this->Cell(90,5,'Nombre',1);
        $this->Cell(30,5,utf8_decode('Débito'),1);
        $this->Cell(30,5,utf8_decode('Crédito'),1);
        $this->Ln();
    }

    function bodyTable($data) {
        $fill = false;
        $this->SetFillColor(247,247,247);
        foreach ($data as $key => $asientos) {
            $tdebito = $tcredito = 0;
            $this->SetFont('Arial','B',8);
            $this->Cell(100,5,$key,0,0,'');
            $this->Ln();
            foreach ($asientos as $asiento) {
                $this->SetFont('Arial', '', 7);
                // dd($asiento);
                $this->Cell(40,5,$asiento->plancuentas_cuenta,'',0,'R',$fill);
                $this->Cell(90,5,$asiento->plancuentas_nombre,'',0,'',$fill);
                $this->Cell(30,5,number_format ($asiento->debito,2,',' , '.'),'',0,'R',$fill);
                $this->Cell(30,5,number_format ($asiento->credito,2,',' , '.'),'',0,'R',$fill);
                $this->Ln();
                $tdebito += $asiento->debito; $tcredito += $asiento->credito;
            }
            $this->SetFont('Arial','B',7);
            $this->Cell(130,5,'TOTAL','',0,'R',$fill);
            $this->Cell(30,5,number_format ($tdebito,2,',' , '.'),'',0,'R',$fill);
            $this->Cell(30,5,number_format ($tcredito,2,',' , '.'),'',0,'R',$fill);
            $this->Ln();

        }
        $this->Output(sprintf('%s_%s.pdf', 'libro_diario_', date('Y_m_d H_i_s')),'d');
    }
}
