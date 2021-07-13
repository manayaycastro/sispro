
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
        
        if( $i== 2 or$i == 4 or $i == 6 or $i== 8  ){
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
   //$this->Cell(400, 2, utf8_decode("Relación de Artículo - Cintas - Formulación"), 0, 0, 'C');
    $this->ln(4); 
    $this->Line(45,25,400,25);

    $this->ln(16); 
  
      
  }

}

//420*297

$pdf=new PDF('L', 'mm', array(297.18,420.1));


//$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(5, 10 , 10);
$pdf->AddPage();
//$pdf=new PDF('L', 'mm', 'A3');
$pdf->SetMargins(5, 5 , 5);

$pdf->SetFont('Arial','B',15);

//$pdf->Cell(300,10,utf8_decode("Relación de Artículo - Cintas - Formulación"),0,0,'C',0);
$pdf->ln(5);
$pdf->SetFont('Arial','B',10);


$pdf->SetFillColor(108, 112, 186);
$pdf->Cell(11,10,"Items",1,0,'C',1);
   $x = $pdf->GetX();
    $y = $pdf->GetY();
$pdf->MultiCell(15,5,utf8_decode("Cod. Neluge"),1,'C',1);

$pdf->SetXY($x+15,$y);
  $a = $pdf->GetX();
    $b = $pdf->GetY();
$pdf->MultiCell(25,5,utf8_decode("Cod. Siempresoft"),1,'C',1);
 $pdf->SetXY($a+25,$b);

  $c = $pdf->GetX();
    $d = $pdf->GetY();
    $pdf->MultiCell(55,10,utf8_decode("Descripción de artículo"),1,'C',1);
 $pdf->SetXY($c+55,$d);

$pdf->Cell(20,10,"Tipo",1,0,'C',1);
$pdf->Cell(40,10,utf8_decode("Cliente"),1,0,'C',1);
$e = $pdf->GetX();
    $f = $pdf->GetY();
$pdf->MultiCell(25,5,utf8_decode("Nombre de Máquina"),1,'C',1);
$pdf->SetXY($e+25,$f);

$g = $pdf->GetX();
    $h = $pdf->GetY();
$pdf->MultiCell(30,5,utf8_decode("Fecha de Producción"),1,'C',1);
$pdf->SetXY($g+30,$h);
$pdf->Cell(18,10,"Turno",1,0,'C',1);
$pdf->Cell(18,10,"Hora",1,0,'C',1);
$m = $pdf->GetX();
    $n = $pdf->GetY();
    $pdf->MultiCell(22,5,utf8_decode("Mtrs. Solicitado"),1,'C',1);
    $pdf->SetXY($m+22,$n);
$pdf->Cell(18,10,"Cod. Reg.",1,0,'C',1);
$pdf->Cell(18,10,"Rollo ID",1,0,'C',1);
$pdf->Cell(18,10,"OP",1,0,'C',1);
$pdf->Cell(18,10,"Kanban",1,0,'C',1);
$pdf->Cell(18,10,"Metros",1,0,'C',1);
$pdf->Cell(18,10,"Peso",1,0,'C',1);
$j = $pdf->GetX();
    $k = $pdf->GetY();
$pdf->MultiCell(22,5,utf8_decode("Peso Proyectado"),1,'C',1);
$pdf->SetXY($j+22,$k);

$pdf->Ln(10);



$pdf->SetFont('Arial','',9);

$pdf->SetFillColor(201, 201, 201);

$a=0;
 
    if($lista_resumen){
        foreach ($lista_resumen as $list){
            $a++;
               $pdf->SetWidths(array(11,15,25,55,20,40,25,30,18,18,22,18,18,18,18,18,18,22));

    $pdf->Row(array(
     $a, //ITEMS
  utf8_decode($list["artsemi_id"]),//codigo semiterminado
         utf8_decode($list["codart"]),//codigo Siempresoft
   "  ".utf8_decode($list["desart"]),//descripcion de semiterminado
    utf8_decode($list["prokandet_tipo"]) , //tipo producto
 

       
        
         utf8_decode($list["razonsocial"]),//razon social
         utf8_decode($list["maq_nombre"]),//nombre de la maquina
         
        utf8_decode($list["fechaproduccion"]),//fecha produccion
         utf8_decode($list["Turno"]),//turno
         utf8_decode($list["horareg"]),//hora registros
         utf8_decode($list["prokandet_mtrs"]),//metros planificados
  utf8_decode($list["prorolldet_id"]),//id rolldet
                
  utf8_decode($list["proroll_id"]), //codigo de rollo
      utf8_decode($list["prokandet_nroped"]),//nro pedido
        
        
          utf8_decode($list["progpro_kanban"]),//kanban
        
         utf8_decode($list["prorolldet_mtrs"]),//nro pedido
         utf8_decode($list["prorolldet_peso"]),//nro pedido
         utf8_decode($list["prorolldet_peso"]),//nro pedido
         ));
        }   
    }
   
    
$pdf->Output();
?>
