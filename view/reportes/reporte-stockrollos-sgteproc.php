
<?php
require 'view/fpdf17/fpdf.php';
$meses = array('01' => 'ENERO','02' => 'FEBRERO','03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO'
  ,'07' => 'JULIO','08' => 'AGOSTO','09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE','12' => 'DICIEMBRE');

  ini_set('date.timezone','America/Lima'); 
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
    // To be implemented in your own inherited class
    $this->SetY(-12);
    $this->SetFont('Arial','B',12);      
    $this->Cell(600,10,utf8_decode("TI. Fecha de creación: ").date("d-m-Y H:i")."             "."Pag ".$this->PageNo(),0,0,'C');    
  }

  function Header()  {
    // To be implemented in your own inherited class
    //$this->Ln(2);
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

$pdf=new PDF('L', 'mm', array(297.18,420));

//$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(10, 10 , 10);
$pdf->AddPage();


$pdf->SetFont('Arial','B',15);
$pdf->Cell(400,16,utf8_decode("REPORTE  PARA ATENCIÓN DE ROLLOS A SU SIGUIENTE PROCESO, AL  ".date("d-m-Y H:i") ),0,0,'C');
$pdf->ln(15);
$pdf->SetFont('Arial','B',10);

$planificacion = new planificacion();
    //$detalle_resumen_stock_tel_op =$planificacion->ordenPedCan($telares,$codart);
   
	//$art_det_kanban_tel = $planificacion->DetstockXkanbanXproceso($telares);

$b=0;
$pdf->SetFillColor(2,157,116);
$pdf->Cell(400, 12, "LAMINADO", 1, 0, 'C',1);
$pdf->ln(13);
 $art_unico_tel = $planificacion->artUnicoStock_sgteProc($laminado);
if($art_unico_tel){ 
	foreach($art_unico_tel as $list_codart){
			$b++;
		
		$pdf->SetFont('Arial','B',10);	

		$pdf->SetFillColor(201, 201, 201);
		$pdf->Cell(26,10,'',0,0,'C',0);
		$pdf->Cell(6,10,utf8_decode($b),1,0,'C',1);
		$pdf->Cell(30,10,$list_codart['codart'],1,0,'C',1);
		$pdf->Cell(310,10,utf8_decode ($list_codart['desart']),1,0,'L',1);
		$pdf->Cell(28,10,$list_codart['total'],1,0,'C',1);

	$pdf->ln();
		$pdf->SetFont('Arial','',10);
		 $detalle_resumen_stock_tel_op =$planificacion->ordenPedCan_sgteProc($laminado,$list_codart['codart']);
			if($detalle_resumen_stock_tel_op){ 
				foreach($detalle_resumen_stock_tel_op as $list_ped){
					if($list_codart['codart']== $list_ped['codart']){
					 $pdf->Cell(26,10,'',0,0,'C');
					 // $pdf->Cell(36,10,$list_ped['prokandet_nroped'],1,0,'C');
					 $cadena='';
					 $art_det_kanban_tel = $planificacion->DetstockXkanbanXproceso_sgteProc($laminado,$list_ped['codart'],$list_ped['prokandet_nroped']);
						if($art_det_kanban_tel){ 
							foreach($art_det_kanban_tel as $list_kanban){
								if($list_ped['codart']== $list_kanban['codart'] and $list_ped['prokandet_nroped'] ==$list_kanban['prokandet_nroped'] ){
									$cadena= $cadena.' [' .$list_kanban['progpro_kanban'].'] - ';
								}
							
								//$cadena= $cadena.' ' .$art_det_kanban_tel['progpro_kanban'];
							}
						}
                                                
                                                
$pdf->SetWidths(array(36,310,28));
//srand(microtime()*1000000);  
    $pdf->Row(array(
   
      $list_ped['prokandet_nroped'],//PEDIDO
     $cadena,//KANBAN
      $list_ped['cantidad']//CANTIDAD
      

         ));
					 
/*						if(strlen($cadena)>= 200){
						$y1 = $pdf->GetY();
						$x1 = $pdf->GetX();
						
						$pdf->multicell(310, 5,$cadena, 1);
						$y2 = $pdf->GetY();
						$alto_de_fila = $y2 - $y1 ;
						$posicionX = $x1 + 310;
						$pdf->SetXY($posicionX,$y1);
						
						 $pdf->Cell(28,10,$list_ped['cantidad'],1,0,'C');
						  $pdf->ln();
					}else{
						 $pdf->Cell(310,10,$cadena,1,0,'L');
						  $pdf->Cell(28,10,$list_ped['cantidad'],1,0,'C');
                                                  $pdf->ln();
					}
*/
					}
					 	//$pdf->ln();
				}
			}

		$pdf->ln(10);
	}
}

$pdf->addPage();


$pdf->SetFillColor(2,157,116);
$pdf->Cell(400, 12, "IMPRESIÓN", 1, 0, 'C',1);
$pdf->ln(13);
 $art_unico_lam = $planificacion->artUnicoStock_sgteProc($impresion);
if($art_unico_lam){ 
	foreach($art_unico_lam as $list_codart){
			$b++;
			
	$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(201, 201, 201);
		$pdf->Cell(26,10,'',0,0,'C',0);
		$pdf->Cell(6,10,utf8_decode($b),1,0,'C',1);
		$pdf->Cell(30,10,$list_codart['codart'],1,0,'C',1);
		$pdf->Cell(310,10,utf8_decode ($list_codart['desart']),1,0,'L',1);
		$pdf->Cell(28,10,$list_codart['total'],1,0,'C',1);

	$pdf->ln();
		$pdf->SetFont('Arial','',10);
		 $detalle_resumen_stock_lam_op =$planificacion->ordenPedCan_sgteProc($impresion,$list_codart['codart']);
			if($detalle_resumen_stock_lam_op){ 
				foreach($detalle_resumen_stock_lam_op as $list_ped){
					if($list_codart['codart']== $list_ped['codart']){
					 $pdf->Cell(26,10,'',0,0,'C');
					//  $pdf->Cell(36,10,$list_ped['prokandet_nroped'],1,0,'C');
					 $cadena='';
					 $art_det_kanban_lam = $planificacion->DetstockXkanbanXproceso_sgteProc($impresion,$list_ped['codart'],$list_ped['prokandet_nroped']);
						if($art_det_kanban_lam){ 
							foreach($art_det_kanban_lam as $list_kanban){
								if($list_ped['codart']== $list_kanban['codart'] and $list_ped['prokandet_nroped'] ==$list_kanban['prokandet_nroped'] ){
									$cadena= $cadena.' [' .$list_kanban['progpro_kanban'].'] - ';
								}
							
								//$cadena= $cadena.' ' .$art_det_kanban_tel['progpro_kanban'];
							}
						}
                                                
                                                $pdf->SetWidths(array(36,310,28));
//srand(microtime()*1000000);  
    $pdf->Row(array(
   
      $list_ped['prokandet_nroped'],//PEDIDO
     $cadena,//KANBAN
      $list_ped['cantidad']//CANTIDAD
      

         ));
					 
					/*
						if(strlen($cadena)>= 200){
						$y1 = $pdf->GetY();
						$x1 = $pdf->GetX();
						
						$pdf->multicell(310, 5,$cadena, 1);
						$y2 = $pdf->GetY();
						$alto_de_fila = $y2 - $y1 ;
						$posicionX = $x1 + 310;
						$pdf->SetXY($posicionX,$y1);
						
						 $pdf->Cell(28,10,$list_ped['cantidad'],1,0,'C');
						  $pdf->ln();
					}else{
						 $pdf->Cell(310,10,$cadena,1,0,'L');
						  $pdf->Cell(28,10,$list_ped['cantidad'],1,0,'C');
                                                  $pdf->ln();
					}
*/
					}
					 
				}
			}

		$pdf->ln(10);
	}
}

$pdf->addPage();


$pdf->SetFillColor(2,157,116);
$pdf->Cell(400, 12, utf8_decode("CONVERSIÓN"), 1, 0, 'C',1);
$pdf->ln(13);
 $art_unico_imp = $planificacion->artUnicoStock_sgteProc($conversion);
if($art_unico_imp){ 
	foreach($art_unico_imp as $list_codart){
			$b++;
			$pdf->SetFont('Arial','B',10);

		$pdf->SetFillColor(201, 201, 201);
		$pdf->Cell(26,10,'',0,0,'C',0);
		$pdf->Cell(6,10,utf8_decode($b),1,0,'C',1);
		$pdf->Cell(30,10,$list_codart['codart'],1,0,'C',1);
		$pdf->Cell(310,10,utf8_decode ($list_codart['desart']),1,0,'L',1);
		$pdf->Cell(28,10,$list_codart['total'],1,0,'C',1);

	$pdf->ln();
		$pdf->SetFont('Arial','',10);
		 $detalle_resumen_stock_imp_op =$planificacion->ordenPedCan_sgteProc($conversion,$list_codart['codart']);
		
		
			if($detalle_resumen_stock_imp_op){ 
				foreach($detalle_resumen_stock_imp_op as $list_ped){
					if($list_codart['codart']== $list_ped['codart']){
					 $pdf->Cell(26,10,'',0,0,'C');
					//  $pdf->Cell(36,10,$list_ped['prokandet_nroped'],1,0,'C');
					 $cadena='';
					 $art_det_kanban_imp = $planificacion->DetstockXkanbanXproceso_sgteProc($conversion,$list_ped['codart'],$list_ped['prokandet_nroped']);
						if($art_det_kanban_imp){ 
							foreach($art_det_kanban_imp as $list_kanban){
								if($list_ped['codart']== $list_kanban['codart'] and $list_ped['prokandet_nroped'] ==$list_kanban['prokandet_nroped'] ){
									$cadena= $cadena.' [' .$list_kanban['progpro_kanban'].'] - ';
								}
							
								//$cadena= $cadena.' ' .$art_det_kanban_tel['progpro_kanban'];
							}
						}
                                                
                                                
                                                $pdf->SetWidths(array(36,310,28));
//srand(microtime()*1000000);  
    $pdf->Row(array(
   
      $list_ped['prokandet_nroped'],//PEDIDO
     $cadena,//KANBAN
      $list_ped['cantidad']//CANTIDAD
      

         ));
					/* 
					if(strlen($cadena)>= 200){
						$y1 = $pdf->GetY();
						$x1 = $pdf->GetX();
						
						$pdf->multicell(310, 5,$cadena, 1);
						$y2 = $pdf->GetY();
						$alto_de_fila = $y2 - $y1 ;
						$posicionX = $x1 + 310;
						$pdf->SetXY($posicionX,$y1);
						
						 $pdf->Cell(28,10,$list_ped['cantidad'],1,0,'C');
						  $pdf->ln();
					}else{
						 $pdf->Cell(310,10,$cadena,1,0,'L');
						  $pdf->Cell(28,10,$list_ped['cantidad'],1,0,'C');
                                                  $pdf->ln();
					}
					*/

					}
					 
				}
			}

		
		$pdf->ln(10);
	}
}

$pdf->addPage();
$pdf->SetFillColor(2,157,116);
$pdf->Cell(400, 12, utf8_decode("RESUMEN"), 1, 0, 'C',1);
$pdf->ln(13);
$pdf->SetFillColor(201, 201, 201);
		$pdf->Cell(26,10,'',0,0,'C',1);
		$pdf->Cell(26,10,utf8_decode('LAMINADO'),0,0,'C',1);
		$pdf->Cell(26,10,utf8_decode('IMPRESIÓN'),0,0,'C',1);
		$pdf->Cell(26,10,utf8_decode('CONVERSIÓN'),0,0,'C',1);
		$pdf->Cell(26,10,'TOTAL',0,0,'C',1);
		
		$tel_lam = $planificacion->ResuStockXproceso('167','168');
		$tel_imp = $planificacion->ResuStockXproceso('167','169');
		$tel_conv = $planificacion->ResuStockXproceso('167','170');
		
		
		$pdf->ln();
		$pdf->Cell(26,10,'TELARES','B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_lam),'B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_imp),'B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_conv),'B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_lam) + count($tel_imp)+count ($tel_conv),'B',0,'C',0);
		
		$pdf->ln();
		
		$lam_imp = $planificacion->ResuStockXproceso('168','169');
		$lam_conv = $planificacion->ResuStockXproceso('168','170');
		
		
		$pdf->Cell(26,10,utf8_decode('LAMINADO'),'B',0,'C',0);
		$pdf->Cell(26,10,'-','B',0,'C',0);
		$pdf->Cell(26,10,count ($lam_imp),'B',0,'C',0);
		$pdf->Cell(26,10,count ($lam_conv),'B',0,'C',0);
		$pdf->Cell(26,10,count ($lam_imp) + count ($lam_conv),'B',0,'C',0);
		
		
		$pdf->ln();
		
		
		$imp_conv = $planificacion->ResuStockXproceso('169','170');
		
		$pdf->Cell(26,10,utf8_decode('IMPRESIÓN'),'B',0,'C',0);
		$pdf->Cell(26,10,'-','B',0,'C',0);
		$pdf->Cell(26,10,'-','B',0,'C',0);
		$pdf->Cell(26,10,count ($imp_conv),'B',0,'C',0);
		$pdf->Cell(26,10,count ($imp_conv),'B',0,'C',0);
		
		$pdf->ln();
		
		
		
		
		$pdf->Cell(26,10,utf8_decode('TOTAL'),'B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_lam),'B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_imp)+count ($lam_imp) ,'B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_conv) + count ($lam_conv) + count ($imp_conv) ,'B',0,'C',0);
		$pdf->Cell(26,10,count ($tel_lam) + count($tel_imp)+count ($tel_conv) + count ($lam_imp) + count ($lam_conv) + count ($imp_conv),'B',0,'C',0);



$pdf->Output();
?>
