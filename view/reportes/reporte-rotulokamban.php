<?php

require 'view/fpdf17/fpdf.php';
$meses = array('01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO'
    , '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');
  ini_set('date.timezone','America/Lima'); 
class PDF extends FPDF {

    function Footer() {
        // To be implemented in your own inherited class
        //$this->Ln(2);
        $this->SetY(-12);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(300, 10, utf8_decode("TEC.INF. Fecha de creación: ") . date("d-m-Y H:i") . "             " . "Pag " . $this->PageNo(), 0, 0, 'C');
    }

    function Header() {
        // To be implemented in your own inherited class
        //$this->Ln(2);
        
       date_default_timezone_set('America/Lima');
        $this->SetFont('Arial', 'B', 15);
//	$this->Image("view/img/log.png", null, 5, 20, 15);
      //  $this->Cell(190, 2, "TARJETA KANBAN", 0, 0, 'C');
        $this->Ln(7);
      
        
  
    }

}

$pdf = new PDF();
$pdf->AddPage();


 
  $pdf->SetFont('Arial', 'B', 15);
  $contador = count ($cabecerakanban);

  $a=0;
    if( $cabecerakanban){
		   foreach( $cabecerakanban as $listacab){
			    $a++;
			     $kanban = new kanban();
			      $cuerpokanban = $kanban->cuerpokanban( $listacab['artsemi_id']);
			      
			        $cuerpo =[];
  $cintatrama =[];
$cintaurdimbre =[];
			      
				if( $cuerpokanban){
				foreach( $cuerpokanban as $listacue){
			    $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
				}
				
				
}





					if($listacab['prokandet_tipo']== 'saco'){
						
						
						
						$uni_med= '';
						$peso_nominal = '';
if($cuerpo['15']=='ARPILLERA TEJIDO' and $cuerpo['19'] == 'ARPILLERA'){
	$uni_med =' mtrs.';
	$peso_nominal = ' Kg.';
	
}else if ($cuerpo['15']=='MANTA TEJIDO' and $cuerpo['19'] == 'MANTA'){
	$uni_med =' mtrs.';
	$peso_nominal = ' Kg.';
	


}else{
	$uni_med =' Pulg.';
	$peso_nominal = ' Gr.';
	

}
						
						
						for($i=1; $i<=2; $i++){
							if($i==1){
								$ubica_rect = 10;
							}else{
								$ubica_rect = 150;
							}
							
				$pdf->Rect(10, $ubica_rect, 190, 130, '');		
						$pdf->Cell(2, 8, "", 0, 0, 'C'); //no texto
						$pdf->Cell(30, 8, utf8_decode("N° Telar:"), 0, 0, 'L');
						$pdf->SetFillColor(201, 201, 201);
						$pdf->Cell(35, 8,$listacab['nombre'], 1, 0, 'C');
						$pdf->Cell(60, 8, "", 0, 0, 'C'); //no texto

						$pdf->Cell(20, 8, "Op:", 0, 0, 'C');
						$pdf->SetFillColor(201, 201, 201);
						$pdf->Cell(40,8, $listacab['prokandet_nroped'], 1, 0, 'C');
					   
						$pdf->Ln(16);
						//$pdf->settextcolor(150,180,0);
						 $pdf->Cell(3, 8, "", 0, 0, 'C'); //no texto
						 $pdf->SetFont('Arial', 'B', 13);
						$pdf->multicell(185, 8,$listacab['razonsocial']." // " .utf8_decode($listacab['desart']), 0, 'C',1);
						   $pdf->SetFont('Arial', 'B', 15);
						 $pdf->Ln();
						  $pdf->Cell(3, 8, "", 0, 0, 'C'); //no texto
						  $pdf->settextcolor(150,25,0);
						   $pdf->SetFont('Arial', 'B', 12);
						$pdf->multicell(185, 8,utf8_decode( $cuerpo['18']), 0, 'C');
						 $pdf->SetFont('Arial', 'B', 15);
						$pdf->settextcolor(0,0,0);
						 $pdf->Ln();
						  $pdf->Cell(3, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(60, 8,utf8_decode( "Ancho :".$cuerpo['11'].$uni_med), 0,0, 'R',1);
						$pdf->cell(60, 8,utf8_decode( "Largo :".$cuerpo['16'].$uni_med), 0,0, 'C',1);
						$pdf->cell(60, 8,utf8_decode( "Peso :".$cuerpo['17'].$peso_nominal), 0,0, 'L',1);
						
						$codTrama =  $cuerpo['13'];
						$codUrdim =  $cuerpo['14'];   
						
						 $infoTrama = $kanban->caraccintas( $codTrama);
							$infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
									  if(  $infoTrama){
											   foreach(  $infoTrama as $listatra){
													$cintatrama[$listatra['itemcaracsemi_id']] = $listatra['valor'];
											   }
									}


									 if(  $infoUrdimbre){
											   foreach(  $infoUrdimbre as $listaurd){
													$cintaurdimbre[$listaurd['itemcaracsemi_id']] = $listaurd['valor'];
											   }
									}
						
						 $pdf->Ln(16);
						 $pdf->SetFillColor(2,157,116);
						 $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(60, 8,utf8_decode( "Trama"), 1,0, 'C',1);
						$pdf->SetFillColor(201, 201, 201);
						$pdf->cell(30, 8,"", 0,0, 'C');
						 $pdf->SetFillColor(2,157,116);
						$pdf->cell(60, 8,utf8_decode( "Urdimbre"), 1,0, 'C',1);
						$pdf->SetFillColor(201, 201, 201);
						 $pdf->Ln();
						  $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(30, 8,utf8_decode( $cintatrama['4']), 1,0, 'C');
						$pdf->cell(30, 8,utf8_decode( $cintatrama['1']), 1,0, 'C');
						$pdf->cell(30, 8,"", 0,0, 'C');
						$pdf->cell(30, 8,utf8_decode( $cintaurdimbre['4']), 1,0, 'C');
						$pdf->cell(30, 8,utf8_decode($cintaurdimbre['1']), 1,0, 'C');
						
						$pdf->Ln();
						$pdf->SetFillColor(150,180,0);
						  $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(60, 8,utf8_decode( $cintatrama['2']), 1,0, 'C',1);
						$pdf->cell(30, 8,"", 0,0, 'C');
						$pdf->cell(60, 8,utf8_decode( $cintaurdimbre['2']), 1,0, 'C',1);
						$pdf->SetFillColor(201, 201, 201);
						
						$pdf->Ln();
						  $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(60, 8,utf8_decode( $cintatrama['3']." ".$cintatrama['10']), 1,0, 'C');
						$pdf->cell(30, 8,"", 0,0, 'C');
						$pdf->cell(60, 8,utf8_decode(  $cintaurdimbre['3']." ". $cintaurdimbre['10']), 1,0, 'C');
						
						
						$pdf->Ln(22);
						}
					}else{
						
							for($i=1; $i<=2; $i++){
							if($i==1){
								$ubica_rect = 10;
							}else{
								$ubica_rect = 150;
							}
							
				$pdf->Rect(10, $ubica_rect, 190, 130, '');		
						$pdf->Cell(2, 8, "", 0, 0, 'C'); //no texto
						$pdf->Cell(30, 8, utf8_decode("N° Telar:"), 0, 0, 'L');
						
						$pdf->SetFillColor(201, 201, 201);
						$pdf->Cell(35, 8,$listacab['nombre'], 1, 0, 'C');
						$pdf->Cell(60, 8, "", 0, 0, 'C'); //no texto

						$pdf->Cell(20, 8, "Op:", 0, 0, 'C');
						$pdf->SetFillColor(201, 201, 201);
						$pdf->Cell(40,8, $listacab['prokandet_nroped'], 1, 0, 'C');
					 
						$pdf->Ln(16);
						//$pdf->settextcolor(150,180,0);
						 $pdf->Cell(3, 8, "", 0, 0, 'C'); //no texto
						   $pdf->SetFont('Arial', 'B', 13);
						$pdf->multicell(185, 8,$listacab['razonsocial']." // " .utf8_decode($listacab['nombresemi']), 0, 'C',1);
						   $pdf->SetFont('Arial', 'B', 15);
						 $pdf->Ln();
						  $pdf->Cell(3, 8, "", 0, 0, 'C'); //no texto
						  $pdf->settextcolor(150,25,0);
						$pdf->multicell(185, 8,utf8_decode( ""), 0, 'C');
						$pdf->settextcolor(0,0,0);
						 $pdf->Ln();
						  $pdf->Cell(3, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(60, 8,utf8_decode( "Ancho :".$cuerpo['78'].'"'), 0,0, 'R',1);
						$pdf->cell(60, 8,utf8_decode( "Largo :".$cuerpo['79'].'"'), 0,0, 'C',1);
						$pdf->cell(60, 8,utf8_decode( "Peso :".$cuerpo['80'].'gramos'), 0,0, 'L',1);
						
						$codTrama =  $cuerpo['85'];
						$codUrdim =  $cuerpo['86'];   
						
						 $infoTrama = $kanban->caraccintas( $codTrama);
							$infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
									  if(  $infoTrama){
											   foreach(  $infoTrama as $listatra){
													$cintatrama[$listatra['itemcaracsemi_id']] = $listatra['valor'];
											   }
									}


									 if(  $infoUrdimbre){
											   foreach(  $infoUrdimbre as $listaurd){
													$cintaurdimbre[$listaurd['itemcaracsemi_id']] = $listaurd['valor'];
											   }
									}
						
						 $pdf->Ln(16);
						 $pdf->SetFillColor(2,157,116);
						 $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(60, 8,utf8_decode( "Trama"), 1,0, 'C',1);
						$pdf->SetFillColor(201, 201, 201);
						$pdf->cell(30, 8,"", 0,0, 'C');
						 $pdf->SetFillColor(2,157,116);
						$pdf->cell(60, 8,utf8_decode( "Urdimbre"), 1,0, 'C',1);
						$pdf->SetFillColor(201, 201, 201);
						 $pdf->Ln();
						  $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(30, 8,utf8_decode( $cintatrama['4']), 1,0, 'C');
						$pdf->cell(30, 8,utf8_decode( $cintatrama['1']), 1,0, 'C');
						$pdf->cell(30, 8,"", 0,0, 'C');
						$pdf->cell(30, 8,utf8_decode( $cintaurdimbre['4']), 1,0, 'C');
						$pdf->cell(30, 8,utf8_decode($cintaurdimbre['1']), 1,0, 'C');
						$pdf->Ln();
						  $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						  $pdf->SetFillColor(150,180,0);
						$pdf->cell(60, 8,utf8_decode( $cintatrama['2']), 1,0, 'C',1);
						$pdf->cell(30, 8,"", 0,0, 'C');
						$pdf->cell(60, 8,utf8_decode( $cintaurdimbre['2']), 1,0, 'C',1);
						$pdf->SetFillColor(201, 201, 201);
						$pdf->Ln();
						  $pdf->Cell(23, 8, "", 0, 0, 'C'); //no texto
						$pdf->cell(60, 8,utf8_decode( $cintatrama['3']." ".$cintatrama['10']), 1,0, 'C');
						$pdf->cell(30, 8,"", 0,0, 'C');
						$pdf->cell(60, 8,utf8_decode(  $cintaurdimbre['3']." ". $cintaurdimbre['10']), 1,0, 'C');
						
						
						
						$pdf->Ln(40);
						  $pdf->Ln(16);
						}
					
						
					}
			   
			
		

	 
                                                            
 if($contador>$a){
$pdf->addPage();

}
	   }
	   }
 

$pdf->Output();
?>


<?php ?>
