<?php

namespace App\Classes\Reports\Accounting;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class PlanCuentas extends FPDF
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
        $this->Cell(220,5,utf8_decode($empresa->tercero_razonsocial),0,0,'C');
		$this->SetXY(75,17);
		$this->SetFont('Arial','B',8);
        $this->Cell(70,5,"NIT: $empresa->tercero_nit",0,0,'C');
		$this->Line(10,22,200,22);;
		$this->SetXY(85,23);
        $this->Cell(50, 5, utf8_decode($this->metadata['Title']), 0, 0,'C');
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
        $this->Cell(35,5,'CUENTA',1);
        $this->Cell(90,5,'NOMBRE',1);
        $this->Cell(15,5,'NV',1);
        $this->Cell(15,5,'C/D',1);
        $this->Cell(20,5,'TER',1);
        $this->Cell(25,5,'TASA',1);
        $this->Ln();
    }

    function bodyTable($data)
    {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $this->SetFont('Arial', '', 8);
        foreach($data as $cuenta)
        {
            $fill = !$fill;
            $this->Cell(35,5,$cuenta->plancuentas_cuenta,'',0,'R',$fill);
            $this->Cell(90,5,utf8_decode($cuenta->plancuentas_nombre),'',0,'',$fill);
            $this->Cell(15,5,$cuenta->plancuentas_nivel ,'',0,'',$fill);
            $this->Cell(15,5,$cuenta->plancuentas_naturaleza,'',0,'',$fill);
            $this->Cell(20,5,($cuenta->plancuentas_tercero ? 'SI': 'NO') ,'',0,'',$fill);
            $this->Cell(25,5,$cuenta->plancuentas_tasa,'',0,'',$fill);
            $this->Ln();
        }
        $this->Output(sprintf('%s_%s_%s.pdf', 'plancuentas', date('Y_m_d'), date('H_m_s')),'d');
    }
}
