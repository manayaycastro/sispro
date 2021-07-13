
<?php
require 'view/fpdf17/fpdf.php';
$meses = array('01' => 'ENERO','02' => 'FEBRERO','03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO'
  ,'07' => 'JULIO','08' => 'AGOSTO','09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE','12' => 'DICIEMBRE');


class PDF extends FPDF{

function Footer()
  {
    // To be implemented in your own inherited class
    $this->SetY(-12);
    $this->SetFont('Arial','B',11);      
    $this->Cell(800,10,utf8_decode("TI. Fecha de creación: ").date("d-m-Y H:i")."             "."Pag ".$this->PageNo(),0,0,'C');    
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

$pdf=new PDF('L', 'mm', array(297.18,490));

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
	$pdf->Cell(480, 10, utf8_decode("TELARES"), 1, 0, 'C',1);
}elseif($procesos == '168'){
	$pdf->Cell(401, 10, utf8_decode("LAMINADO"), 1, 0, 'C',1);
	}elseif($procesos == '169'){
		$pdf->Cell(401, 10, utf8_decode("IMPRESIÓN"), 1, 0, 'C',1);
	}

   $kanban = new kanban();
$pdf->ln(15);

$pdf->SetFillColor(150,180,0);
$pdf->Cell(480,10,utf8_decode("Mañana").date("Y-m-d", $fechaInicio),1,0,'C',1);
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
$pdf->Cell(30,10,"Peso Proyectado",1,0,'C',1);

$pdf->Cell(18,10,"Operario",1,0,'C',1);
$pdf->Cell(67,10,"Maquina",1,0,'C',1);
//$pdf->Cell(155,10,utf8_decode("Observación"),1,0,'C',1);
$pdf->Cell(12,10,"Id Tr.",1,0,'C',1);
$pdf->Cell(90,10,"Desc. Trama",1,0,'C',1);
$pdf->Cell(12,10,"Id Urd.",1,0,'C',1);
$pdf->Cell(90,10,"Desc. Urd.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->ln(10);

$c=0;
$pdf->SetFont('Arial','',8);
// TURNO MAÑANA	
	if($lista_resumen){
		foreach ($lista_resumen as $lista){
			
$cuerpo =[];
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
				
                         
  $semi_id =  $lista['artsemi_id'];
                                
 $cuerpokanban = $kanban->cuerpokanban( $semi_id);

       

if( $cuerpokanban){
    foreach( $cuerpokanban as $listacue){
            $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
    }
}
	if($lista['prokandet_tipo']== 'saco'){
            $codTrama =  $cuerpo['13'];
            $codUrdim =  $cuerpo['14'];  
            
        }else{
            $codTrama =  $cuerpo['85'];
            $codUrdim =  $cuerpo['86'];  
        }   

 $infoTrama = $kanban->caraccintas( $codTrama);
 $infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
  $idTrama = $kanban->ConsultarArtsemiXnombre( $codTrama);
 $idUrdimbre = $kanban->ConsultarArtsemiXnombre( $codUrdim );
 
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

  if(  $idTrama){
		   foreach(  $idTrama as $listatra_des){
			    $idtrama_cod= $listatra_des['artsemi_id'];
		   }
}


 if(  $idUrdimbre){
		   foreach(  $idUrdimbre as $listaurd_des){
			   $idurdimbre_cod = $listaurd_des['artsemi_id'];
		   }
}
   $uni_med= '';   
   
   
   if($lista['prokandet_tipo']== 'saco'){
           if($cuerpo['15']=='ARPILLERA TEJIDO' and $cuerpo['19'] == 'ARPILLERA'){
	$uni_med =' mtrs.';
	$peso_nominal = ' Kg.';
	$peso = $cuerpo['17'];
	
}else if ($cuerpo['15']=='MANTA TEJIDO' and $cuerpo['19'] == 'MANTA'){
	$uni_med =' mtrs.';
	$cant_metros =  $lista['prokandet_mtrs'];
	$peso_nominal = ' Kg.';
	
	
	
	if($cuerpo['11']>=6){
		$nuevo_ancho= $cuerpo['11']/2;
	}else{
		 $nuevo_ancho= $cuerpo['11'];
	}
	
	$gramaje_manta= ($cuerpo['17']*1000)/( $cuerpo['11']*$cuerpo['16']);
	
	$peso = ($gramaje_manta* $nuevo_ancho*$cant_metros)/1000;
	
	
	

}else{
	$uni_med =' Pulg.';
	$peso_nominal = ' Gr.';
	$gramaje = (( $cuerpo['23'] *$cintatrama['1'] )+( $cintaurdimbre['1'] *($cuerpo['24']/0.254)))/900;
$peso = ( $gramaje*$cuerpo['11']* $cuerpo['48'] *0.0254*0.0254*2)*((($lista['prokandet_mtrs']*100)/2.54)/$cuerpo['48']/1000);

}
  
            
        }else{
            $codTrama =  $cuerpo['85'];
            $codUrdim =  $cuerpo['86']; 
            $gramaje = (( $cuerpo['87'] *$cintatrama['1'] )+( $cintaurdimbre['1'] *($cuerpo['88']/0.254)))/900;
$peso = ( $gramaje*$cuerpo['78']* $cuerpo['79'] *0.0254*0.0254*2)*((($lista['prokandet_mtrs']*100)/2.54)/$cuerpo['79']/1000);

        } 
                             
                                
                                
     $avance =  round ((($peso*  $lista['prorolldet_mtrs']  )/  $lista['prokandet_mtrs']),2);                    
              
     $pdf->Cell(18,10,$lista['prorolldet_peso'],1,0,'C'); //orden de pedido
      $pdf->Cell(30,10,$avance,1,0,'C',1); //orden de pedido
    $pdf->Cell(18,10,$lista['prorolldet_operario'],1,0,'C'); //orden de pedido
				$pdf->Cell(67,10,$lista['maq_nombre'],1,0,'C'); //orden de pedido
       
        $pdf->Cell(12,10,$idtrama_cod,1,0,'C',1); //orden de p                        
	$pdf->Cell(90,10,$codTrama,1,0,'C'); //orden de pedido
      
         $pdf->Cell(12,10,$idurdimbre_cod,1,0,'C',1); //orden de p 
	$pdf->Cell(90,10,$codUrdim,1,0,'C'); //orden de pedido 
                                
//				$pdf->Cell(155,10,utf8_decode ($lista['prorolldet_obs']),1,0,'L'); //orden de pedido
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

$pdf->SetFillColor(150,180,0);
$pdf->Cell(480,10,utf8_decode("Tarde"),1,0,'C',1);
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
$pdf->Cell(30,10,"Peso Proyectado",1,0,'C',1);

$pdf->Cell(18,10,"Operario",1,0,'C',1);
$pdf->Cell(67,10,"Maquina",1,0,'C',1);
//$pdf->Cell(155,10,utf8_decode("Observación"),1,0,'C',1);
$pdf->Cell(12,10,"Id Tr.",1,0,'C',1);
$pdf->Cell(90,10,"Desc. Trama",1,0,'C',1);
$pdf->Cell(12,10,"Id Urd.",1,0,'C',1);
$pdf->Cell(90,10,"Desc. Urd.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->ln(10);

$c=0;
$pdf->SetFont('Arial','',8);
// TURNO MAÑANA	
	if($lista_resumen){
		foreach ($lista_resumen as $lista){
			
$cuerpo =[];
if($lista['fechaproduccion']==date("Y-m-d", $i) and $lista['Turno']== 'Tarde'){
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
				
                         
  $semi_id =  $lista['artsemi_id'];
                                
 $cuerpokanban = $kanban->cuerpokanban( $semi_id);

       

if( $cuerpokanban){
    foreach( $cuerpokanban as $listacue){
            $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
    }
}
	if($lista['prokandet_tipo']== 'saco'){
            $codTrama =  $cuerpo['13'];
            $codUrdim =  $cuerpo['14'];  
            
        }else{
            $codTrama =  $cuerpo['85'];
            $codUrdim =  $cuerpo['86'];  
        }   

 $infoTrama = $kanban->caraccintas( $codTrama);
 $infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
  $idTrama = $kanban->ConsultarArtsemiXnombre( $codTrama);
 $idUrdimbre = $kanban->ConsultarArtsemiXnombre( $codUrdim );
 
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

  if(  $idTrama){
		   foreach(  $idTrama as $listatra_des){
			    $idtrama_cod= $listatra_des['artsemi_id'];
		   }
}


 if(  $idUrdimbre){
		   foreach(  $idUrdimbre as $listaurd_des){
			   $idurdimbre_cod = $listaurd_des['artsemi_id'];
		   }
}
   $uni_med= '';   
   
   
   if($lista['prokandet_tipo']== 'saco'){
           if($cuerpo['15']=='ARPILLERA TEJIDO' and $cuerpo['19'] == 'ARPILLERA'){
	$uni_med =' mtrs.';
	$peso_nominal = ' Kg.';
	$peso = $cuerpo['17'];
	
}else if ($cuerpo['15']=='MANTA TEJIDO' and $cuerpo['19'] == 'MANTA'){
	$uni_med =' mtrs.';
	$cant_metros =  $lista['prokandet_mtrs'];
	$peso_nominal = ' Kg.';
	
	
	
	if($cuerpo['11']>=6){
		$nuevo_ancho= $cuerpo['11']/2;
	}else{
		 $nuevo_ancho= $cuerpo['11'];
	}
	
	$gramaje_manta= ($cuerpo['17']*1000)/( $cuerpo['11']*$cuerpo['16']);
	
	$peso = ($gramaje_manta* $nuevo_ancho*$cant_metros)/1000;
	
	
	

}else{
	$uni_med =' Pulg.';
	$peso_nominal = ' Gr.';
	$gramaje = (( $cuerpo['23'] *$cintatrama['1'] )+( $cintaurdimbre['1'] *($cuerpo['24']/0.254)))/900;
$peso = ( $gramaje*$cuerpo['11']* $cuerpo['48'] *0.0254*0.0254*2)*((($lista['prokandet_mtrs']*100)/2.54)/$cuerpo['48']/1000);

}
  
            
        }else{
            $codTrama =  $cuerpo['85'];
            $codUrdim =  $cuerpo['86']; 
            $gramaje = (( $cuerpo['87'] *$cintatrama['1'] )+( $cintaurdimbre['1'] *($cuerpo['88']/0.254)))/900;
$peso = ( $gramaje*$cuerpo['78']* $cuerpo['79'] *0.0254*0.0254*2)*((($lista['prokandet_mtrs']*100)/2.54)/$cuerpo['79']/1000);

        } 
                             
                                
                                
     $avance =  round ((($peso*  $lista['prorolldet_mtrs']  )/  $lista['prokandet_mtrs']),2);                    
              
     $pdf->Cell(18,10,$lista['prorolldet_peso'],1,0,'C'); //orden de pedido
      $pdf->Cell(30,10,$avance,1,0,'C',1); //orden de pedido
    $pdf->Cell(18,10,$lista['prorolldet_operario'],1,0,'C'); //orden de pedido
				$pdf->Cell(67,10,$lista['maq_nombre'],1,0,'C'); //orden de pedido
       
        $pdf->Cell(12,10,$idtrama_cod,1,0,'C',1); //orden de p                        
	$pdf->Cell(90,10,$codTrama,1,0,'C'); //orden de pedido
      
         $pdf->Cell(12,10,$idurdimbre_cod,1,0,'C',1); //orden de p 
	$pdf->Cell(90,10,$codUrdim,1,0,'C'); //orden de pedido 
                                
//				$pdf->Cell(155,10,utf8_decode ($lista['prorolldet_obs']),1,0,'L'); //orden de pedido
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
$pdf->Cell(480,10,utf8_decode("Noche"),1,0,'C',1);
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
$pdf->Cell(30,10,"Peso Proyectado",1,0,'C',1);

$pdf->Cell(18,10,"Operario",1,0,'C',1);
$pdf->Cell(67,10,"Maquina",1,0,'C',1);
//$pdf->Cell(155,10,utf8_decode("Observación"),1,0,'C',1);
$pdf->Cell(12,10,"Id Tr.",1,0,'C',1);
$pdf->Cell(90,10,"Desc. Trama",1,0,'C',1);
$pdf->Cell(12,10,"Id Urd.",1,0,'C',1);
$pdf->Cell(90,10,"Desc. Urd.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->ln(10);

$c=0;
$pdf->SetFont('Arial','',8);
// TURNO MAÑANA	
	if($lista_resumen){
		foreach ($lista_resumen as $lista){
			
$cuerpo =[];
if($lista['fechaproduccion']==date("Y-m-d", $i) and $lista['Turno']== 'Noche'){
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
				
                         
  $semi_id =  $lista['artsemi_id'];
                                
 $cuerpokanban = $kanban->cuerpokanban( $semi_id);

       

if( $cuerpokanban){
    foreach( $cuerpokanban as $listacue){
            $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
    }
}
	if($lista['prokandet_tipo']== 'saco'){
            $codTrama =  $cuerpo['13'];
            $codUrdim =  $cuerpo['14'];  
            
        }else{
            $codTrama =  $cuerpo['85'];
            $codUrdim =  $cuerpo['86'];  
        }   

 $infoTrama = $kanban->caraccintas( $codTrama);
 $infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
  $idTrama = $kanban->ConsultarArtsemiXnombre( $codTrama);
 $idUrdimbre = $kanban->ConsultarArtsemiXnombre( $codUrdim );
 
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

  if(  $idTrama){
		   foreach(  $idTrama as $listatra_des){
			    $idtrama_cod= $listatra_des['artsemi_id'];
		   }
}


 if(  $idUrdimbre){
		   foreach(  $idUrdimbre as $listaurd_des){
			   $idurdimbre_cod = $listaurd_des['artsemi_id'];
		   }
}
   $uni_med= '';   
   
   
   if($lista['prokandet_tipo']== 'saco'){
           if($cuerpo['15']=='ARPILLERA TEJIDO' and $cuerpo['19'] == 'ARPILLERA'){
	$uni_med =' mtrs.';
	$peso_nominal = ' Kg.';
	$peso = $cuerpo['17'];
	
}else if ($cuerpo['15']=='MANTA TEJIDO' and $cuerpo['19'] == 'MANTA'){
	$uni_med =' mtrs.';
	$cant_metros =  $lista['prokandet_mtrs'];
	$peso_nominal = ' Kg.';
	
	
	
	if($cuerpo['11']>=6){
		$nuevo_ancho= $cuerpo['11']/2;
	}else{
		 $nuevo_ancho= $cuerpo['11'];
	}
	
	$gramaje_manta= ($cuerpo['17']*1000)/( $cuerpo['11']*$cuerpo['16']);
	
	$peso = ($gramaje_manta* $nuevo_ancho*$cant_metros)/1000;
	
	
	

}else{
	$uni_med =' Pulg.';
	$peso_nominal = ' Gr.';
	$gramaje = (( $cuerpo['23'] *$cintatrama['1'] )+( $cintaurdimbre['1'] *($cuerpo['24']/0.254)))/900;
$peso = ( $gramaje*$cuerpo['11']* $cuerpo['48'] *0.0254*0.0254*2)*((($lista['prokandet_mtrs']*100)/2.54)/$cuerpo['48']/1000);

}
  
            
        }else{
            $codTrama =  $cuerpo['85'];
            $codUrdim =  $cuerpo['86']; 
            $gramaje = (( $cuerpo['87'] *$cintatrama['1'] )+( $cintaurdimbre['1'] *($cuerpo['88']/0.254)))/900;
$peso = ( $gramaje*$cuerpo['78']* $cuerpo['79'] *0.0254*0.0254*2)*((($lista['prokandet_mtrs']*100)/2.54)/$cuerpo['79']/1000);

        } 
                             
                                
                                
     $avance =  round ((($peso*  $lista['prorolldet_mtrs']  )/  $lista['prokandet_mtrs']),2);                    
              
     $pdf->Cell(18,10,$lista['prorolldet_peso'],1,0,'C'); //orden de pedido
      $pdf->Cell(30,10,$avance,1,0,'C',1); //orden de pedido
    $pdf->Cell(18,10,$lista['prorolldet_operario'],1,0,'C'); //orden de pedido
				$pdf->Cell(67,10,$lista['maq_nombre'],1,0,'C'); //orden de pedido
       
        $pdf->Cell(12,10,$idtrama_cod,1,0,'C',1); //orden de p                        
	$pdf->Cell(90,10,$codTrama,1,0,'C'); //orden de pedido
      
         $pdf->Cell(12,10,$idurdimbre_cod,1,0,'C',1); //orden de p 
	$pdf->Cell(90,10,$codUrdim,1,0,'C'); //orden de pedido 
                                
//				$pdf->Cell(155,10,utf8_decode ($lista['prorolldet_obs']),1,0,'L'); //orden de pedido
	$pdf->ln();
			}
			
		}
	
		
	}

	
	

$pdf->ln(15);
	
}






       
$pdf->Output();
?>
