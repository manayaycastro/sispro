
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
//    $this->Cell(400, 2, utf8_decode("Cumplimiento de entrega de las ordenes de Pedido"), 0, 0, 'C');
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
$pdf->Cell(400,16,utf8_decode("REPORTE - PROGRAMA DEL PROCESO DE TELARES, DESDE EL  ". "$ini". " AL ".$fin),0,0,'C');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(5,10,"",0);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(6,10,utf8_decode("N°"),1,0,'C',1);
$pdf->Cell(25,10,"FEC. PROGRAMA",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(25,10,"FEC. ENTREGA",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(22,10,"CODIGO",1,0,'C',1);
$pdf->Cell(50,10,"COLOR LAMINA",1,0,'C',1);
$pdf->Cell(220,10,"DESCRIPCION DEL ARTICULO",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

$pdf->Cell(28,10,utf8_decode("PEN-PROCE. ANTE"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(25,10,"PROGRAMADOS",1,0,'C',1);
$pdf->Cell(25,10,"ATENDIDO",1,0,'C',1);
$pdf->Cell(25,10,"PENDIENTE",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(25,10,utf8_decode("ANCHO"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(28,10,utf8_decode("LARGO DE CORTE"),1,0,'C',1);
$pdf->Cell(25,10,"PESO",1,0,'C',1);
$pdf->Cell(25,10,"CARGA LAMINA",1,0,'C',1);// SALDO DE 42


$pdf->Ln();
$pdf->SetFont('Arial','',7);

 $a = 0;
if($lista){
    
foreach ($lista as  $op) {
    $a= $a + 1;
    
    $cuerpo =[];
  $kanban = new kanban();
  $cuerpokanban = $kanban->cuerpokanban( $op['artsemi_id']);
   if ($cuerpokanban) {
            foreach ($cuerpokanban as $listacue) {
                $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
            }
    }
    
    $planificacion = new planificacion();
    $avance =$planificacion-> ProcAnter_ProcActual($procesos,$op['artsemi_id']);
    if($avance){
        foreach ($avance as $avan){
             $proc_actual_pen =$planificacion->ProcActual_Cant_Pendiente($op['numpedido'],$procesos);
             $proc_actual_aten =$planificacion->ProcActual_Cant_Atendido($op['numpedido'],$procesos);
             $proc_anterior_aten =$planificacion->ProcActual_Cant_Atendido($op['numpedido'],$avan['proceso_anterior']);
        }
    }
    $actual_pen=0;
    $actual_aten = 0;
    $anterior_aten = 0;
    
    if($proc_actual_pen){
        foreach($proc_actual_pen as $list){
            $actual_pen = $list['pendiente_proceso_actual'];
        }
    }
    
     if($proc_actual_aten){
        foreach($proc_actual_aten as $list){
            $actual_aten = $list['atendido_proceso_actual'];
        }
    }
    
     if($proc_anterior_aten){
        foreach($proc_anterior_aten as $list){
            $anterior_aten = $list['atendido_proceso_actual'];
        }
    }
    $pendiente_anterior = $anterior_aten - ($actual_pen + $actual_aten);
    $programados = ($actual_pen + $actual_aten);
//    $pdf->Cell(0,10, "",0);
/*
if($op->numreprog >= 1){
	$pdf->SetFillColor(2,157,116);
}else{
	$pdf->SetFillColor(201, 201, 201);
}
*/
$pdf->Cell(6,10,"$a",1,0,'C');
$pdf->Cell(25,10,$op['progpro_fecprogramacion'],1,0,'C');//fecha de PROGRAMA
$pdf->Cell(18,10,$op['numpedido'],1,0,'C'); //orden de pedido


$pdf->Cell(25,10,$op['fechaentrega'],1,0,'C');//fecha de entrega

$pdf->SetFont('Arial','',7);
$pdf->Cell(22,10,utf8_decode ($op['codart']),1,0,'C');//cod articulo
$pdf->Cell(50,10,utf8_decode ($cuerpo['25']),1,0,'C');//color lamina
$pdf->Cell(220,10,utf8_decode ($op['desart']) ." (".$op['artsemi_id'].")",1,0,'L'); //descripcion del articulo
$pdf->SetFont('Arial','',7);



        $pdf->Cell(28,10,$pendiente_anterior,1,0,'C'); //pendiente anterior 



$pdf->Cell(25,10,$programados,1,0,'C',1);//fecha de vencimiento
$pdf->Cell(25,10,$actual_aten,1,0,'C');//
$pdf->Cell(25,10,$actual_pen,1,0,'C',1); // 

$pdf->Cell(25,10,$cuerpo['11'],1,0,'C');//ancho del producto




$pdf->Cell(28,10,$cuerpo['48'],1,0,'C');//largo de corte
$pdf->Cell(25,10,$cuerpo['17'],1,0,'C'); //peso del producto
     

$pdf->Cell(25,10,$cuerpo['27'],1,0,'C');//carga de lamina


$ultimoing = new planificacion();

//$ultima_fecha = $ultimoing->fecultimoing($op['prodped_op']);


$pdf->Ln();
     
}

 }
 
                
$pdf->Output();
?>
