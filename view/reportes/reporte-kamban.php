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
        $this->SetFont('Arial', 'B', 10);
         $this->Cell(40, 10, 'FOR-PDP-19/VERMAY2021', 0, 0, 'C');
         $this->SetFont('Arial', 'B', 7);
        $this->Cell(200, 10, utf8_decode("TEC.INF. Fecha de creación: ") . date("d-m-Y H:i") . "             " . "Pag " . $this->PageNo(), 0, 0, 'C');
    }

    function Header() {
        // To be implemented in your own inherited class
        //$this->Ln(2);
               date_default_timezone_set('America/Lima');

        $this->SetFont('Arial', 'B', 15);
//	$this->Image("view/img/log.png", null, 5, 20, 15);
        $this->Cell(190, 2, "TARJETA KANBAN", 0, 0, 'C');
        $this->Ln(7);
      
        
  
    }

}

$pdf = new PDF();
$pdf->AddPage();


 
  $pdf->SetFont('Arial', 'B', 7.5);
  $contador = count ($cabecerakanban);
  $a=0;
    if( $cabecerakanban){
		   foreach( $cabecerakanban as $listacab){
			 $a++;
	
        $pdf->Cell(20, 4, utf8_decode("N° Telar:"), 0, 0, 'C');
        $pdf->SetFillColor(201, 201, 201);
        $pdf->Cell(35, 4,$listacab['nombre'], 1, 0, 'C');
        $pdf->Cell(5, 4, "", 0, 0, 'C'); //no texto

        $pdf->Cell(20, 4, "Op:", 0, 0, 'C');
        $pdf->SetFillColor(201, 201, 201);
        $pdf->Cell(40, 4, $listacab['prokandet_nroped'], 1, 0, 'C');
        $pdf->Cell(20, 4, "", 0, 0, 'C'); //no texto
        $art_det_op = "serie correlativo";
        $pdf->Cell(30, 4, utf8_decode("N° Kanban"), 0, 0, 'C');
        $pdf->SetFillColor(201, 201, 201);
       
        $pdf->Cell(20, 4,$listacab['prokandet_id'], 1, 0, 'R');

        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 5);
        $pdf->Cell(30, 10, "informacion General", 0, 0, 'C');
        $pdf->Cell(305, 10, date("d-m-Y H:i"), 0, 0, 'C');
        $pdf->Line(10, 25, 200, 25);
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 10);
        $pdf->ln(5);
        
$pdf->Cell(50, 4, "Cliente", 1, 0, 'L',1);
  $pdf->SetFont('Arial', '', 6);
$pdf->Cell(140, 4, $listacab['razonsocial'], 1, 0, 'L',1);
$pdf->ln();

       $pdf->SetFont('Arial', '', 10);

$pdf->Cell(50, 4, "N. Orden de Tarjeta", 1, 0, 'L',1);
$pdf->Cell(140, 4,$listacab['prokandet_items'].'/'.$listacab['prokan_cantkanban'], 1, 0, 'C');
$pdf->ln();
$pdf->Cell(50, 4, "Metros/Rollo", 1, 0, 'L',1);
//$pdf->Cell(140, 4,$listacab['prokandet_mtrs'] , 1, 0, 'C');

$pdf->Cell(60, 4, $listacab['prokandet_mtrs'] , 1, 0, 'C');
$pdf->Cell(40, 4, "Mtrs. Totales del Pedido", 1, 0, 'L',1);
$pdf->Cell(40, 4, round ($listacab['prokan_mtrs_totales'],2) . ' mtrs.', 1, 0, 'C');

//$metros_totales = $total*$lista->art_det_metros_x_rollo ;
$pdf->ln();


$pdf->Cell(50, 4, "Cliente Recoge CALSE B:", 1, 0, 'L',1);
$pdf->Cell(60, 4, $listacab['docref'] , 1, 0, 'C');
$pdf->Cell(40, 4, "% Clase B", 1, 0, 'L',1);
$pdf->Cell(40, 4, round ($listacab['prokan_porcent_b'],2) .'%', 1, 0, 'C');
$pdf->ln();

$ban = 5;
if(strlen($listacab['desart'])>= 95){
    $ban = 10;}

$pdf->Cell(50, $ban, "Nombre del Producto", 1, 0, 'L',1);
    $pdf->SetFont('Arial', '', 7);
$pdf->multicell(140, 5,$listacab['desart'], 1);

    $pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 4, "Color del producto", 1, 0, 'L',1);
$pdf->Cell(140, 4,  $cuerpo['30'], 1, 0, 'L');
$pdf->ln();

$uni_med= '';
if($cuerpo['15']=='ARPILLERA TEJIDO' and $cuerpo['19'] == 'ARPILLERA'){
	$uni_med =' mtrs.';
	$peso_nominal = ' Kg.';
	$peso = $cuerpo['17'];
	$peso_max =round( $peso*1.05,2);
	$peso_min = round($peso*0.95,2);
	 $num_cintas = $cuerpo['11']*0.0254*$cuerpo['24']*1000; //ancho*2*densidad urdimbre
}else if ($cuerpo['15']=='MANTA TEJIDO' and $cuerpo['19'] == 'MANTA'){
	$uni_med =' mtrs.';
	$cant_metros =  $listacab['prokandet_mtrs'];
	$peso_nominal = ' Kg.';
	
	
	
	if($cuerpo['11']>=6){
		$nuevo_ancho= $cuerpo['11']/2;
	}else{
		 $nuevo_ancho= $cuerpo['11'];
	}
	
	$gramaje_manta= ($cuerpo['17']*1000)/( $cuerpo['11']*$cuerpo['16']);
	
	$peso = ($gramaje_manta* $nuevo_ancho*$cant_metros)/1000;
	$peso_max =round($peso *1.05,2);
	$peso_min = round($peso*0.95,2);
	
	if($cuerpo['11']>=6){
		 $num_cintas = ($cuerpo['11']*0.0254*$cuerpo['24']*1000)/2; //ancho*2*densidad urdimbre
	}else{
		 $num_cintas = $cuerpo['11']*0.0254*$cuerpo['24']*1000; //ancho*2*densidad urdimbre
	}
	
	

}else{
	$uni_med =' Pulg.';
	$peso_nominal = ' Gr.';
	$gramaje = (( $cuerpo['23'] *$cintatrama['1'] )+( $cintaurdimbre['1'] *($cuerpo['24']/0.254)))/900;
$peso = ( $gramaje*$cuerpo['11']* $cuerpo['48'] *0.0254*0.0254*2)*((($listacab['prokandet_mtrs']*100)/2.54)/$cuerpo['48']/1000);

$peso_max =round( $peso*1.02,2);
$peso_min = round($peso*0.98,2);

 $num_cintas = $cuerpo['11']*2*$cuerpo['24']; //ancho*2*densidad urdimbre

}

$pdf->Cell(50, 4, "Dimensiones Terminadas", 1, 0, 'L',1);
$pdf->Cell(140, 4, $cuerpo['11'].$uni_med." X ".$cuerpo['16'].$uni_med, 1, 0, 'L');
$pdf->ln();
$pdf->Cell(50, 4, "Peso Nominal del Producto", 1, 0, 'L',1);
$pdf->Cell(140, 4, round($cuerpo['17'],2).$peso_nominal , 1, 0, 'L');
$pdf->ln();
$pdf->Cell(50, 4, "Codigo Identificacion", 1, 0, 'L',1);
$pdf->SetFont('Arial', '', 7);
$pdf->settextcolor(150,25,0);
$pdf->Cell(140, 4, $cuerpo['18'], 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->ln();
$pdf->settextcolor(0,0,0);
$pdf->Cell(50, 10, "Observaciones Aseg. Calidad", 1, 0, 'L',1);
$pdf->Cell(140, 10, $listacab['procoment_mensaje'], 1, 0, 'L');

if(strlen($listacab['desart'])< 95){
   $pdf->ln(); 
$pdf->Cell(140, 5, "", 0, 0, 'L');

}
if(strlen($listacab['desart'])< 95){
$pdf->Ln(3);

}else{
    $pdf->Ln(8);
}

$pdf->Line(10, 86, 200, 86);
$pdf->Ln(3);
$pdf->Cell(30, 10, "informacion General", 0, 0, 'C');
$pdf->ln(9);



	 
                                                            
//****************************************relares ******************************************************
//****************************************relares ******************************************************
//****************************************relares ******************************************************
 if($cuerpo['70']!=''){
$pdf->SetFillColor(2,157,116);
$pdf->Cell(190, 4, "TELARES", 1, 0, 'C',1);
$pdf->Ln(6);
$pdf->SetFillColor(201, 201, 201);
$pdf->Rect(10, 92, 190, 50, '');

$pdf->Cell(20, 4, utf8_decode("Fuelle Telar:"), 0, 0, 'C');
$pdf->Cell(33, 4, $cuerpo['22'], 1, 0, 'R');
$pdf->Cell(12, 4, "", 0, 0, 'C'); //no texto
$pdf->Cell(21, 8, "Anillo", 1, 0, 'C');
$pdf->Cell(40, 4, "Densidad", 1, 0, 'C');
$pdf->Cell(40, 4, "Denier", 1, 0, 'C');
$pdf->Cell(21, 8, "N. de Cintas", 1, 0, 'C');
$pdf->Ln(4);

$pdf->Cell(20, 4, utf8_decode("Basta:"), 0, 0, 'C');
$pdf->Cell(33, 4, $cuerpo['21'], 1, 0, 'R');
$pdf->Cell(21, 4, "", 0, 0, 'R');

$pdf->Cell(12, 4, "", 0, 0, 'C'); //no texto
$pdf->Cell(20, 4, "Tr", 1, 0, 'C');
$pdf->Cell(20, 4, "Ur", 1, 0, 'C');
$pdf->Cell(20, 4, "Tr", 1, 0, 'C');
$pdf->Cell(20, 4, "Ur", 1, 0, 'C');
$pdf->Ln();

$pdf->Cell(20, 4, utf8_decode("Largo Corte:"), 0, 0, 'C');
$pdf->Cell(33, 4, $cuerpo['48'], 1, 0, 'R');
$pdf->Cell(12, 4, "", 0, 0, 'C'); //no texto
$pdf->Cell(21, 8, $cuerpo['11'], 1, 0, 'C');
$pdf->Cell(20, 4, $cuerpo['23'], 1, 0, 'C');//densidad de la trama
$pdf->Cell(20, 4, $cuerpo['24'], 1, 0, 'C');//densidad del urdimbre

$codTrama =  $cuerpo['13'];
$codUrdim =  $cuerpo['14'];


$pdf->Cell(10, 4,$cintatrama['4'], 1, 0, 'C');//ancho cinta trama
$pdf->Cell(10, 4, $cintatrama['1'], 1, 0, 'C');//denier de trama
$pdf->Cell(10, 4, $cintaurdimbre['4'], 1, 0, 'C');//ancho cinta urdimbre
$pdf->Cell(10, 4,  $cintaurdimbre['1'], 1, 0, 'C');//denier de urdimbre
 
 //$num_cintas = $cuerpo['11']*2*$cuerpo['24']; //ancho*2*densidad urdimbre

$pdf->Cell(21, 8, $num_cintas, 1, 0, 'C');

$pdf->Ln(4);
$pdf->Cell(25, 4, utf8_decode(""), 0, 0, 'C');
$pdf->Cell(20, 4, "", 0, 0, 'R');
$pdf->Cell(20, 4, "", 0, 0, 'C'); //no texto
$pdf->Cell(21, 4, "", 0, 0, 'R');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(20, 4, $cintatrama['2'], 1, 0, 'C');
$pdf->Cell(20, 4, $cintaurdimbre['2'], 1, 0, 'C');
$pdf->Cell(20, 4, utf8_decode($cintatrama['3']." ".$cintatrama['10']), 1, 0, 'C'); //color
$pdf->Cell(20, 4,  utf8_decode ( $cintaurdimbre['3']." ". $cintaurdimbre['10']), 1, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln(6);



$pdf->Cell(20, 4, "Fecha", 1, 0, 'C');
$pdf->Cell(20, 4, "Metros", 1, 0, 'C');
$pdf->Cell(89, 4, "Operario", 1, 0, 'C');
$pdf->Cell(3, 4, utf8_decode(""), 0, 0, 'C');
$pdf->Cell(57, 4, "Peso Rollo(Kg)", 1, 0, 'C');
$pdf->Ln();
 if(date("d-m-Y H:i") == null){
     $date5 = '';
 }else{
     $date5 = date("d-m-Y",strtotime(date("d-m-Y H:i")));
 }


$pdf->Cell(20, 4,"", 1, 0, 'C',1);//fecha de registro de la bobina en telares
$pdf->Cell(20, 4, "", 1, 0, 'C',1);// metros registrados en el proceso de telares
$pdf->Cell(89, 4, "", 1, 0, 'C',1);//operario que registro en el proceso de telares
$pdf->Cell(3, 4, utf8_decode(""), 0, 0, 'C');

//$gramaje = (( $cintatrama['1']*$cuerpo['23'])*( $cintaurdimbre['1']* $cuerpo['24']))/(0.254*900);
//$peso = round((( $cuerpo['11']* $cuerpo['48']*$gramaje)/775)/1000,2);

$pdf->Cell(19, 4, "$peso_min", 1, 0, 'R');
$pdf->Cell(19, 4, "", 1, 0, 'R',1);
$pdf->Cell(19, 4, "$peso_max", 1, 0, 'R');


$pdf->Ln(6);
$pdf->Cell(80, 5, "Observaciones:", 0, 0, 'L');
$pdf->Ln();
$pdf->Cell(80, 15, "", 1, 0, 'L');//observaciones en el proceso de telares
$pdf->Ln(7);

$pdf->Line(100, 136, 150, 136);

$pdf->Line(195, 136, 165, 136);

$pdf->Cell(100, 10, "", 0, 0, 'C'); //no texto
$pdf->Cell(30, 10, "Nombre del Lider", 0, 0, 'C');
$pdf->Cell(20, 10, "", 0, 0, 'C');//no texto
$pdf->Cell(40, 10, "Firma Operario", 0, 0, 'C');

$pdf->Ln(8);
 }

//****************************************Laminado ******************************************************
//****************************************Laminado ******************************************************
//****************************************Laminado ******************************************************
// SE PREGUNTA SI ESTA ES LA SIGUIENTE RUTA
 if($cuerpo['71']!=''){
  $pdf->SetFillColor(2,157,116);
$pdf->Cell(190, 4, "LAMINADO", 1, 0, 'C',1);
$pdf->Ln();
$pdf->SetFillColor(201, 201, 201);
//$pdf->Rect(10, 92, 190, 50, '');

 if(date("d-m-Y H:i") == null){
     $date6 = '';
 }else{
     $date6 = date("d-m-Y",strtotime(date("d-m-Y H:i")));
 }

$pdf->Cell(20, 4, utf8_decode("Fecha:"), 1, 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C');//fecha de registro de produccion
$pdf->Cell(20, 4, utf8_decode("Turno:"), 1, 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C');//turno
$pdf->Cell(20, 4, utf8_decode("Operario:"), 1, 0, 'C');
$pdf->Cell(90, 4, "", 1, 0, 'C');//operario de produccion
$pdf->Ln();

$pdf->Cell(40, 4, utf8_decode("Lamina g/m2:"), 1, 0, 'C');
$pdf->Cell(20, 4, $cuerpo['27'], 1, 0, 'C'); // carga de lamina
$pdf->Cell(20, 4, "", 1, 0, 'C',1);
$pdf->Cell(50, 4, utf8_decode("Peso de saco sin laminar(GR)"), 1, 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C',1);
$pdf->Cell(40, 24, "", 1, 0, 'C');
$pdf->Ln(4);

    
$pdf->Cell(40, 4, utf8_decode("Perforado:"), 1, 0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(40, 4, $cuerpo['26'], 1, 0, 'C');//perforado
    $pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 4, utf8_decode("Peso  Real del Saco(Gr)"), 1, 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C',1);
$pdf->Cell(16, 4, "Metros:", 0, 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C');//no texto
$pdf->Ln();

$pdf->Cell(40, 4, utf8_decode("Color Lamina"), 1, 0, 'C');
$pdf->Cell(40, 4, $cuerpo['25'], 1, 0, 'C');//color de lamina
$pdf->Cell(50, 4, utf8_decode("Peso Rollo Laminado(Kg)"), 1, 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C',1);
//$pdf->Rect(180, 154, 20, 4, 'FD');
$pdf->Ln();
$pdf->Cell(30, 12, "Observaciones:", 1, 0, 'L');
$pdf->Cell(120, 12, "", 1, 0, 'L');//observaciones
//$pdf->Line(195, 168, 165, 168);
$pdf->Ln(4);
$pdf->Cell(150, 8, "", 0, 0, 'C');
$pdf->Cell(2, 8, "", 0, 0, 'C');
$pdf->Cell(36, 8, "Firma Operario", 'T', 0, 'C');
$pdf->Cell(2, 8, "", 0, 0, 'C');
$pdf->Ln(8);  
}
//****************************************Impresion ******************************************************
//****************************************Impresion ******************************************************
//****************************************Impresion ******************************************************
//L: izquierda
//T: superior
//R: derecha
//B: inferior
//$pdf->Rect(10, 174, 190, 45, '');

// se pregunta si pasa por este proceso
 if($cuerpo['72']!= ''){
    $pdf->SetFillColor(2,157,116);
$pdf->Cell(190, 4, utf8_decode("IMPRESIÓN "), 1, 0, 'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Ln();
$pdf->Cell(20, 4, utf8_decode("1ra cara:"), 'L', 0, 'C');

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(170, 4, "(1)". utf8_decode($cuerpo['34'])." <-> (2)".utf8_decode($cuerpo['36'])." <-> (3)".utf8_decode($cuerpo['38'])." <-> (4)".utf8_decode($cuerpo['40'])." <-> (5)".utf8_decode($cuerpo['42'])." <-> (6)".utf8_decode($cuerpo['44'])."", 1, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 4, utf8_decode("2da cara:"), 'L', 0, 'C');

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(170, 4,  "(1)". utf8_decode($cuerpo['35'])." <-> (2)".utf8_decode($cuerpo['37'])." <-> (3)".utf8_decode($cuerpo['39'])." <-> (4)".utf8_decode($cuerpo['41'])." <-> (5)".utf8_decode($cuerpo['43'])." <-> (6)".utf8_decode($cuerpo['45'])."", 1, 0, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 2, utf8_decode(""), 'L', 0, 'C');
$pdf->Cell(170, 2, utf8_decode(""), 'R', 0, 'C');
$pdf->Ln();
$pdf->Cell(20, 12, utf8_decode("Descripción"), 'L', 0, 'C');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(80, 12, utf8_decode($cuerpo['32']), 1, 0, 'C');//nombre del diseño
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 4, utf8_decode("Kg. Imp."), 0, 0, 'C');
$pdf->Cell(20, 4, utf8_decode(""), 1, 0, 'C',1);
$pdf->Cell(20, 4, utf8_decode("Metros:"), 0, 0, 'C');
$pdf->Cell(30, 4, utf8_decode(""), 1, 0, 'C',1);//metros impresos
$pdf->Ln();
$pdf->Cell(100, 4, utf8_decode(""), 0, 0, 'C');
$pdf->Cell(20, 4, utf8_decode("Fuelle:"), 0, 0, 'C');

//$pdf->SetFillColor(150,180,0);
//$pdf->Cell(20, 4, utf8_decode("$lista->art_det_fuelle_telar"), 1, 0, 'C',1);
//$pdf->SetFillColor(201, 201, 201);


if($cuerpo['31'] != ''){
	$pdf->SetFillColor(150,180,0);
$pdf->Cell(20, 4, utf8_decode($cuerpo['31']."Pulg."), 1, 0, 'C',1);
$pdf->SetFillColor(201, 201, 201);
}else{
	$pdf->SetFillColor(150,180,0);
$pdf->Cell(20, 4, utf8_decode(" 0 Pulg."), 1, 0, 'C',1);
$pdf->SetFillColor(201, 201, 201);
}




$pdf->Cell(20, 4, utf8_decode("Fecha:"), 0, 0, 'C');
 if(date("d-m-Y H:i") == null){
     $date7 = '';
 }else{
     $date7 = date("d-m-Y",strtotime(date("d-m-Y H:i")));
 }
$pdf->Cell(30, 4, utf8_decode(""), 1, 0, 'C',1);//fecha de registro
$pdf->Ln();
$pdf->Cell(100, 4, utf8_decode(""), 0, 0, 'C');
$pdf->Cell(20, 4, utf8_decode("Operario:"), 0, 0, 'C');
$pdf->Cell(70, 4, utf8_decode(""), 1, 0, 'C',1);//operario
$pdf->Ln();
$pdf->Cell(20, 2, utf8_decode(""), 'L', 0, 'C');
$pdf->Cell(170, 2, utf8_decode(""), 'R', 0, 'C');
$pdf->Ln();
$pdf->Cell(30, 12, "Observaciones:", 'L', 0, 'L');
$pdf->Cell(120, 12, "", 1, 0, 'L'); //observaciones
$pdf->Cell(40, 12, "", 'R', 0, 'L');
//$pdf->Line(195, 209, 165, 209);
$pdf->Ln(8);
$pdf->Cell(150, 8, "", 0, 0, 'C');
$pdf->Cell(2, 4, "", 0, 0, 'C');
$pdf->Cell(36, 4, "Firma Operario", 'T', 0, 'C');
$pdf->Cell(2, 4, "", 0, 0, 'C');
$pdf->Ln();

}
//****************************************Conversion ******************************************************
//****************************************Conversion ******************************************************
//****************************************Conversion ******************************************************

// pregunta si es el siguiente proceso
//$pdf->Rect(10, 200, 190, 65, '');
if($cuerpo['73']!= ''){
    $pdf->SetFillColor(2,157,116);
$pdf->Cell(190, 4, utf8_decode("CONVERSIÓN "), 1, 0, 'C',1);
$pdf->Ln();
$pdf->Cell(150, 2, utf8_decode(""), 'L', 0, 'C');
$pdf->Cell(40, 2, utf8_decode(""), 'R', 0, 'C');
$pdf->Ln();
$pdf->SetFillColor(201, 201, 201);


$pdf->Cell(20, 4, utf8_decode("Ancho:"), 'L', 0, 'C');
$pdf->Cell(40, 4, $cuerpo['11'], 1, 0, 'C');//ancho del producto
$pdf->Cell(20, 4, utf8_decode("Fuelle:"), 0, 0, 'C');

if('no' != 'NO'){
	$pdf->SetFillColor(150,180,0);
$pdf->Cell(40, 4, $cuerpo['49'], 1, 0, 'C',1);//fuelle proc. conversion
$pdf->SetFillColor(201, 201, 201);
}else{
	$pdf->SetFillColor(150,180,0);
$pdf->Cell(40, 4, $cuerpo['49'], 1, 0, 'C',1);//fuelle proc. conversion
$pdf->SetFillColor(201, 201, 201);
}




$pdf->Cell(20, 4, utf8_decode("Basta:"), 0, 0, 'C');
$pdf->Cell(40, 4,$cuerpo['53'], 1, 0, 'C');//costura de basta en bastillados
$pdf->Cell(10, 4, utf8_decode(""), 'R', 0, 'C');

$pdf->Ln();


$pdf->Cell(20, 4, utf8_decode("Long. Corte:"), 'L', 0, 'C');
$pdf->Cell(40, 4, $cuerpo['48'], 1, 0, 'C');//longitud de corte conversion
$pdf->Cell(20, 4, utf8_decode("Costura:"), 0, 0, 'C');
$pdf->Cell(20, 4,$cuerpo['50'], 1, 0, 'C'); //costura de fondo  conversion
$pdf->Cell(20, 4, utf8_decode("Hilo:"), 0, 0, 'C');
$pdf->Cell(70, 4, $cuerpo['54']."/".$cuerpo['55'], 1, 0, 'C');//basta 1 y basta 2
$pdf->Cell(50, 4, utf8_decode(""), 'R', 0, 'C');
$pdf->Ln();


$pdf->Cell(20, 4, utf8_decode("Corte:"), 'L', 0, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(40, 4, $cuerpo['47'], 1, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 4, utf8_decode("Color Hilo:"), 0, 0, 'C');
$pdf->Cell(70, 4, $cuerpo['51']."/".$cuerpo['52'], 1, 0, 'C');
$pdf->Cell(40, 4, utf8_decode(""), 'R', 0, 'C');
$pdf->Ln();

$pdf->Cell(150, 4, utf8_decode(""), 'L', 0, 'C');
$pdf->Cell(40, 4, utf8_decode(""), 'R', 0, 'C');
$pdf->Ln();
 if(date("d-m-Y H:i") == null){
     $date8 = '';
 }else{
     $date8 = date("d-m-Y",strtotime(date("d-m-Y H:i")));
 }
$pdf->Cell(20, 4, utf8_decode("Fecha:"), 'L', 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C',1);//fecha produccion 1
$pdf->Cell(20, 4, utf8_decode("Operario:"), 0, 0, 'C');
$pdf->Cell(70, 4, "", 1, 0, 'C',1);//operario 1
$pdf->Cell(15, 4, utf8_decode("Clase A:"), 0, 0, 'C');
$pdf->Cell(10, 4, "", 1, 0, 'C',1);//clase a 1
$pdf->Cell(15, 4, utf8_decode("Clase B:"), 0, 0, 'C');
$pdf->Cell(10, 4, "", 1, 0, 'C',1);//clase b 1
$pdf->Cell(10, 4, utf8_decode(""), 'R', 0, 'C');


$pdf->Ln();

$pdf->Cell(20, 4, utf8_decode("Fecha:"), 'L', 0, 'C');
$pdf->Cell(20, 4, "", 1, 0, 'C',1);//fecha produccion 2
$pdf->Cell(20, 4, utf8_decode("Operario:"), 0, 0, 'C');
$pdf->Cell(70, 4, "", 1, 0, 'C',1);//operario 2
$pdf->Cell(15, 4, utf8_decode("Clase A:"), 0, 0, 'C');
$pdf->Cell(10, 4, "", 1, 0, 'C',1);//clase a 2
$pdf->Cell(15, 4, utf8_decode("Clase B:"), 0, 0, 'C');
$pdf->Cell(10, 4, "", 1, 0, 'C',1);//clase b 2
$pdf->Cell(10, 4, utf8_decode(""), 'R', 0, 'C');


$pdf->Ln();
$pdf->Cell(20, 2, utf8_decode(""), 'L', 0, 'C');
$pdf->Cell(170, 2, utf8_decode(""), 'R', 0, 'C');
$pdf->Ln();
$pdf->Cell(30, 12, "Observaciones:", 'L', 0, 'L');
$pdf->Cell(120, 12, "", 1, 0, 'L');//observaciones conversion
$pdf->Cell(40, 12, "", 'R', 0, 'L');
//$pdf->Line(195, 209, 165, 209);
$pdf->Ln(8);
$pdf->Cell(150, 8, "", 0, 0, 'C');
$pdf->Cell(2, 4, "", 0, 0, 'C');
$pdf->Cell(36, 4, "Firma Operario", 'T', 0, 'C');
$pdf->Cell(2, 4, "", 0, 0, 'C');
$pdf->Ln();

$pdf->Cell(190, 4, "", 'T', 0, 'C');
 
}
  if($contador>$a){
$pdf->addPage();

}
	   }
	   }
 

$pdf->Output();
?>


<?php ?>
