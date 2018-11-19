<?php

namespace App\Classes\Reports\Accounting;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class LibroMayor extends FPDF
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
        $this->Cell(110, 5, $this->metadata['Title'], 0, 0,'C');
        $this->Ln(5);
        $this->headerTable();
    }

    function Footer() {
        $user = utf8_decode(Auth::user()->username);
        $date = date('Y-m-d H:m:s');

        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Pág ').$this->PageNo().'/{nb}',0,0,'L');
        $this->Cell(0,10,"Usuario: $user - Fecha: $date",0,0,'R');
    }

    function headerTable() {
        $this->SetFont('Arial','B',8);

        $this->Cell(105,5,'',1);
        $this->Cell(54,5,'Saldo anterior',1,0,'C');
        $this->Cell(54,5,'Movimientos',1,0,'C');
        $this->Cell(54,5,'Nuevo saldo',1,0,'C');
        $this->Ln();

        $this->Cell(35,5,'Cuenta',1);
        $this->Cell(70,5,'Nombre',1);
        $this->Cell(27,5,utf8_decode('Débito'),1,0,'C');
        $this->Cell(27,5,utf8_decode('Crédito'),1,0,'C');
        $this->Cell(27,5,utf8_decode('Débito'),1,0,'C');
        $this->Cell(27,5,utf8_decode('Crédito'),1,0,'C');
        $this->Cell(27,5,utf8_decode('Débito'),1,0,'C');
        $this->Cell(27,5,utf8_decode('Crédito'),1,0,'C');
        $this->Ln();
    }

    function bodyTable($data) {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $this->SetFont('Arial','',7);

        // Inicializo variables de 'TOTALES'
        $tdebitoinicial = $tcreditoinicial = $tdebitomes = $tcreditomes = $tsdebito = $tscredito = 0;
        foreach($data as $saldo){
            // Inicializo variables para el encabezado de 'NUEVO SALDO'
            $sdebito = $saldo->debitoinicial + $saldo->debitomes;
            $scredito = $saldo->creditoinicial + $saldo->creditomes;

            $this->Cell(35, 5, $saldo->cuenta, '', 0, 'R', $fill);
            $this->Cell(70, 5, $saldo->nombre, '', 0, '', $fill);
            $this->Cell(27, 5, number_format($saldo->debitoinicial, 2, ',', '.'), '', 0, 'R',$fill);
            $this->Cell(27, 5, number_format($saldo->creditoinicial, 2, ',', '.'), '', 0, 'R',$fill);
            $this->Cell(27, 5, number_format($saldo->debitomes, 2, ',', '.'), '', 0, 'R', $fill);
            $this->Cell(27, 5, number_format($saldo->creditomes, 2, ',', '.'), '', 0, 'R', $fill);
            $this->Cell(27, 5, number_format($sdebito, 2, ',' , '.'), '', 0, 'R', $fill);
            $this->Cell(27, 5, number_format($scredito, 2, ',' , '.'), '', 0, 'R', $fill);
            $this->Ln();

            // Capturando sumatoria
            $tdebitoinicial += $saldo->debitoinicial; $tcreditoinicial += $saldo->creditoinicial; $tdebitomes += $saldo->debitomes; $tcreditomes += $saldo->creditomes; $tsdebito += $sdebito; $tscredito += $scredito ;
        }

        // Pintando totales
        $this->SetFont('Arial','B',7);
        $this->Cell(105, 5, 'TOTALES', '', 0, 'R', $fill);
        $this->Cell(27, 5, number_format ($tdebitoinicial,2,',' , '.'), '', 0, 'R', $fill);
        $this->Cell(27, 5, number_format ($tcreditoinicial,2,',' , '.'), '', 0, 'R', $fill);
        $this->Cell(27, 5, number_format ($tdebitomes,2,',' , '.'), '', 0, 'R', $fill);
        $this->Cell(27, 5, number_format ($tcreditomes,2,',' , '.'), '', 0, 'R', $fill);
        $this->Cell(27, 5, number_format ($tsdebito,2,',' , '.'), '', 0, 'R', $fill);
        $this->Cell(27, 5, number_format ($tscredito,2,',' , '.'), '', 0, 'R', $fill);

        $this->Output(sprintf('%s_%s_%s.pdf', 'libro_mayor_', date('Y_m_d'), date('H_m_s')),'d');
    }
}
