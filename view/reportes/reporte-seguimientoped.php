
<?php
require 'view/fpdf17/fpdf.php';
$meses = array('01' => 'ENERO','02' => 'FEBRERO','03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO'
  ,'07' => 'JULIO','08' => 'AGOSTO','09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE','12' => 'DICIEMBRE');


class PDF extends FPDF{

function Footer()
  {
    // To be implemented in your own inherited class
    $this->SetY(-12);
    $this->SetFont('Arial','B',5);      
    $this->Cell(505,10,utf8_decode("TI. Fecha de creación: ").date("d-m-Y H:i")."             "."Pag ".$this->PageNo(),0,0,'C');    
   }

  function Header()  {
    // To be implemented in your own inherited class
    //$this->Ln(2);
             date_default_timezone_set('America/Lima');
     $this->SetFont('Arial', 'B', 7.5);
    $this->Image("view/img/logo.png", null, 5, 22, 17);
    $this->Image("view/img/logo.png", 385, 5, 20, 20);
    $this->Cell(400,2, "EL AGUILA SRL", 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(400,1,  "DIR1: Av. Bolivar # 395 Moshoqueque - Chiclayo - Peru", 0, 0, 'C');
    $this->Ln(3);
    $this->Cell(400, 2,   "DIR1: Via Evitamiento  km 2.5 Sector Chacupe - La Victoria", 0, 0, 'C');
    $this->Ln(15);
    $this->SetFont('Arial','B',9);
    $this->Cell(400, 2, utf8_decode("Cumplimiento de entrega de las ordenes de Pedido"), 0, 0, 'C');
    $this->ln(4); 
    $this->Line(45,25,380,25);
      
  }

}

//420*297

$pdf=new PDF('L', 'mm', array(297.18,630.1));

//$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(5, 10 , 10);
$pdf->AddPage();


$pdf->SetFont('Arial','B',15);
$pdf->Cell(400,16,utf8_decode("REPORTE ORDEN DE PEDIDO - VENCIERON DESDE EL  ". "$ini". " AL ".$fin),0,0,'C');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(5,10,"",0);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(6,10,utf8_decode("N°"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(12,10,"COD.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(100,10,"CLIENTE",1,0,'C',1);
$pdf->Cell(100,10,"VENDEDOR",1,0,'C',1);
$pdf->Cell(220,10,"DESCRIPCION DEL ARTICULO",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

$pdf->Cell(16,10,utf8_decode("FEC-ING"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(16,10,"FEC-VENC",1,0,'C',1);
$pdf->Cell(10,10,"REP.",1,0,'C',1);
$pdf->Cell(16,10,"NUE-VENC",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(16,10,utf8_decode("CA.PEDI."),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(14,10,utf8_decode("PROD.(A)"),1,0,'C',1);
$pdf->Cell(20,10,"PROD.(B)",1,0,'C',1);
$pdf->Cell(12,10,"PEN.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(17,10,"U. Fecha",1,0,'C',1);
$pdf->Cell(5,10,"E.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);


$pdf->Cell(20,10,"% -> B/A",1,0,'C',1);
$pdf->Ln();
$pdf->SetFont('Arial','',7);

 $a = 0;
if($lista_resumen){
    
foreach ($lista_resumen as  $op) {
    $a= $a + 1;
//    $pdf->Cell(0,10, "",0);
/*
if($op->numreprog >= 1){
	$pdf->SetFillColor(2,157,116);
}else{
	$pdf->SetFillColor(201, 201, 201);
}
*/
$pdf->Cell(6,10,"$a",1,0,'C');

$pdf->Cell(18,10,$op['prodped_op'],1,0,'C'); //orden de pedido


$pdf->Cell(12,10,$op['codart'],1,0,'C');//codigo de articulo

$pdf->SetFont('Arial','',7);
$pdf->Cell(100,10,utf8_decode ($op['cliente']),1,0,'C');//nombre del cliente
$pdf->Cell(100,10,utf8_decode ($op['vendedor']),1,0,'C');//nombre del VENDEDOR
$pdf->Cell(220,10,utf8_decode ($op['desart']),1,0,'C'); //descripcion del articulo
$pdf->SetFont('Arial','',7);

$pdf->Cell(16,10,$op['entrega'],1,0,'C'); //fecha de ingreso 



$pdf->Cell(16,10,$op['vencimiento'],1,0,'C',1);//fecha de vencimiento
$pdf->Cell(10,10,"",1,0,'C');//num de reprogramaciones
$pdf->Cell(16,10,"",1,0,'C',1); // fecha de venc final
$cantped = round($op['cantped'],2); //cantidad pedida
$pdf->Cell(16,10,"$cantped",1,0,'C');




$pdf->Cell(14,10,$op['cantidada'],1,0,'C');//cantidad producida a
$pdf->Cell(20,10,$op['cantidadb'],1,0,'C'); //cantidad de sacos b
      $diferencia = $op['cantped'] - $op['cantidada'];

$pdf->Cell(12,10,"$diferencia",1,0,'C');//cantidad pendiente en clase a


$ultimoing = new planificacion();

$ultima_fecha = $ultimoing->fecultimoing($op['prodped_op']);

if($ultima_fecha){
    
foreach ($ultima_fecha as  $ultima) {
    
    
    $pdf->Cell(17,10,$ultima['ultimafecha'],1,0,'C'); //ultimo fardo ingresado
}
}else{
      $pdf->Cell(17,10,"",1,0,'C'); //ultimo fardo ingresado
}


$pdf->Cell(5,10,$op['prodped_estado'],1,0,'C'); // estado de ordenes de pedido




$pdf->Cell(20,10,round ($op['porcentaje'],2)." %",1,0,'C',1);// porcentaje de clase b en relacion a clase a
$pdf->Ln();
     
}

 }
 
                
$pdf->Output();
?>
