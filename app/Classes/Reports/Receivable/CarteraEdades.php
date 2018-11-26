<?php

namespace App\Classes\Reports\Receivable;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use Auth;

class CarteraEdades extends FPDF
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
        $this->Cell(420,5,utf8_decode($empresa->tercero_razonsocial),0,0,'C');
		$this->SetXY(75,17);
		$this->SetFont('Arial','B',8);
        $this->Cell(270,5,"NIT: $empresa->tercero_nit",0,0,'C');
		$this->Line(10,22,410,22);
		$this->SetXY(85,23);
        $this->Cell(250, 5, utf8_decode($this->metadata['Title']), 0, 0,'C');
        $this->Ln(5);
        $this->headerTable();
    }

    function headerTable() {
        $this->SetFont('Arial','B',7);
        $this->Cell(129,5,'',1);
        $this->Cell(120,5,'MORA',1,0,'C');
        $this->Cell(120,5,'POR VENCER',1,0,'C');
        $this->Cell(40,5,'TOTALES',1,0,'C');
        $this->Ln();
        $this->Cell(90,5,'CLIENTE',1);
        $this->Cell(12,5,'PREFIJO',1);
        $this->Cell(15,5,utf8_decode('NÚMERO'),1);
        $this->Cell(12,5,'CUOTA',1);
        $this->Cell(20,5,utf8_decode('> 360'),1);
        $this->Cell(20,5,utf8_decode('>180 Y <= 360'),1);
        $this->Cell(20,5,utf8_decode('> 90 Y <= 180'),1);
        $this->Cell(20,5,utf8_decode('> 60 Y <= 90'),1);
        $this->Cell(20,5,utf8_decode('> 30 Y <= 60'),1);
        $this->Cell(20,5,utf8_decode('> 0 Y <= 30'),1);
        $this->Cell(20,5,utf8_decode('DE 0 A 30'),1);
        $this->Cell(20,5,utf8_decode('DE 31 A 60'),1);
        $this->Cell(20,5,utf8_decode('DE 61 A 90'),1);
        $this->Cell(20,5,utf8_decode('DE 91 A 180'),1);
        $this->Cell(20,5,utf8_decode('DE 181 A 360'),1);
        $this->Cell(20,5,utf8_decode('> 360'),1);
        $this->Cell(20,5,utf8_decode('MORA'),1);
        $this->Cell(20,5,utf8_decode('POR VENCER'),1);
        $this->Ln();
    }

    function Footer() {
        $user = utf8_decode(Auth::user()->username);
        $date = date('Y-m-d H:m:s');

        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Pág ').$this->PageNo().'/{nb}',0,0,'L');
        $this->Cell(0,10,"Usuario: $user - Fecha: $date",0,0,'R');
    }

    function bodyTable($data) {
        $fill = false;
        $this->SetFillColor(247,247,247);
        $menor360 = $menor180 = $menor90 = $menor60 = $menor30 = $menor0 = $mayor0 = $mayor31 = $mayor61 = $mayor91 = $mayor181 = $mayor360 = $totalfinalmora = $totalfinalvencer = 0;
        foreach($data as $item){
            $totalmora = $totalvencer = 0;
            $this->SetFont('Arial', '', 7);
            $fill = !$fill;
            $this->Cell(90,5,"$item->tercero_nit -  $item->tercero_nombre",'', 0, '', $fill);
            $this->Cell(12,5,"$item->factura1_prefijo",'', 0, '', $fill);
            $this->Cell(15,5,"$item->factura1_numero",'', 0, '', $fill);
            $this->Cell(12,5,"$item->factura4_cuota",'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days < -360 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days >= -360 && $item->days <= -180 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days >= -180 && $item->days <= -90 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days >= -90 && $item->days <= -60 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days >= -60 && $item->days <= -30 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days >= -30 && $item->days <= 0 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days > 0 && $item->days <= 30 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days > 31 && $item->days <= 60 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days > 61 && $item->days <= 90 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days > 91 && $item->days <= 180 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days > 181 && $item->days <= 360 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days > 360 ? $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days < 0 ? $totalmora += $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);
            $this->Cell(20,5, number_format( $item->days > 0 ? $totalvencer += $item->factura4_saldo : 0, 2, ',', '.'),'', 0, '', $fill);

            // Sumar columnas y filas
            if( $item->days < -360 ){
                $menor360 += $item->factura4_saldo;
            }else if( $item->days >= -360 && $item->days <= -180 ){
                $menor180 += $item->factura4_saldo;
            }else if( $item->days >= -180 && $item->days <= -90 ){
                $menor90 += $item->factura4_saldo;
            }else if( $item->days >= -90 && $item->days <= -60 ){
                $menor60 += $item->factura4_saldo;
            }else if( $item->days >= -60 && $item->days <= -30 ){
                $menor30 += $item->factura4_saldo;
            }else if( $item->days >= -30 && $item->days <= 0 ){
                $menor0 += $item->factura4_saldo;
            }else if( $item->days > 0 && $item->days <= 30 ){
                $mayor0 += $item->factura4_saldo;
            }else if( $item->days > 31 && $item->days <= 60 ){
                $mayor31 += $item->factura4_saldo;
            }else if( $item->days > 61 && $item->days <= 90 ){
                $mayor61 += $item->factura4_saldo;
            }else if( $item->days > 91 && $item->days <= 180 ){
                $mayor91 += $item->factura4_saldo;
            }else if( $item->days > 181 && $item->days <= 360 ){
                $mayor181 += $item->factura4_saldo;
            }else if( $item->days > 360 ){
                $mayor360 += $item->factura4_saldo;
            }
            $totalfinalmora += $totalmora;
            $totalfinalvencer += $totalvencer;
            $this->Ln();
        }

        $this->SetFillColor(187,166,161);
        $this->SetFont('Arial','B',7);
        $this->Cell(129,5,'TOTAL',1,0,'R',1);
        $this->Cell(20,5, number_format($menor360, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($menor180, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($menor90, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($menor60, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($menor30, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($menor0, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($mayor0, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($mayor31, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($mayor61, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($mayor91, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($mayor181, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($mayor360, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($totalfinalmora, 2, ',', '.'),1,0,'L',1);
        $this->Cell(20,5, number_format($totalfinalvencer, 2, ',', '.'),1,0,'L',1);
        $this->Ln();

        $this->Output('d',sprintf('%s_%s_%s.pdf', 'estado_cartera', date('Y_m_d'), date('H_m_s')));
    }

    function totalSaldo($tsaldo) {
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(240,5,'Total',0,0,'R');
        $this->Cell(30,5,number_format ($tsaldo,2,',' , '.'),0,0,'R');
        $this->Ln();
    }
}
