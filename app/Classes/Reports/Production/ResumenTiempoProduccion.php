<?php

namespace App\Classes\Reports\Production;

use App\Classes\Reports\FPDF_CellFit;
use App\Models\Base\Empresa;

class ResumenTiempoProduccion extends FPDF_CellFit
{
    private $title;
    private $data;

    function buldReport($sin, $con, $title) {
        $this->title = $title;

        $this->SetMargins(5,5,5);
        $this->SetTitle($this->title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->table( $sin, $con );
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

    function table( $sin, $con ) {
        $this->SetFont('Arial','B',8);
        $this->Cell(282,5,utf8_decode('SIN ORDENES DE PRODUCCIÓN'),1, 0, 'C');
        $this->Ln();
        $this->Cell(90,5,'FUNCIONARIO',1);
        $this->Cell(32,5,'NIT',1);
        $this->Cell(60,5,'ACTIVIDAD',1);
        $this->Cell(60,5,'SUBACTIVIDAD',1);
        $this->Cell(40,5,'TIEMPO (H.M)',1);
        $this->Ln();

        $fill = false;
        $whitouttiempo = $totalsegundos = 0;
        foreach ($sin as $funcionario) {
            $horas = floor($funcionario->time / 3600);
            $minutos = floor(($funcionario->time - ($horas * 3600)) / 60);

            $this->SetFont('Arial','',7);
            $this->CellFitScale(90, 5,utf8_decode($funcionario->tercero_nombre), 'LR', 0, 'L');
            $this->Cell(32,5,$funcionario->tercero_nit,'LR', 0, 'L');
            $this->CellFitScale(60,5,utf8_decode($funcionario->actividadp_nombre), 'LR', 0, 'L', $fill);
            $this->CellFitScale(60,5,isset($funcionario->subactividadp_nombre) ? utf8_decode($funcionario->subactividadp_nombre) : '-', 'LR', 0, 'L', $fill);
            $this->Cell(40,5,"$horas.$minutos", 'LR', 0, 'C', $fill);
            $this->Ln();

            $totalsegundos += $funcionario->time;
        }

        $thoras = floor($totalsegundos / 3600);
        $tminutos = floor(($totalsegundos - ($thoras * 3600)) / 60);

        $this->SetFont('Arial','B',8);
        $this->Cell(242,5,utf8_decode(''),'TR', 0, 'C');
        $this->Cell(40,5,"$thoras.$tminutos",1, 0, 'C');
        $this->Ln();

        // Línea de cierre
        $this->Cell(282,0,'','T');
        $this->Ln(20);

        $this->SetFont('Arial','B',8);
        $this->Cell(282,5,utf8_decode('CON ORDENES DE PRODUCCIÓN'),1, 0, 'C');
        $this->Ln();

        $this->Cell(90,5,'FUNCIONARIO',1);
        $this->Cell(32,5,'NIT',1);
        $this->Cell(60,5,'ACTIVIDAD',1);
        $this->Cell(60,5,'SUBACTIVIDAD',1);
        $this->Cell(20,5,'TIEMPO (H.M)',1);
        $this->Cell(20,5,'# ORDENES',1);
        $this->Ln();

        $fill = false;
        $whittiempo = $whitordenes = $totalsegundos = 0;
        foreach ($con as $funcionario) {
            $horas = floor($funcionario->time / 3600);
            $minutos = floor(($funcionario->time - ($horas * 3600)) / 60);

            $this->SetFont('Arial','',7);
            $this->CellFitScale(90, 5,utf8_decode($funcionario->tercero_nombre), 'LR', 0, 'L');
            $this->Cell(32,5,$funcionario->tercero_nit,'LR', 0, 'L');
            $this->CellFitScale(60,5,utf8_decode($funcionario->actividadp_nombre), 'LR', 0, 'L', $fill);
            $this->CellFitScale(60,5,isset($funcionario->subactividadp_nombre) ? utf8_decode($funcionario->subactividadp_nombre) : '-', 'LR', 0, 'L', $fill);
            $this->Cell(20,5,"$horas.$minutos", 'LR', 0, 'C', $fill);
            $this->Cell(20,5,$funcionario->ordenes, 'LR', 0, 'C', $fill);
            $this->Ln();

            $totalsegundos += $funcionario->time;
            $whitordenes += $funcionario->ordenes;
        }

        $thoras = floor($totalsegundos / 3600);
        $tminutos = floor(($totalsegundos - ($thoras * 3600)) / 60);

        $this->SetFont('Arial','B',8);
        $this->Cell(242,5,utf8_decode(''),'TR', 0, 'C');
        $this->Cell(20,5,"$thoras.$tminutos",1, 0, 'C');
        $this->Cell(20,5,$whitordenes,1, 0, 'C');
        $this->Ln();

        $this->Output(sprintf('%s_%s.pdf', 'resumen_tiempos_de_producción', date('Y_m_d H_m_s')),'I', true);
        exit;
    }
}
