
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
    $this->Cell(400, 2, utf8_decode("Ordenes de Trabajo"), 0, 0, 'C');
    $this->ln(4); 
    $this->Line(45,25,380,25);
      
  }

}



$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(5, 10 , 10);
$pdf->AddPage();


$pdf->SetFont('Arial','B',15);
$pdf->Cell(400,16,utf8_decode("REPORTE ORDEN DE PEDIDO PENDIENTE "),0,0,'C');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(5,10,"",0);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(6,10,utf8_decode("N°"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(20,10,"OP",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(17,10,"COD-ARTI.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(75,10,"CLIENTE",1,0,'C',1);
$pdf->Cell(200,10,"DESCRIPCION DEL ARTICULO",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

$pdf->Cell(18,10,utf8_decode("FEC-ING"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(10,10,"DIAS",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(20,10,"FEC-VENC",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,10,utf8_decode("CA. PEDI."),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(14,10,utf8_decode("PROD."),1,0,'C',1);
$pdf->Cell(12,10,"PEN.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

$pdf->Ln();
$pdf->SetFont('Arial','',6);
 $a= 0;

               
$pdf->Output();
?>
