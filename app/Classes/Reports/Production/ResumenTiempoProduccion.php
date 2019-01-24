<?php

namespace App\Classes\Reports\Production;

use App\Classes\Reports\FPDF_CellFit;
use App\Models\Base\Empresa;

class ResumenTiempoProduccion extends FPDF_CellFit
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

    function table( $data ) {

        $a = 0;
        foreach ($data as $funcionario) {
            $this->SetFont('Arial','B',8);
            $this->Cell(287, 5, utf8_decode("$funcionario->tercero_nombre - $funcionario->tercero_nit"), 1, 0, 'C');
            $this->Ln();

            $this->Cell(112, 5, utf8_decode('SIN ORDEN DE PRODUCCIÓN'), 1, 0, 'C');
            $this->Cell(25, 5, '', 0, 0, 'C');
            $this->Cell(150, 5, utf8_decode('CON ORDEN DE PRODUCCIÓN'), 1, 0, 'C');
            $this->Ln();

            $this->Cell(43,5, 'ACTIVIDAD', 1);
            $this->Cell(43,5, 'SUBACTIVIDAD', 1);
            $this->Cell(26,5, 'TIEMPO (H.M)', 1, 0, 'C');
            $this->Cell(25,5, '', 0, 0, 'C');
            $this->Cell(50,5, 'ACTIVIDAD', 1);
            $this->Cell(50,5, 'SUBACTIVIDAD', 1);
            $this->Cell(25,5, 'TIEMPO (H.M)', 1, 0, 'C');
            $this->Cell(25,5, '# ORDENES', 1, 0, 'C');
            $this->Ln();

            $totalsegundos = 0;
            foreach ($funcionario->sinordenes as $sinorden) {
                $horas = floor($sinorden['time'] / 3600);
                $minutos = abs(floor(($sinorden['time'] - ($horas * 3600)) / 60));

                $this->SetFont('Arial', '', 7);
                $this->CellFitScale(43, 5, utf8_decode($sinorden['actividadp_nombre']), 1);
                $this->CellFitScale(43, 5, isset($sinorden['subactividadp_nombre']) ? utf8_decode($sinorden['subactividadp_nombre']) : '-', 1);
                $this->Cell(26, 5, "$horas.$minutos", 1, 0, 'C');
                $this->Ln();

                $totalsegundos += $sinorden['time'];
                $horas = $minutos = 0;
                $a += 5;
            }
            $horas = floor($totalsegundos / 3500);
            $minutos = abs(floor(($totalsegundos - ($horas * 3600)) / 60));
            $this->Cell(86, 5, '', 'TR', 0, 'C');
            $this->Cell(26, 5, "$horas.$minutos", 1, 0, 'C');

            $this->SetXY(142, $this->GetY()-$a);
            $totalsegundos = $totalordenes = $horas = $minutos = 0;
            foreach ($funcionario->conordenes as $conorden) {
                $horas = floor($conorden['time'] / 3600);
                $minutos = abs(floor(($conorden['time'] - ($horas * 3600)) / 60));

                $this->SetX(142);
                $this->SetFont('Arial','',7);
                $this->CellFitScale(50,5, utf8_decode($conorden['actividadp_nombre']), 1);
                $this->CellFitScale(50,5, isset($conorden['subactividadp_nombre']) ? utf8_decode($conorden['subactividadp_nombre']) : '-', 1);
                $this->Cell(25,5, "$horas.$minutos", 1, 0, 'C');
                $this->Cell(25,5, $conorden['ordenes'], 1, 0, 'C');
                $this->Ln();

                $totalsegundos += $conorden['time'];
                $totalordenes += $conorden['ordenes'];
            }
            $horas = $minutos = 0;
            $horas = floor($totalsegundos / 3600);
            $minutos = abs(floor(($totalsegundos - ($horas * 3600)) / 60));

            $this->SetX(142);
            $this->Cell(100, 5, '', 'TR', 0, 'C');
            $this->Cell(25, 5, "$horas.$minutos", 1, 0, 'C');
            $this->Cell(25, 5, $totalordenes, 1, 0, 'C');

            $this->SetXY(142, $this->GetY()+$a);
            $this->Ln(10);
            $a = 0;
        }

        $this->Output(sprintf('%s_%s.pdf', 'resumen_tiempos_de_producción', date('Y_m_d H_i_s')),'I', true);
        exit;
    }
}
