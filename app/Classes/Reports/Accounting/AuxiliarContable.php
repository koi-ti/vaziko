<?php

namespace App\Classes\Reports\Accounting;

use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;

class AuxiliarContable extends FPDF
{
    function buldReport($data, $title) {
        $this->SetMargins(2,2,2);
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
		$this->Line(10,22,280,22);;
		$this->SetXY(85,23);
        $this->Cell(115, 5, $this->metadata['Title'], 0, 0,'C');
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
        $this->Cell(15,5,'Fecha',1);
        $this->Cell(50,5,'Doc contable',1);
        $this->Cell(15,5,'Asiento',1);
        $this->Cell(25,5,'Nit',1);
        $this->Cell(75,5,'Nombre',1);
        $this->Cell(20,5,'Doc origen',1);
        $this->Cell(15,5,utf8_decode('N° origen'),1);
        $this->Cell(25,5,utf8_decode('Débito'),1);
        $this->Cell(25,5,utf8_decode('Crédito'),1);
        $this->Cell(25,5,'Base',1);
        $this->Ln();
    }

    function bodyTable($data) {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $cuenta = '' ;
        foreach($data as $item){
            if ($cuenta != $item->cuenta) {
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(280,5,"$item->cuenta - $item->plancuentas_nombre",0,0,'C');
                $this->Ln();
            }
            $this->SetFont('Arial', '', 7);
            $fill = !$fill;
            $this->Cell(15,5,$item->date,'',0,'',$fill);
            $this->Cell(50,5,$item->documento_nombre,'',0,'',$fill);
            $this->Cell(15,5,$item->asiento1_numero,'',0,'C',$fill);
            $this->Cell(25,5,$item->tercero_nit,'',0,'',$fill);
            $this->Cell(75,5,utf8_decode($item->tercero_nombre),'',0,'',$fill);
            $this->Cell(20,5,'-','',0,'C',$fill);
            $this->Cell(15,5,'-','',0,'C',$fill);
            $this->Cell(25,5,number_format ($item->debito,2,',' , '.'),'',0,'R',$fill);
            $this->Cell(25,5,number_format ($item->credito,2,',' , '.'),'',0,'R',$fill);
            $this->Cell(25,5,number_format ($item->base,2,',' , '.'),'',0,'R',$fill);
            $this->Ln();
            $cuenta = $item->cuenta;
        }
        $this->Output(sprintf('%s_%s.pdf', 'auxcontable', date('Y_m_d H_i_s')),'d');
    }
}
