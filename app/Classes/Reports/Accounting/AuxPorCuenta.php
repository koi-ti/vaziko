<?php

namespace App\Classes\Reports\Accounting;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class AuxPorCuenta extends FPDF
{
    private $title;
    private $subtitle;
    private $saldo;
    function buldReport($data, $saldo, $title, $subtitle)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->saldo = $saldo;

        $this->SetMargins(2,2,2);
        $this->SetTitle($this->title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->bodyTable($data);
    }
    function Header()
    {
        $empresa = Empresa::getEmpresa();
        $this->SetXY(0,10);
		$this->SetFont('Arial','B',13);
        $this->Cell(290,5,utf8_decode($empresa->tercero_razonsocial),0,0,'C');
		$this->SetXY(75,17);
		$this->SetFont('Arial','B',8);
        $this->Cell(140,5,"NIT: $empresa->tercero_nit",0,0,'C');
		$this->Line(10,22,280,22);;
		$this->SetXY(85,23);
        $this->Cell(125, 5, $this->title, 0, 0,'C');
        $this->Ln(5);
        $this->Cell(290, 5, utf8_decode($this->subtitle), 0, 0,'C');
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
        $this->Cell(15,5,'Fecha',1);
        $this->Cell(15,5,'Folder',1);
        $this->Cell(50,5,'Doc contable',1);
        $this->Cell(90,5,'Detalle',1);
        $this->Cell(30,5,utf8_decode('Sdo anterior'),1);
        $this->Cell(30,5,utf8_decode('Débito'),1);
        $this->Cell(30,5,utf8_decode('Crédito'),1);
        $this->Cell(30,5,'Saldo',1);
        $this->Ln();
    }

    function bodyTable($data)
    {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $debito = $credito = 0;
        $this->Cell(170,5,"$this->subtitle",0,0,'R');
        $this->Cell(30,5,$this->saldo->inicial,'',0,'R');
        $this->Cell(30,5,$this->saldo->debitomes,'',0,'R');
        $this->Cell(30,5,$this->saldo->creditomes,'',0,'R');
        $this->Cell(30,5,$this->saldo->final,'',0,'R');
        $this->Ln(5);

        foreach($data as $key => $item){

            $this->SetFont('Arial', '', 7);
            $fill = !$fill;
            $this->Cell(15,5,$item->date,'',0,'',$fill);
            $this->Cell(15,5,$item->folder_codigo,'',0,'R',$fill);
            $this->Cell(50,5,$item->documento_nombre,'',0,'',$fill);
            $this->Cell(90,5,utf8_decode($item->asiento2_detalle),'',0,'',$fill);
            $this->Cell(30,5,'','',0,'R',$fill);
            $this->Cell(30,5,$item->debito,'',0,'R',$fill);
            $this->Cell(30,5,$item->credito,'',0,'R',$fill);
            // Obtener saldo
            $this->getSaldo($item->debito, $item->credito);
            $this->Cell(30,5,$this->saldo->inicial,'',0,'R',$fill);
            $this->Ln();

            $nombre = "$item->tercero_nit - $item->tercero_nombre";
            $this->Cell(150,5,utf8_decode($nombre),0,0,'R');
            $this->Ln();

            // Reference values
            $debito += $item->debito;
            $credito += $item->credito;
        }
        $this->totally($debito, $credito);
        $this->Output(sprintf('%s_%s_%s.pdf', 'libroporcuenta', date('Y_m_d'), date('H_m_s')),'d');
    }

    function getSaldo($debito, $credito)
    {
        if ($debito < $credito){
            $this->saldo->inicial -= $credito - $debito;
        }else {
            $this->saldo->inicial -= $debito - $credito;
        }
    }

    function totally($debito, $credito)
    {
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(200,5,'TOTALES',0,0,'R');
        $this->Cell(30,5,$debito,0,0,'R');
        $this->Cell(30,5,$credito,0,0,'R');
        $this->Cell(30,5,$this->saldo->inicial,0,0,'R');
    }
}
