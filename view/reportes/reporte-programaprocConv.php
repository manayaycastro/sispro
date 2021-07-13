
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
        
        if($i == 9 or $i == 10){
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
          $this->Cell(80,12,utf8_decode("FOR-PDP-25/VERMAY2021"),0,0,'R');
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
$pdf->Cell(340,12,utf8_decode("PROGRAMA DEL PROCESO DE CONVERSIÓN, DESDE EL  ". "$ini". " AL ".$fin),0,0,'C');
$pdf->Cell(60,12,utf8_decode("AREA DE PLANIFICACIÓN"),0,0,'R');
$pdf->ln();
//$pdf->Cell(400,12,utf8_decode("FOR-PDP-25/VEROCT2020"),0,0,'R');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(6,10,utf8_decode("N°"),1,0,'C',1);
$pdf->Cell(25,10,"FEC. PROGRAMA",1,0,'C',1);
$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->Cell(25,10,"FEC. ENTREGA",1,0,'C',1);
$pdf->Cell(22,10,"CODIGO",1,0,'C',1);
$pdf->Cell(50,10,"CANT. ROLLOS PEDIDO",1,0,'C',1);
$pdf->Cell(70,10,"DESCRIPCIÓN DEL ARTICULO",1,0,'C',1);
$pdf->Cell(22,10,utf8_decode("PROCE. ANTE"),1,0,'C',1);
$pdf->Cell(18,10,"PROG.",1,0,'C',1);
$pdf->Cell(18,10,"ATEN.",1,0,'C',1);
$pdf->Cell(18,10,"PEND.",1,0,'C',1);
$pdf->Cell(18,10,utf8_decode("ANCHO"),1,0,'C',1);
$pdf->Cell(18,10,utf8_decode("LARG. CORTE"),1,0,'C',1);
$pdf->Cell(18,10,"PESO",1,0,'C',1);
$pdf->Cell(25,10,"CANT. SAC. PED.",1,0,'C',1);// SALDO DE 42
$pdf->Cell(25,10,"ENFARDADO",1,0,'C',1);// SALDO DE 42


$pdf->Ln();
$pdf->SetFont('Arial','',9);

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

    
    
     
      $pdf->SetWidths(array(6,25,18,25,22,50,70,22,18,18,18,18,18,18,25,25));
//srand(microtime()*1000000);  
    $pdf->Row(array(
        $a, //ITEMS
     
    $op['progpro_fecprogramacion'],//FECHA DEL PROGRAMA
        $op['numpedido'],//NUM PEDIDO
        $op['fechaentrega'],//FECHA DE ENTREGA
       utf8_decode ($op['codart']),//CODIGO DE ARTICULO
       utf8_decode ($op['prokan_cantkanban']), //CANTIDAD DE ROLLOS EN PEDIDO
       utf8_decode ($op['desart']) , //DESCRIPCION DEL ARTICULO
         $pendiente_anterior, //pendiente anterior 
         $programados,//fecha de vencimiento
         $actual_aten,//ATENDIDO
         $actual_pen,//PENDIENTE
      $cuerpo['11'],//ANCHO DEL PRODUCTO
        $cuerpo['48'],//LARGO DE CORTE
          $cuerpo['17'],//PESO DEL PRODUCTO
        
      round ($op['cantped']),//CANTIDAD PEDIDA 
        $cuerpo['77'], //CANTIDAD DE SACOS POR FARDO
            
         ));
    
    /*
$pdf->Cell(6,10,"$a",1,0,'C');
$pdf->Cell(25,10,$op['progpro_fecprogramacion'],1,0,'C');//fecha de PROGRAMA
$pdf->Cell(18,10,$op['numpedido'],1,0,'C'); //orden de pedido


$pdf->Cell(25,10,$op['fechaentrega'],1,0,'C');//fecha de entrega

$pdf->SetFont('Arial','',9);
$pdf->Cell(22,10,utf8_decode ($op['codart']),1,0,'C');//cod articulo
$pdf->Cell(50,10,utf8_decode ($op['prokan_cantkanban']),1,0,'C');//cantidad de rollos en pedido ,tabla.
$pdf->Cell(220,10,utf8_decode ($op['desart']) ." (".$op['artsemi_id'].")",1,0,'L'); //descr ipcion del articulo
$pdf->SetFont('Arial','',9);



$pdf->Cell(28,10,$pendiente_anterior,1,0,'C'); //pendiente anterior 

$pdf->Cell(25,10,$programados,1,0,'C',1);//fecha de vencimiento
$pdf->Cell(25,10,$actual_aten,1,0,'C');//
$pdf->Cell(25,10,$actual_pen,1,0,'C',1); // 

$pdf->Cell(25,10,$cuerpo['11'],1,0,'C');//ancho del producto




$pdf->Cell(28,10,$cuerpo['48'],1,0,'C');//largo de corte
$pdf->Cell(25,10,$cuerpo['17'],1,0,'C'); //peso del producto
     
$pdf->Cell(25,10,round ($op['cantped']),1,0,'C'); //orden de pedido
$pdf->Cell(25,10,$cuerpo['77'],1,0,'C');//ENFARDELADO 



$pdf->Ln();
     */
}

 }
 
                
$pdf->Output();
?>
