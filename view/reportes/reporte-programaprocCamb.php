
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
        
        if($i == 11 or $i == 12 or $i == 14 or $i == 15){
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
     $this->Cell(80, 10, utf8_decode("FOR-PDP-22/VERMAY2021"), 0, 0, 'C');
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


$pdf->SetFont('Arial','B',12);
$pdf->Cell(340,12,utf8_decode("PROGRAMA DE CAMBIO DE TEJIDO "),0,0,'C');
$pdf->Cell(60,12,utf8_decode("AREA DE PLANIFICACIÓN"),0,0,'R');
$pdf->ln();
//$pdf->Cell(400,12,utf8_decode("FOR-PDP-22/VERMAY2021"),0,0,'R');
$pdf->ln(15);
$pdf->SetFont('Arial','B',7);
//$pdf->Cell(5,10,"",0);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(6,10,utf8_decode("N°"),1,0,'C',1);
$pdf->Cell(22,10,"TELAR",1,0,'C',1);//NOMBRE DE MAQUINA

$pdf->Cell(18,10,"OP",1,0,'C',1);//ORDEN DE PEDIDO

$pdf->Cell(18,10,"FEC. ENT.",1,0,'C',1);// FECHA DE ENTREGA

$pdf->Cell(15,10,"CODIGO",1,0,'C',1);//CODIGO DEL ARTICULO
$pdf->Cell(25,10,"MTRS. ASIG.",1,0,'C',1);//MTRS ASIGNADOS
$pdf->Cell(40,10,"DESCRIPCION DEL ARTICULO",1,0,'C',1);//DESCRIPCION DEL ARTICULO


$pdf->Cell(22,10,utf8_decode("TIPO"),1,0,'C',1);

$pdf->Cell(25,10,"COLOR",1,0,'C',1);
$pdf->Cell(15,10,"PESO",1,0,'C',1);
$pdf->Cell(25,10,"LARG.CORT.",1,0,'C',1);



$pdf->Cell(13,10,utf8_decode("T. ANC."),1,0,'C',1);
$pdf->Cell(13,10,utf8_decode("T. DEN."),1,0,'C',1);
$pdf->Cell(25,10,"TR. IDENT.",1,0,'C',1);


$pdf->Cell(13,10,utf8_decode("U. ANC."),1,0,'C',1);
$pdf->Cell(13,10,utf8_decode("U. DEN."),1,0,'C',1);
$pdf->Cell(25,10,"URD. IDENT.",1,0,'C',1);


$pdf->Cell(13,10,"D. TR.",1,0,'C',1);// SALDO DE 42
$pdf->Cell(13,10,"D. URD.",1,0,'C',1);// SALDO DE 42

$pdf->Cell(13,10,"# CINTAS",1,0,'C',1);// SALDO DE 42
$pdf->Cell(25,10,"OBSERVACIONES",1,0,'C',1);// SALDO DE 42

$pdf->Ln();
$pdf->SetFont('Arial','',7);

 $a = 0;
if($lista){
    
foreach ($lista as  $op) {
    $a= $a + 1;
    
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
   

 $num_cintas = $cuerpo['11']*2*$cuerpo['24']; //ancho*2*densidad urdimbre
     $pdf->SetWidths(array(6,22,18,18,15,25,40,22,25,15,25,
                          13,13,25,13,13,25,13,13,13,25));
//srand(microtime()*1000000);  
    $pdf->Row(array(
      
        
 $a,
$op['maq_nombre'],//nombre de la maquina
$op['movdismaq_numped'],//orden de pedido


$op['fechaentrega'],//fecha de entrega

utf8_decode ($op['codart']),//cod articulo
utf8_decode ($op['movdismaq_mtrs']),//metros asignados
utf8_decode ($op['desart']) ." (".$op['artsemi_id'].")", //descripcion del articulo

$cuerpo['19'], //tipo de producto 
utf8_decode($cuerpo['30']),//color
$cuerpo['17'],//peso
$cuerpo['48'],// largo de corte


$cintatrama['4'],//ancho de trama
$cintatrama['1'], //denier de trama
utf8_decode($cintatrama['3']),//identificacion de trama

$cintaurdimbre['4'],//ancho de urdimbre
$cintaurdimbre['1'], //denier de urdimbre
utf8_decode($cintaurdimbre['3']),//identificacion de urdimbre


$cuerpo['23'], //densidad de trama
$cuerpo['24'],//densidad de urdimbre



$num_cintas,//total de cintas
utf8_decode($cuerpo['18'])//observaciones
            
         ));


 
/*
$pdf->Cell(6,10,"$a",1,0,'C');
$pdf->Cell(70,10,$op['maq_nombre'],1,0,'C');//nombre de la maquina
$pdf->Cell(18,10,$op['movdismaq_numped'],1,0,'C'); //orden de pedido


$pdf->Cell(25,10,$op['fechaentrega'],1,0,'C');//fecha de entrega

$pdf->SetFont('Arial','',7);
$pdf->Cell(15,10,utf8_decode ($op['codart']),1,0,'C');//cod articulo
$pdf->Cell(25,10,utf8_decode ($op['movdismaq_mtrs']),1,0,'C');//metros asignados
$pdf->Cell(220,10,utf8_decode ($op['desart']) ." (".$op['artsemi_id'].")",1,0,'L'); //descripcion del articulo
$pdf->SetFont('Arial','',7);



$pdf->Cell(38,10,$cuerpo['19'],1,0,'C'); //tipo de producto 
$pdf->Cell(25,10,$cuerpo['30'],1,0,'C');//color
$pdf->Cell(25,10,$cuerpo['17'],1,0,'C');//peso
$pdf->Cell(25,10,$cuerpo['48'],1,0,'C'); // largo de corte





$pdf->Cell(25,10,$cintatrama['4'],1,0,'C',1);//ancho de trama
$pdf->Cell(25,10,$cintatrama['1'],1,0,'C',1); //denier de trama
$pdf->Cell(25,10,utf8_decode($cintatrama['3']),1,0,'C');//identificacion de trama

$pdf->Cell(25,10,$cintaurdimbre['4'],1,0,'C',1);//ancho de urdimbre
$pdf->Cell(25,10,$cintaurdimbre['1'],1,0,'C',1); //denier de urdimbre
$pdf->Cell(25,10,utf8_decode($cintaurdimbre['3']),1,0,'C');//identificacion de urdimbre


$pdf->Cell(25,10,$cuerpo['23'],1,0,'C',1); //densidad de trama
$pdf->Cell(25,10,$cuerpo['24'],1,0,'C',1);//densidad de urdimbre

 $num_cintas = $cuerpo['11']*2*$cuerpo['24']; //ancho*2*densidad urdimbre

$pdf->Cell(25,10,$num_cintas,1,0,'C');//total de cintas
$pdf->Cell(125,10,utf8_decode($cuerpo['18']),1,0,'l');//observaciones



$pdf->Ln();
     */
}

 }
 
                
$pdf->Output();
?>
