
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
        
        if( $i == 1 or $i== 4 ){
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
    // $this->Cell(80, 10,utf8_decode("FOR-PDP-04/VERMAY2021"), 0, 0, 'C');
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
$pdf->Cell(340,12,utf8_decode("REPORTE STOCK POR LOTE"),0,0,'C');
$pdf->Cell(60,12,utf8_decode("AREA DE EXTRUSIÓN"),0,0,'R');
$pdf->ln();
//$pdf->Cell(400,12,utf8_decode("FOR-PDP-04/VERMAY2021"),0,0,'R');
$pdf->ln(15);
$pdf->SetFont('Arial','B',8);

$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(15,10,utf8_decode("N°"),1,0,'C',1);
$pdf->Cell(20,10,"CODIGO",1,0,'C',1);
$pdf->Cell(280,10,utf8_decode("DESCRIPCIÓN"),1,0,'C',1);
$pdf->Cell(30,10,"STOCK ENVASE",1,0,'C',1);
$pdf->Cell(30,10,"STOCK BOBINA",1,0,'C',1);
$pdf->Cell(30,10,utf8_decode("STOCK KILOS"),1,0,'C',1);



$pdf->Ln();
$pdf->SetFont('Arial','',9);

  $a= 0;
 $totenvases= 0;
 $totbobinas= 0;
 $totpeso= 0;
if($lista){
    
foreach ($lista as  $list) {
  $a++;
  
    // $pdf->Cell(15,7,$a,1,0,'C',1);
         //     $pdf->Cell(20,7,utf8_decode($list["artsemi_id"]),1,0,'C',1);
             //  $pdf->Cell(280,7,"  ".utf8_decode($list["artsemi_descripcion"]),1,0,'L',1);
               // $pdf->Cell(30,7,utf8_decode($list["artlot_cajfinal"]),1,0,'C',1);
               //  $pdf->Cell(30,7,utf8_decode($list["artlot_bobfinal"]),1,0,'C',1);
               //   $pdf->Cell(30,7,utf8_decode($list["stock"]),1,0,'C',1);
$totenvases= $totenvases + $list["artlot_cajfinal"];
 $totbobinas= $totbobinas + $list["artlot_bobfinal"];
 $totpeso= $totpeso  + $list["stock"];
    
    $pdf->SetWidths(array(15,20,280,30,30,30,));
//srand(microtime()*1000000);  
    $pdf->Row(array(
        $a, //ITEMS
  utf8_decode($list["artsemi_id"]),//codigo semiterminado
   "  ".utf8_decode($list["artsemi_descripcion"]),//descripcion de semiterminado
    utf8_decode($list["artlot_cajfinal"]) , //stock caja final
   utf8_decode($list["artlot_bobfinal"]),//stock bobina final
        
  utf8_decode($list["stock"]), // stock kilos
    
    
         ));
    
    $pdf->Ln(8);
      $stock_lote = new artsemiterminado();
      $lista_lote = $stock_lote->Lista_Art_x_lote($list["artsemi_id"]);
      
      $pdf->SetFillColor(201, 201, 201);
      $pdf->Cell(35,6,"",0,0,'C',0);
$pdf->Cell(15,6,utf8_decode("N°"),1,0,'C',1);
$pdf->Cell(37,6,"Lote",1,0,'C',1);
$pdf->Cell(37,6,utf8_decode("Cant. Inicial"),1,0,'C',1);
$pdf->Cell(37,6,"Cant. Final",1,0,'C',1);
$pdf->Cell(37,6,"Bob. Final",1,0,'C',1);
$pdf->Cell(39,6,utf8_decode("Caj. Final"),1,0,'C',1);
$pdf->Cell(39,6,utf8_decode("Fecha Ingreso"),1,0,'C',1);
$pdf->Cell(39,6,utf8_decode("Dias Transcurridos"),1,0,'C',1);
      
 $pdf->Ln();
 $b=0;
      if($lista_lote){
          foreach ($lista_lote as $lis_lot){
              $b++;
                $pdf->Cell(35,10,"",0,0,'C',0);
                $pdf->SetWidths(array(15,37,37,37,37,39,39,39));
//srand(microtime()*1000000);  
    $pdf->Row(array(
        $b, //ITEMS
  utf8_decode($lis_lot["promov_lote"]),//codigo lote
   "  ".utf8_decode($lis_lot["artlot_cantinicial"]),//stock inicial
    utf8_decode($lis_lot["suma"]) , //stock actual
   utf8_decode($lis_lot["artlot_bobfinal"]),//stock bobina final
        
  utf8_decode($lis_lot["artlot_cajfinal"]), // stock caja final
         utf8_decode($lis_lot["fecha_ingreso"]), // fecha ingreso
         utf8_decode($lis_lot["dias_trans"]), // dias transcurridos
    
    
         ));
          }
      }
 $pdf->Ln(8);
}

 }
 
                
$pdf->Output();
?>
