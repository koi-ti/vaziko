<?php

namespace App\Classes\Reports\Accounting;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class AuxCuentaBeneficiario extends FPDF
{
    private $title;
    private $subtitle;
    private $subtitleTercero;
    function buldReport($data, $title, $subtitle, $subtitleTercero)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->subtitleTercero = $subtitleTercero;

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
        $this->Cell(290, 5, utf8_decode($this->subtitleTercero), 0, 0,'C');
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
        $this->Cell(45,5,'Folder',1);
        $this->Cell(50,5,'Doc contable',1);
        $this->Cell(90,5,'Detalle',1);
        $this->Cell(30,5,utf8_decode('Débito'),1);
        $this->Cell(30,5,utf8_decode('Crédito'),1);
        $this->Cell(30,5,'Saldo',1);
        $this->Ln();
    }

    function bodyTable($data)
    {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $tercero = '' ;
        $debito = $credito = $tdebito = $tcredito = 0;
        $this->Cell(280,5,"$this->subtitle",0,0,'C');
        $this->Ln(5);
        foreach($data as $key => $item){
            if ($tercero != $item->tercero_nit) {
                if ($key > 0) {
                    $this->totalTercero($nombre, $tdebito, $tcredito);
                    $tdebito = $tcredito = 0;
                }
                $nombre = "$item->tercero_nit - $item->tercero_nombre";
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(280,5,utf8_decode($nombre),0,0,'');
                $this->Ln();
            }
            $this->SetFont('Arial', '', 7);
            $fill = !$fill;
            $this->Cell(15,5,$item->date,'',0,'',$fill);
            $this->Cell(45,5,$item->folder_nombre,'',0,'',$fill);
            $this->Cell(50,5,$item->documento_nombre,'',0,'',$fill);
            $this->Cell(90,5,utf8_decode($item->asiento2_detalle),'',0,'',$fill);
            $this->Cell(30,5,number_format ($item->debito,2,',' , '.'),'',0,'R',$fill);
            $this->Cell(30,5,number_format ($item->credito,2,',' , '.'),'',0,'R',$fill);

            // Obtener saldo
            $this->Cell(30,5,$this->getSaldo($item->debito, $item->credito),'',0,'R',$fill);
            $this->Ln();

            // Reference values
            $tercero = $item->tercero_nit;
            $debito += $item->debito;
            $credito += $item->credito;
            $tdebito += $item->debito;
            $tcredito +=  $item->credito;

            if ($key == $data->count()-1) {
                $this->totalTercero($nombre, $tdebito, $tcredito);
                $tdebito = $tcredito = 0;
            }
        }
        $this->totally($debito, $credito);
        $this->Output(sprintf('%s_%s_%s.pdf', 'auxcuentabeneficiario', date('Y_m_d'), date('H_m_s')),'d');
    }

    function getSaldo($debito, $credito)
    {
        $saldo = number_format ($debito - $credito,2,',' , '.');
        if ($debito < $credito)
            $saldo = number_format ($credito - $debito,2,',' , '.'). ' CR';
        return $saldo;
    }
    function totalTercero($tercero, $tdebito, $tcredito)
    {
        list($nit, $nombre) = explode('-', $tercero);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(200,5,'TOTAL '. utf8_decode($nombre),0,0,'R');
        $this->Cell(30,5,number_format ($tdebito,2,',' , '.'),0,0,'R');
        $this->Cell(30,5,number_format ($tcredito,2,',' , '.'),0,0,'R');

        // Obtener saldo
        $this->Cell(30,5,$this->getSaldo($tdebito, $tcredito),'',0,'R');
        $this->Ln(5);
    }
    function totally($debito, $credito)
    {
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(200,5,'TOTALES',0,0,'R');
        $this->Cell(30,5,number_format ($debito,2,',' , '.'),0,0,'R');
        $this->Cell(30,5,number_format ($credito,2,',' , '.'),0,0,'R');

        // Obtener saldo
        $this->Cell(30,5,$this->getSaldo($debito, $credito),'',0,'R');
        $this->Ln(5);
    }
}
