
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
    $this->Cell(400, 2, utf8_decode("Detalle de Producción"), 0, 0, 'C');
    $this->ln(4); 
    $this->Line(45,25,380,25);
      
  }

}

//420*297

$pdf=new PDF('L', 'mm', array(297.18,420));

//$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(5, 10 , 10);
$pdf->AddPage();


$pdf->SetFont('Arial','B',15);
$pdf->Cell(400,16,utf8_decode("REPORTE  DE PRODUCCIÓN DEL  ". "$ini". " AL ".$fin),0,0,'C');
$pdf->ln(15);
$pdf->SetFont('Arial','B',12);
$b=0;

$pdf->SetFillColor(2,157,116);
if($procesos == '167'){
	$pdf->Cell(401, 10, utf8_decode("TELARES"), 1, 0, 'C',1);
}elseif($procesos == '168'){
	$pdf->Cell(401, 10, utf8_decode("LAMINADO"), 1, 0, 'C',1);
	}elseif($procesos == '169'){
		$pdf->Cell(401, 10, utf8_decode("IMPRESIÓN"), 1, 0, 'C',1);
	}


$pdf->ln(15);

$pdf->SetFillColor(150,180,0);
$pdf->Cell(401,10,utf8_decode("Mañana"),1,0,'C',1);
$pdf->SetFont('Arial','B',8);
$pdf->ln(10);
for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){ 
	$b++;
	

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(15,10,utf8_decode($b),1,0,'C',1);
$pdf->Cell(20,10,"Hora",1,0,'C',1);

$pdf->Cell(18,10,"FECHA",1,0,'C',1);
$pdf->Cell(18,10,"Cod. Reg.",1,0,'C',1);
$pdf->Cell(18,10,"Rollo ID",1,0,'C',1);
$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->Cell(18,10,"Kanban",1,0,'C',1);
$pdf->Cell(18,10,"Metros",1,0,'C',1);
$pdf->Cell(18,10,"Peso",1,0,'C',1);
$pdf->Cell(18,10,"Operario",1,0,'C',1);
$pdf->Cell(67,10,"Maquina",1,0,'C',1);
$pdf->Cell(155,10,utf8_decode("Observación"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->ln(10);

$c=0;
$pdf->SetFont('Arial','',8);
// TURNO MAÑANA	
	if($lista_resumen){
		foreach ($lista_resumen as $lista){
			
			if($lista['fechaproduccion']==date("Y-m-d", $i) and $lista['Turno']== 'Mañana'){
				$c++;
				$pdf->Cell(15,10,utf8_decode($b).'.'.$c.' - M',1,0,'C',1);
				$pdf->Cell(20,10,$lista['horareg'],1,0,'C');	
				$pdf->Cell(18,10,$lista['fechaproduccion'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prorolldet_id'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['proroll_id'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prokandet_nroped'],1,0,'C',1); //orden de pedido
				$pdf->Cell(18,10,$lista['progpro_kanban'],1,0,'C',1); //orden de pedido
                                if($lista['movdismaq_proceso'] == '167' && $lista['prokandet_tipo']== 'parche' ){
                                    $pdf->Cell(18,10,round($lista['prorolldet_mtrs']/2,2),1,0,'C'); //orden de pedido
                                }else{
                                    $pdf->Cell(18,10,$lista['prorolldet_mtrs'],1,0,'C'); //orden de pedido
                                }
				//$pdf->Cell(18,10,$lista['prorolldet_mtrs'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prorolldet_peso'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prorolldet_operario'],1,0,'C'); //orden de pedido
				$pdf->Cell(67,10,$lista['maq_nombre'],1,0,'C'); //orden de pedido
				$pdf->Cell(155,10,utf8_decode ($lista['prorolldet_obs']),1,0,'L'); //orden de pedido
				$pdf->ln();
			}
			
		}
	
		
	}

	
	

$pdf->ln(15);
	
}

$pdf->addPage();



$pdf->SetFont('Arial','B',12);
$b=0;



$pdf->SetFillColor(150,180,0);
$pdf->Cell(401,10,utf8_decode("Tarde"),1,0,'C',1);
$pdf->SetFont('Arial','B',8);
$pdf->ln(10);



for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){ 
	$b++;
	

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(15,10,utf8_decode($b),1,0,'C',1);
$pdf->Cell(20,10,"Hora",1,0,'C',1);








$pdf->Cell(18,10,"FECHA",1,0,'C',1);
$pdf->Cell(18,10,"Cod. Reg.",1,0,'C',1);
$pdf->Cell(18,10,"Rollo ID",1,0,'C',1);
$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->Cell(18,10,"Kanban",1,0,'C',1);
$pdf->Cell(18,10,"Metros",1,0,'C',1);
$pdf->Cell(18,10,"Peso",1,0,'C',1);
$pdf->Cell(18,10,"Operario",1,0,'C',1);
$pdf->Cell(67,10,"Maquina",1,0,'C',1);
$pdf->Cell(155,10,utf8_decode("Observación"),1,0,'L',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->ln(10);

$c=0;
$pdf->SetFont('Arial','',8);
// TURNO MAÑANA	
	if($lista_resumen){
		foreach ($lista_resumen as $lista){
			
			if($lista['fechaproduccion']==date("Y-m-d", $i) and $lista['Turno']== 'Tarde'){
				$c++;
				$pdf->Cell(15,10,utf8_decode($b).'.'.$c.' - T',1,0,'C',1);
				$pdf->Cell(20,10,$lista['horareg'],1,0,'C');	
				$pdf->Cell(18,10,$lista['fechaproduccion'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prorolldet_id'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['proroll_id'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prokandet_nroped'],1,0,'C',1); //orden de pedido
				$pdf->Cell(18,10,$lista['progpro_kanban'],1,0,'C',1); //orden de pedido
				 if($lista['movdismaq_proceso'] == '167' && $lista['prokandet_tipo']== 'parche' ){
                                    $pdf->Cell(18,10,round($lista['prorolldet_mtrs']/2,2),1,0,'C'); //orden de pedido
                                }else{
                                    $pdf->Cell(18,10,$lista['prorolldet_mtrs'],1,0,'C'); //orden de pedido
                                }
				$pdf->Cell(18,10,$lista['prorolldet_peso'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prorolldet_operario'],1,0,'C'); //orden de pedido
				$pdf->Cell(67,10,$lista['maq_nombre'],1,0,'C'); //orden de pedido
				$pdf->Cell(155,10,utf8_decode ($lista['prorolldet_obs']),1,0,'L'); //orden de pedido
				$pdf->ln();
			}
			
		}
	
		
	}

	
	

$pdf->ln(15);
	
}

$pdf->addPage();
$pdf->SetFont('Arial','B',12);
$b=0;



$pdf->SetFillColor(150,180,0);
$pdf->Cell(401,10,utf8_decode("Noche"),1,0,'C',1);
$pdf->SetFont('Arial','B',8);
$pdf->ln(10);
for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){ 
	$b++;
	

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(15,10,utf8_decode($b),1,0,'C',1);
$pdf->Cell(20,10,"Hora",1,0,'C',1);


$pdf->Cell(18,10,"FECHA",1,0,'C',1);
$pdf->Cell(18,10,"Cod. Reg.",1,0,'C',1);
$pdf->Cell(18,10,"Rollo ID",1,0,'C',1);
$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->Cell(18,10,"Kanban",1,0,'C',1);
$pdf->Cell(18,10,"Metros",1,0,'C',1);
$pdf->Cell(18,10,"Peso",1,0,'C',1);
$pdf->Cell(18,10,"Operario",1,0,'C',1);
$pdf->Cell(67,10,"Maquina",1,0,'C',1);
$pdf->Cell(155,10,utf8_decode("Observación"),1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->ln(10);

$c=0;
$pdf->SetFont('Arial','',8);
// TURNO MAÑANA	
	if($lista_resumen){
		foreach ($lista_resumen as $lista){
			
			if($lista['fechaproduccion']==date("Y-m-d", $i) and $lista['Turno']== 'Noche'){
				$c++;
				$pdf->Cell(15,10,utf8_decode($b).'.'.$c.' - N',1,0,'C',1);
				$pdf->Cell(20,10,$lista['horareg'],1,0,'C');	
				$pdf->Cell(18,10,$lista['fechaproduccion'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prorolldet_id'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['proroll_id'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prokandet_nroped'],1,0,'C',1); //orden de pedido
				$pdf->Cell(18,10,$lista['progpro_kanban'],1,0,'C',1); //orden de pedido
				 if($lista['movdismaq_proceso'] == '167' && $lista['prokandet_tipo']== 'parche' ){
                                    $pdf->Cell(18,10,round($lista['prorolldet_mtrs']/2,2),1,0,'C'); //orden de pedido
                                }else{
                                    $pdf->Cell(18,10,$lista['prorolldet_mtrs'],1,0,'C'); //orden de pedido
                                }
				$pdf->Cell(18,10,$lista['prorolldet_peso'],1,0,'C'); //orden de pedido
				$pdf->Cell(18,10,$lista['prorolldet_operario'],1,0,'C'); //orden de pedido
				$pdf->Cell(67,10,$lista['maq_nombre'],1,0,'C'); //orden de pedido
				$pdf->Cell(155,10,utf8_decode ($lista['prorolldet_obs']),1,0,'L'); //orden de pedido
				$pdf->ln();
			}
			
		}
	
		
	}

	
	

$pdf->ln(15);
	
}






       
$pdf->Output();
?>
