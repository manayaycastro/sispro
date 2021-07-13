
<?php
require 'view/fpdf17/fpdf.php';
$meses = array('01' => 'ENERO','02' => 'FEBRERO','03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO'
  ,'07' => 'JULIO','08' => 'AGOSTO','09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE','12' => 'DICIEMBRE');


class PDF extends FPDF{
 var $widths;
var $aligns;

function SetWidths($w){
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a){
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data){
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++){
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        
        if( $i == 11 or $i== 12 or $i == 13){
              $this->SetFillColor (213,222,106);
        $this->SetDrawColor (42,87,36); //COLOR DE LINEA
        
        $this->Rect($x,$y,$w,$h,'DF');
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        }else{
               $this->SetDrawColor (42,87,36); //COLOR DE LINEA
            $this->SetFillColor(255, 255, 255);
        $this->Rect($x,$y,$w,$h,'DF');
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        }
        
        
        
      
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h){
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt){
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

    
function Footer()
  {
   $this->SetY(-12);
    $this->SetFont('Arial','B',12);   
     $this->Cell(80, 10,utf8_decode("FOR-PDP-04/VERMAY2021"), 0, 0, 'C');
    $this->Cell(600,10,utf8_decode("TI. Fecha de creación: ").date("d-m-Y H:i")."             "."Pag ".$this->PageNo(),0,0,'C');    
  }

  function Header()  {
             date_default_timezone_set('America/Lima');
    $this->SetFont('Arial', 'B', 10);
    $this->Image("view/img/logo.png", null, 5, 20, 15);
    $this->Image("view/img/logo.png", 400, 5, 20, 15);
    $this->Cell(400,2, "EL AGUILA SRL", 0, 0, 'C');
    $this->Ln(4);
    $this->Cell(400,1,  "DIR1: Av. Bolivar # 395 Moshoqueque - Chiclayo - Peru", 0, 0, 'C');
    $this->Ln(3);
    $this->Cell(400, 2,   "DIR1: Via Evitamiento  km 2.5 Sector Chacupe - La Victoria", 0, 0, 'C');
    $this->Ln(15);
    $this->SetFont('Arial','B',9);
//    $this->Cell(400, 2, utf8_decode("Cumplimiento de entrega de las ordenes de Pedido"), 0, 0, 'C');
    $this->ln(4); 
    $this->Line(45,25,400,25);
      
  }

}

//420*297

$pdf=new PDF('L', 'mm', array(297.18,420.1));

//$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(5, 10 , 10);
$pdf->AddPage();


$pdf->SetFont('Arial','B',15);
$pdf->Cell(340,12,utf8_decode("PROGRAMA DE SEGUIMIENTO DE TELARES"),0,0,'C');
$pdf->Cell(60,12,utf8_decode("AREA DE PLANIFICACIÓN"),0,0,'R');
$pdf->ln();
//$pdf->Cell(400,12,utf8_decode("FOR-PDP-04/VERMAY2021"),0,0,'R');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(6,10,utf8_decode("N°"),1,0,'C',1);
$pdf->Cell(30,10,"TELAR",1,0,'C',1);
$pdf->Cell(60,10,utf8_decode("IDENTIFICACIÓN DE LA TELA"),1,0,'C',1);
$pdf->Cell(25,10,utf8_decode("TIPO"),1,0,'C',1);
$pdf->Cell(25,10,utf8_decode("COLOR"),1,0,'C',1);

$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->Cell(15,10,"A. MANGA",1,0,'C',1);
$pdf->Cell(15,10,"ASIG.",1,0,'C',1);
$pdf->Cell(20,10,utf8_decode("PEN-PROG."),1,0,'C',1);


$pdf->Cell(25,10,"FEC. ENTREGA",1,0,'C',1);
$pdf->Cell(30,10,"MTRS. MAX. ROLLO",1,0,'C',1);

$pdf->Cell(18,10,"PROG.",1,0,'C',1);
$pdf->Cell(15,10,"ATEN.",1,0,'C',1);
$pdf->Cell(15,10,"PEND.",1,0,'C',1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,10,utf8_decode("TR.-ANC."),1,0,'C',1);
$pdf->Cell(18,10,utf8_decode("TR.-DEN."),1,0,'C',1);
$pdf->Cell(18,10,utf8_decode("URD.-ANC."),1,0,'C',1);
$pdf->Cell(18,10,utf8_decode("URD.-DEN."),1,0,'C',1);

$pdf->Cell(18,10,utf8_decode("FUELLE"),1,0,'C',1);




$pdf->Ln();
$pdf->SetFont('Arial','',9);

 $a = 0;
if($lista){
    
foreach ($lista as  $op) {
    $a= $a + 1;
   $pdf->SetFont('Arial','',9); 
    $cuerpo =[];
    
    $cintatrama =[];
$cintaurdimbre =[];
  $kanban = new kanban();
  $cuerpokanban = $kanban->cuerpokanban( $op['artsemi_id']);
   if ($cuerpokanban) {
            foreach ($cuerpokanban as $listacue) {
                $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
            }
    }
    
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
    
    $pdf->SetWidths(array(6,30,60,25,25,18,15,15,20,25,
                         30,18,15,15,18,18,18,18,18));
//srand(microtime()*1000000);  
    $pdf->Row(array(
        $a, //ITEMS
    $op['maq_nombre'],//NOMBRE DEL TELAR
    utf8_decode($cuerpo['18']) ,//IDEMTIFICACION DE LA TELA  
    utf8_decode($cuerpo['19']) , //TIPO
    utf8_decode($cuerpo['30']),//COLOR
        
    $op['prokandet_nroped'], // NRO DE PEDIDO
          utf8_decode($cuerpo['11']),//ANCHO DE MANGA
    $op['asignado_total'], //KANBAN TOTAL  ASIGNADOS
    utf8_decode ($op['pendiente_programar']),//PENDIENTE DE PROGRAMAR
    utf8_decode ($op['fechaentrega']),//FECHA DE ENTREGA
    $op['prokan_mtrs_x_rollo'],//MTROS MAXIMO POR ROLLO
        
    $op['total_programado'], //PROGRAMADOS
    $op['atendido'], //ATENDIDOS
    $op['pendiente'], //PENDIENTES
   $cintatrama['4'],//TRAMA ANCHO
    $cintatrama['1'],//TRAMA DENIER
        
    $cintaurdimbre['4'], //URDIMBRE ANCHO
    $cintaurdimbre['1'],//URDIMBRE DENIER
    $cuerpo['31'], //FUELLE
    
         ));
      
    

/*
$pdf->Cell(6,10,"$a",1,0,'C');
$pdf->Cell(70,10,$op['maq_nombre'],1,0,'C');//TELAR
$pdf->Cell(180,10,utf8_decode($cuerpo['18']),1,0,'L');//IDENTIFICACION DE LA TELA

$pdf->Cell(55,10,utf8_decode($cuerpo['19']),1,0,'L');//TIPO
$pdf->Cell(55,10,utf8_decode($cuerpo['30']),1,0,'L');//COLOR

$pdf->SetFont('Arial','',10);
$pdf->Cell(18,10,$op['prokandet_nroped'],1,0,'C'); //orden de pedido


$pdf->Cell(30,10,$op['asignado_total'],1,0,'C',1);//KANBAN TOTAL ASIGNADOS
$pdf->Cell(28,10,utf8_decode ($op['pendiente_programar']),1,0,'C',1); //PENDIENTES DE PROGRAMAR


$pdf->Cell(30,10,utf8_decode ($op['fechaentrega']),1,0,'C');//FECHA DE ENTREGA
$pdf->Cell(40,10,utf8_decode ($op['prokan_mtrs_x_rollo']),1,0,'C');//MTRS MAXIMO POR ROLLO


$pdf->Cell(25,10,$op['total_programado'],1,0,'C',1);//´PROGRAMADOS
$pdf->Cell(25,10,$op['atendido'],1,0,'C',1);//ATENDIDO
$pdf->Cell(25,10,$op['pendiente'],1,0,'C',1); // PENDIENTES



$pdf->Cell(25,10,$cintatrama['4'],1,0,'C');//TRAMA ANCHO
$pdf->Cell(25,10,$cintatrama['1'],1,0,'C');//TRAMA DENIER
$pdf->Cell(25,10,$cintaurdimbre['4'],1,0,'C'); //URDIMBRE ANCHO
$pdf->Cell(25,10,$cintaurdimbre['1'],1,0,'C');//URDIMBRE DENIER
$pdf->Cell(25,10,$cuerpo['31'],1,0,'C'); //FUELLE




$pdf->Ln();
   */  
}

 }
 
                
$pdf->Output();
?>
