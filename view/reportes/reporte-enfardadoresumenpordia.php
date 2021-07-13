
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
    $this->SetFont('Arial', 'B', 7.5);
    $this->Image("view/img/logo.png", null, 5, 30, 17);
    $this->Image("view/img/logo.png", 262, 5, 30, 17);
    $this->Cell(275,2, "EL AGUILA SRL", 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(275,1,  "DIR1: Av. Bolivar # 395 Moshoqueque - Chiclayo - Peru", 0, 0, 'C');
    $this->Ln(3);
    $this->Cell(275, 2,   "DIR1: Via Evitamiento  km 2.5 Sector Chacupe - La Victoria", 0, 0, 'C');
    $this->Ln(15);
    $this->SetFont('Arial','B',9);
    $this->Cell(275, 2, utf8_decode("PRODUCCION POR DIA"), 0, 0, 'C');
    $this->ln(4); 
    $this->Line(45,25,250,25);
      
  }

}



$pdf = new PDF('L', 'mm', 'A3');
//$pdf=new PDF('L', 'mm', array(297.18,559.1));
$pdf->SetMargins(5, 10 , 10);
$pdf->AddPage();


$pdf->SetFont('Arial','B',15);
$pdf->Cell(275,16,utf8_decode("REPORTE RESUMEN DE ENFARDADO - RESUMEN - DEL DIA ").$rango,0,0,'C');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(5,10,"",0);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(5,10,utf8_decode("N°"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,10,"FEC.",1,0,'C',1);
$pdf->Cell(25,10,"OP",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(20,10,"TIPO",1,0,'C',1);
$pdf->Cell(20,10,"COD-ARTI.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->SetFont('Arial','',8);
//$pdf->Cell(150,10,"CLIENTE",1,0,'C',1);
$pdf->Cell(240,10,"DESCRIPCION DEL ARTICULO",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(10,10,"P.",1,0,'C',1);

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(15,10,utf8_decode("Can. Pedi"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(15,10,utf8_decode("Cant. Aten."),1,0,'C',1);

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(17,10,"CANT.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,10,"Peso.",1,0,'C',1);

$pdf->Ln();
$pdf->SetFont('Arial','',8);



$inicio = '';
$fin = '';


$cantidad_total = '0';
$peso_total = '0';


 $optemp= '';

 
 $a=0;
 
if($lista_resumen){
    
foreach ($lista_resumen as  $produccion) {
    $a= $a + 1;
//    $pdf->Cell(0,10, "",0);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(5,10,"$a",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,10,$produccion['fechaproduccion'],1,0,'C');
$pdf->Cell(25,10,$produccion['numop'],1,0,'C');
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(20,10,$produccion['tipo'],1,0,'C');
$pdf->Cell(20,10,$produccion['codigofin'],1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(201, 201, 201);
//$pdf->Cell(150,10,utf8_decode("$produccion->nomb"),1,0,'L');
$pdf->Cell(240,10,utf8_decode($produccion['descripcionfin']),1,0,'L');
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(10,10,utf8_decode(ROUND($produccion['peso_producto']))."",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

$pdf->Cell(15,10,utf8_decode($produccion['cantped']),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(15,10,utf8_decode(ROUND($produccion['sumcantidad'])),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);




$pdf->Cell(17,10,$produccion['sumcantidad_par'],1,0,'C');

$cantidad_total = $cantidad_total + $produccion['sumcantidad_par'];
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,10,utf8_decode($produccion['sumpeso_par']),1,0,'C');
$peso_total= $peso_total + $produccion['sumpeso_par'];

$pdf->Ln(10);
     
}

 }
 
// $pdf->Cell(5,10,"",0);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(370,10,utf8_decode("Totales"),1,0,'C',1);


$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(17,10,"$cantidad_total"." Und",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,10,"$peso_total"." Kg.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

 
 


                
$pdf->Output();
?>
