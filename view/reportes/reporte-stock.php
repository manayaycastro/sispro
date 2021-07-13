
<?php
require 'view/fpdf17/fpdf.php';
$meses = array('01' => 'ENERO','02' => 'FEBRERO','03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO'
  ,'07' => 'JULIO','08' => 'AGOSTO','09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE','12' => 'DICIEMBRE');


class PDF extends FPDF{

function Footer()
  {
    // To be implemented in your own inherited class
    //$this->Ln(2);
    $this->SetY(-12);
    $this->SetFont('Arial','B',5);      
    $this->Cell(505,10,utf8_decode("TI. Fecha de creación: ").date("d-m-Y H:i")."             "."Pag ".$this->PageNo(),0,0,'C');    
  }

  function Header()  {
    // To be implemented in your own inherited class
    //$this->Ln(2);
             date_default_timezone_set('America/Lima');
   $this->SetFont('Arial', 'B', 7.5);
    $this->Image("view/img/logo.png", null, 5, 20, 15);
    $this->Image("view/img/logo.png", 385, 5, 20, 15);
    $this->Cell(400,2, "EL AGUILA SRL", 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(400,1,  "DIR1: Av. Bolivar # 395 Moshoqueque - Chiclayo - Peru", 0, 0, 'C');
    $this->Ln(3);
    $this->Cell(400, 2,   "DIR1: Via Evitamiento  km 2.5 Sector Chacupe - La Victoria", 0, 0, 'C');
    $this->Ln(15);
    $this->SetFont('Arial','B',9);
    $this->Cell(400, 2, utf8_decode("Reporte Stock"), 0, 0, 'C');
    $this->ln(4); 
    $this->Line(45,25,380,25);
      
  }

}



$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(5, 10 , 10);
$pdf->AddPage();


$pdf->SetFont('Arial','B',15);
$pdf->Cell(400,16,utf8_decode("REPORTE DE STOCK  AL ")." ".$fecha,0,0,'C');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(2,157,116);

$pdf->Cell(15,10,utf8_decode("N°"),1,0,'C',1);
$pdf->Cell(20,10,"CODIGO",1,0,'C',1);
$pdf->Cell(280,10,utf8_decode("DESCRIPCIÓN"),1,0,'C',1);
$pdf->Cell(30,10,"STOCK ENVASE",1,0,'C',1);
$pdf->Cell(30,10,"STOCK BOBINA",1,0,'C',1);
$pdf->Cell(30,10,utf8_decode("STOCK KILOS"),1,0,'C',1);


$pdf->Ln();
$pdf->SetFont('Arial','',8);
 $a= 0;
 $totenvases= 0;
 $totbobinas= 0;
 $totpeso= 0;
$pdf->SetFillColor(201, 201, 201);
 if($lista){
     foreach ($lista as $list){
         $a++;
         if($a %2 == 0){
             $pdf->Cell(15,7,$a,1,0,'C',1);
              $pdf->Cell(20,7,utf8_decode($list["artsemi_id"]),1,0,'C',1);
               $pdf->Cell(280,7,"  ".utf8_decode($list["artsemi_descripcion"]),1,0,'L',1);
                $pdf->Cell(30,7,utf8_decode($list["artlot_cajfinal"]),1,0,'C',1);
                 $pdf->Cell(30,7,utf8_decode($list["artlot_bobfinal"]),1,0,'C',1);
                  $pdf->Cell(30,7,utf8_decode($list["stock"]),1,0,'C',1);
$totenvases= $totenvases + $list["artlot_cajfinal"];
 $totbobinas= $totbobinas + $list["artlot_bobfinal"];
 $totpeso= $totpeso  + $list["stock"];
             $pdf->Ln();
         }else{
             $pdf->Cell(15,7,$a,1,0,'C');
              $pdf->Cell(20,7,utf8_decode($list["artsemi_id"]),1,0,'C');
               $pdf->Cell(280,7,"  ".utf8_decode($list["artsemi_descripcion"]),1,0,'L');
                $pdf->Cell(30,7,utf8_decode($list["artlot_cajfinal"]),1,0,'C');
                 $pdf->Cell(30,7,utf8_decode($list["artlot_bobfinal"]),1,0,'C');
                  $pdf->Cell(30,7,utf8_decode($list["stock"]),1,0,'C');
 $totenvases= $totenvases + $list["artlot_cajfinal"];
 $totbobinas= $totbobinas + $list["artlot_bobfinal"];
 $totpeso= $totpeso  + $list["stock"];                 
                  
             $pdf->Ln();
         }
     }
 }
 $pdf->SetFillColor(2,157,116);

  $pdf->Cell(315,7," Totales ",1,0,'R',1);
                $pdf->Cell(30,7,$totenvases,1,0,'C',1);
                 $pdf->Cell(30,7,$totbobinas,1,0,'C',1);
                  $pdf->Cell(30,7,$totpeso,1,0,'C',1);
               
$pdf->Output();
?>
