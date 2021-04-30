<?php

namespace App\Classes\Reports\Accounting;

use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;

class BalanceGeneral extends FPDF
{
    function buldReport ($data, $title) {
        $this->SetMargins(5, 5, 5);
        $this->SetTitle($title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->bodyTable($data);
    }

    function Header () {
        $empresa = Empresa::getEmpresa();
        $this->SetXY(0, 10);
		$this->SetFont('Arial', 'B', 13);
        $this->Cell(280, 5, utf8_decode($empresa->tercero_razonsocial), 0, 0, 'C');
		$this->SetXY(75, 17);
		$this->SetFont('Arial', 'B', 10);
        $this->Cell(130, 5, "NIT: $empresa->tercero_nit", 0, 0, 'C');
		$this->Line(10, 22, 270, 22);;
		$this->SetXY(85, 23);
        $this->Cell(115, 5, $this->metadata['Title'], 0, 0, 'C');
        $this->Ln(5);
        $this->headerTable();
    }

    function Footer () {
        $user = utf8_decode(auth()->user()->username);
        $date = date('Y-m-d H:i:s');

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Pág ').$this->PageNo().'/{nb}', 0, 0, 'L');
        $this->Cell(0, 10, "Usuario: $user - Fecha: $date", 0, 0, 'R');
    }

    function headerTable () {
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(20, 4, 'Cuenta', 1, 0, 'C');
        $this->Cell(120, 4, 'Nombre', 1);
        $this->Cell(32, 4, 'Inicial', 1);
        $this->Cell(32, 4, utf8_decode('Débito'), 1);
        $this->Cell(32, 4, utf8_decode('Crédito'), 1);
        $this->Cell(32, 4, 'Final', 1);
        $this->Ln();
    }

    function bodyTable ($data) {
        $fill = false;
        $this->SetFillColor(247, 247, 247);
        $this->SetFont('Arial', '', 8);
        $lastNivel = $saldoDebito = $saldoCredito = $totalFinal = $totalInicio = 0;
        foreach ($data as $saldo) {
            if (($saldo->plancuentas_nivel == 3 && $lastNivel != 2) || ($saldo->plancuentas_nivel == 2 && $lastNivel > 3)) {
                $this->Ln();
            }

            if ($saldo->plancuentas_nivel <= 2) {
                $this->SetFont('Arial', 'B', 8);
            }
            $this->Cell(20, 4, $saldo->plancuentas_cuenta, 0, 0, 'R', $fill);
            $this->SetFont('Arial', '', 8);
            $this->Cell(120, 4, utf8_decode($saldo->plancuentas_nombre), 0, 0, 'L', $fill);
            $this->Cell(32, 4, number_format($saldo->inicial, 2, '.', ','), 0, 0, 'R', $fill);
            $this->Cell(32, 4, number_format($saldo->debitomes, 2, '.', ','), 0, 0, 'R', $fill);
            $this->Cell(32, 4, number_format($saldo->creditomes, 2, '.', ','), 0, 0, 'R', $fill);

            // Calculo final
            if ($saldo->plancuentas_naturaleza == 'D') {
                $final = $saldo->inicial + ($saldo->debitomes - $saldo->creditomes);
            } else if ($saldo->plancuentas_naturaleza == 'C') {
                $final = $saldo->inicial + ($saldo->creditomes - $saldo->debitomes);
            }

            // Pinto final
            $this->Cell(32, 4, number_format($final, 2, '.', ','), '', 0, 'R', $fill);
            $this->Ln();

            $fill = !$fill;
            $lastNivel = $saldo->plancuentas_nivel;

            // Calculo totales
            if ($saldo->plancuentas_nivel == 1) {
                $saldoDebito = $saldo->debitomes + $saldoDebito;
                $saldoCredito = $saldo->creditomes + $saldoCredito;
                $totalFinal += $final;
                $totalInicio += $saldo->inicial;
            }
        }

        $this->Output(sprintf('%s_%s.pdf', 'balance_general', date('Y_m_d H_i_s')), 'D');
    }
}
