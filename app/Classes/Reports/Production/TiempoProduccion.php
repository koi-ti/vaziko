<?php

namespace App\Classes\Reports\Production;

use App\Classes\Reports\FPDF_CellFit;
use App\Models\Base\Empresa;

class TiempoProduccion extends FPDF_CellFit
{
    private $title;
    private $data;

    function buldReport($data, $title) {
        $this->title = $title;

        $this->SetMargins(5,5,5);
        $this->SetTitle($this->title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->table( $data );
    }

    function Header() {
        $empresa = Empresa::getEmpresa();
        $this->SetXY(0,10);
        $this->SetFont('Arial','B',13);
        $this->Cell(0,5,utf8_decode($empresa->tercero_razonsocial),0,0,'C');
        $this->SetXY(0,17);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,5,"NIT: $empresa->tercero_nit",0,0,'C');
        $this->Line(10,22,287,22);
        $this->SetXY(0,23);
        $this->Cell(0, 5, $this->title, 0, 0,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
    }

    function table( $tiempos ) {
        foreach ($tiempos as $funcionario) {
            $this->SetFont('Arial','B',8);
            $this->Cell(0, 5, utf8_decode($funcionario->tercero->tercero_nombre), 0, 0,'C');
            $this->Ln();
            $this->Cell(0,5,"NIT: ".$funcionario->tercero->tercero_nit,0,0,'C');
            $this->Ln();

            $this->SetFont('Arial','B',8);
            $this->Cell(10,5,'#',1);
            $this->Cell(100,5,'ORDEN',1);
            $this->Cell(32,5,'ACTIVIDAD',1);
            $this->Cell(32,5,'SUBACTIVIDAD',1);
            $this->Cell(32,5,'AREA',1);
            $this->Cell(30,5,'FECHA',1);
            $this->Cell(25,5,'H. INICIO',1);
            $this->Cell(25,5,'H. FIN',1);
            $this->Ln();

            $fill = false;
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');
            foreach ($funcionario->tiemposp as $tiempo) {
                $this->SetFont('Arial','',7);
                $this->CellFitScale(10,5,$tiempo->id,'LR',0,'L',$fill);
                $this->CellFitScale(100,5,isset($tiempo->orden_codigo) && isset( $tiempo->tercero_nombre ) ? $tiempo->orden_codigo.' '.utf8_decode($tiempo->tercero_nombre) : '-','LR',0,'L',$fill);
                $this->CellFitScale(32,5,utf8_decode($tiempo->actividadp_nombre),'LR',0,'L',$fill);
                $this->CellFitScale(32,5,isset($tiempo->subactividadp_nombre) ? utf8_decode($tiempo->subactividadp_nombre) : '-','LR',0,'L',$fill);
                $this->CellFitScale(32,5,utf8_decode($tiempo->areap_nombre),'LR',0,'L',$fill);
                $this->CellFitScale(30,5,$tiempo->tiempop_fecha,'LR',0,'L',$fill);
                $this->CellFitScale(25,5,$tiempo->tiempop_hora_inicio,'LR',0,'L',$fill);
                $this->CellFitScale(25,5,$tiempo->tiempop_hora_fin,'LR',0,'L',$fill);
                $this->Ln();
                $fill = !$fill;
            }
            // Línea de cierre
            $this->Cell(286,0,'','T');
            $this->Ln(5);
        }

        $this->Output(sprintf('%s_%s_%s.pdf', 'tiempos_de_producción', date('Y_m_d'), date('H_m_s')),'I', true);
        exit;
    }
}
