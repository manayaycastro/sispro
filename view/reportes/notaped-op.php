
<?php

require 'view/fpdf17/fpdf.php';
include 'view/barcode.php';
$meses = array('01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO'
    , '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');

class PDF extends FPDF {

    function Footer() {
        // To be implemented in your own inherited class
        //$this->Ln(2);
        $this->SetY(-15);
      
    
     $this->Ln(); //no texto 
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(330, 10, utf8_decode("Fecha de creación: ") . date("d-m-Y H:i") . "             " . "Pag " . $this->PageNo(), 0, 0, 'C');
    }

    function Header() {
        // To be implemented in your own inherited class
        //$this->Ln(2);
        $this->SetFont('Arial', '', 10);
//    $this->Image("view/img/logo.png",5, 5, 15, 10);
//    $this->Image("view/img/logo.png", 190, 5, 15, 10);
    }

}

$pdf = new PDF('L');
$pdf->AddPage();

if ($opedidos) {
    foreach ($opedidos as $opedido) {

        $pdf->SetFont('Arial', 'B', 15);
         $pdf->Cell(55, 4, "", 0, 0,'C');
        $pdf->Cell(60, 4, "NOTA DE PEDIDO", 0, 0,'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 4, $opedido['NROPED'], 0, 0,'R');
      
        $pdf->Cell(26, 4, " 1 de 1", 0, 0,'R');
        $pdf->ln(12);
        $pdf->Cell(27, 4, "Fecha Pedido ", 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $date_fecped = date_create($opedido['FECPED']);
          $pdf->Cell(20, 4,  date_format($date_fecped,'d/m/Y'), 0, 0, 'L');
           $pdf->Cell(50, 4, "", 0, 0, 'L');
           
           $pdf->Cell(50, 4, "Fecha/ Hora de Registro ", 0, 0);
            $pdf->Cell(2, 4, ": ", 0, 0);
            $date_origen = date_create($opedido['fecori']);
            $pdf->Cell(27, 4, date_format($date_origen,'d/m/Y'), 0, 0);
      
        $pdf->Cell(20, 4, date_format($date_origen,'G:i'), 0, 0);
        $pdf->ln(6);
        $pdf->Cell(27, 4, "Clte. Principal ", 0, 0);
         $pdf->Cell(2, 4, ": ", 0, 0);
           $pdf->Cell(50, 4,  $opedido['clteprincipal'], 0, 0, 'L');
           
           $pdf->ln(6);
        $pdf->Cell(27, 4, "Clte. Segundario ", 0, 0);
         $pdf->Cell(2, 4, ": ", 0, 0);
           $pdf->Cell(50, 4,  $opedido['cltesegundario'], 0, 0, 'L');
           
            $pdf->ln(6);
        $pdf->Cell(27, 4, utf8_decode( "Observación "), 0, 0);
         $pdf->Cell(2, 4, ": ", 0, 0);
           $pdf->MultiCell(160, 4,  $opedido['observacion'], 0);
     
            
            $pdf->ln();
      $pdf->Cell(190, 5,"", 'B', 0);
       $pdf->ln();
      $pdf->Cell(20, 5,"CANTIDAD", 'B', 0);
      $pdf->Cell(10, 5,"UM", 'B', 0);
      $pdf->Cell(90, 5,utf8_decode ("ARTÌCULO"), 'B', 0,'C');
       $pdf->Cell(20, 5,"PRECIO", 'B', 0);
        $pdf->Cell(20, 5,"IMPORTE", 'B', 0);
         $pdf->Cell(30, 5,"PRECIO/KILO", 'B', 0);
         
          $pdf->ln();
          $pdf->SetFont('Arial', '', 9);
      $pdf->Cell(20, 5,  round( $opedido['CANTPED']), 0, 0);
      $pdf->Cell(10, 5, $opedido['UM'], 0, 0);
      $pdf->MultiCell(90, 5, $opedido['DESART'],  0);
       $pdf->Setx(90); 
          $pdf->SetY(78);
           $pdf->Cell(120, 4, "", 0, 0);
       $pdf->Cell(20, 5,  round( $opedido['PRE_UNI_SIN_IGV'],4), 0, 0);
        $pdf->Cell(20, 5, round( $opedido['PRE_TOT_SIN_IGV'],4), 0, 0,'R');
         $pdf->Cell(30, 5,  round( $opedido['PESO_KILO'],4), 0, 0);
         
          $pdf->ln(80);
           
      $pdf->Cell(140, 5,"", 'B', 0);
       $pdf->ln();
      $pdf->Cell(140, 5,"IGV", 'B', 0,'R');
       $pdf->Cell(20, 5, round( $opedido['IGV'],4), 0, 0,'R');
       $pdf->ln();
      $pdf->Cell(140, 5,  utf8_decode( "OPERACIÒN GRAVADA"), 'B', 0,'R');
       $pdf->Cell(20, 5, round( $opedido['PRE_TOT_SIN_IGV'],4), 0, 0,'R');
       $pdf->ln();
      $pdf->Cell(140, 5,  utf8_decode( "TOTAL"), 0, 0,'R');
      $pdf->Cell(20, 5, round( $opedido['IMPTOTAL'],4), 0, 0,'R');
      
       $pdf->ln(10);
      $pdf->Cell(140, 5,  utf8_decode( $opedido['DESCONPAG']), 0, 0,'R');
       $pdf->Cell(15, 5,  utf8_decode( ""), 0, 0,'R');
      $pdf->Cell(10, 5,  utf8_decode( "HORA"), 0, 0,'R');
      
       $pdf->Cell(15, 5,  date("H:i:s"), 0, 0,'R');
      
            
    }
}



$pdf->Output();
?>
