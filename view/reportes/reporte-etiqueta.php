
<?php
require 'view/fpdf17/fpdf.php';
include 'view/barcode.php';
$meses = array('01' => 'ENERO','02' => 'FEBRERO','03' => 'MARZO','04' => 'ABRIL','05' => 'MAYO','06' => 'JUNIO'
  ,'07' => 'JULIO','08' => 'AGOSTO','09' => 'SEPTIEMBRE','10' => 'OCTUBRE','11' => 'NOVIEMBRE','12' => 'DICIEMBRE');


class PDF extends FPDF{

function Footer()
  {
    // To be implemented in your own inherited class
    //$this->Ln(2);
    $this->SetY(-3);
    $this->SetFont('Arial','B',8);      
$this->Cell(90,2,utf8_decode("Fecha de Impresión: ").date("d-m-Y H:i"),0,0,'R');    
  }

  function Header()  {
    // To be implemented in your own inherited class
    //$this->Ln(2);
    $this->SetFont('Arial', 'B', 8);
    $this->Image("view/img/logo.png",5, 2, 15, 5);
    $this->Image("view/img/logo.png", 80, 2, 15, 5);
     $this->Setx(30); 
          $this->SetY(5); 
    $this->Cell(90,2, "EL AGUILA SRL", 0, 10, 'C');
      $this->SetFont('Arial', 'B',5);
      $this->ln();//$this->ln();
       date_default_timezone_set('America/Lima');
       //$this->Cell(90,2, date("d-m-Y"), 0, 5, 'C');
 
    $this->Cell(90,1, "FABRICACION DE SACOS Y TELAS DE POLIPROPILENO", 0, 0, 'C');
  
    $this->Ln(2);
    $this->Cell(90, 1, "DIR1: Av. Bolivar # 395 Moshoqueque - Chiclayo - Peru", 0, 0, 'C');
     $this->Ln(2);
    $this->Cell(90, 1, "DIR1: Via Evitamiento  km 2.5 Sector Chacupe - La Victoria", 0, 0, 'C');
       $this->Ln(2);
    $this->Cell(90, 1, "Email: Ventas@elaguila.com.pe / floayza@elaguila.com.pe", 0, 0, 'C');
    
        $this->Ln(2);
    $this->Cell(90, 1, "Telefono: (074) 608405 / (074) 252851", 0, 0, 'C');
 

 
//     $this->ln(1);
      
  }
 function EAN13($x, $y, $barcode, $h = 16, $w = .35, $fSize = 9) {
        $this->Barcode($x, $y, $barcode, $h, $w, $fSize, 13);
    }

    function UPC_A($x, $y, $barcode, $h = 16, $w = .35, $fSize = 9) {
        $this->Barcode($x, $y, $barcode, $h, $w, $fSize, 12);
    }

    function GetCheckDigit($barcode) {
        //Compute the check digit
        $sum = 0;
        for ($i = 1; $i <= 11; $i+=2)
            $sum+=3 * $barcode[$i];
        for ($i = 0; $i <= 10; $i+=2)
            $sum+=$barcode[$i];
        $r = $sum % 10;
        if ($r > 0)
            $r = 10 - $r;
        return $r;
    }

    function TestCheckDigit($barcode) {
        //Test validity of check digit
        $sum = 0;
        for ($i = 1; $i <= 11; $i+=2)
            $sum+=3 * $barcode[$i];
        for ($i = 0; $i <= 10; $i+=2)
            $sum+=$barcode[$i];
        return ($sum + $barcode[12]) % 10 == 0;
    }

    function Barcode($x, $y, $barcode, $h, $w, $fSize, $len) {
        //Padding
        $barcode = str_pad($barcode, $len - 1, '0', STR_PAD_LEFT);
        if ($len == 12)
            $barcode = '0' . $barcode;
        //Add or control the check digit
        if (strlen($barcode) == 12)
            $barcode.=$this->GetCheckDigit($barcode);
        elseif (!$this->TestCheckDigit($barcode))
            $this->Error('Incorrect check digit');
        //Convert digits to bars
        $codes = array(
            'A' => array(
                '0' => '0001101', '1' => '0011001', '2' => '0010011', '3' => '0111101', '4' => '0100011',
                '5' => '0110001', '6' => '0101111', '7' => '0111011', '8' => '0110111', '9' => '0001011'),
            'B' => array(
                '0' => '0100111', '1' => '0110011', '2' => '0011011', '3' => '0100001', '4' => '0011101',
                '5' => '0111001', '6' => '0000101', '7' => '0010001', '8' => '0001001', '9' => '0010111'),
            'C' => array(
                '0' => '1110010', '1' => '1100110', '2' => '1101100', '3' => '1000010', '4' => '1011100',
                '5' => '1001110', '6' => '1010000', '7' => '1000100', '8' => '1001000', '9' => '1110100')
        );
        $parities = array(
            '0' => array('A', 'A', 'A', 'A', 'A', 'A'),
            '1' => array('A', 'A', 'B', 'A', 'B', 'B'),
            '2' => array('A', 'A', 'B', 'B', 'A', 'B'),
            '3' => array('A', 'A', 'B', 'B', 'B', 'A'),
            '4' => array('A', 'B', 'A', 'A', 'B', 'B'),
            '5' => array('A', 'B', 'B', 'A', 'A', 'B'),
            '6' => array('A', 'B', 'B', 'B', 'A', 'A'),
            '7' => array('A', 'B', 'A', 'B', 'A', 'B'),
            '8' => array('A', 'B', 'A', 'B', 'B', 'A'),
            '9' => array('A', 'B', 'B', 'A', 'B', 'A')
        );
        $code = '101';
        $p = $parities[$barcode[0]];
        for ($i = 1; $i <= 6; $i++)
            $code.=$codes[$p[$i - 1]][$barcode[$i]];
        $code.='01010';
        for ($i = 7; $i <= 12; $i++)
            $code.=$codes['C'][$barcode[$i]];
        $code.='101';
        //Draw bars
        for ($i = 0; $i < strlen($code); $i++) {
            if ($code[$i] == '1')
                $this->Rect($x + $i * $w, $y, $w, $h, 'F');
        }
        //Print text uder barcode
        $this->SetFont('Arial', '', $fSize);
        $this->Text($x, $y + $h + 11 / $this->k, substr($barcode, -$len));
    }
}


//
$pdf=new PDF('P', 'mm', array(128.6,100));


$pdf->SetMargins(2, 2 , 2);
$pdf->AddPage();



//$pdf->EAN13(24, 11, $id,7,0.5,10);
//(cordenada x ,
// cordenada y, 
// texto,
// alto de las barras,
// espacio entre barras,
// tamaño del texto de barras,
// ancho de las barras)
$pdf->Ln(2);
if($datos){
    foreach ($datos as $lista){
         $pdf->SetFont('Arial','B',8);
$pdf->Ln(1);
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,5,"Op:",0,0,'R',0);
$op = $lista['nroped'];
$pdf->Cell(25,5,"  "."$op",0,0,'');
$pdf->Cell(15,5,"Kanban:",0,0,'C',0);
$pdf->Cell(44,5,$lista['prefila_kanbas'],0,0,'L',0);

$pdf->Ln(4);


$pdf->Cell(18,5,"Codigo:",0,0,'R',0);

$pdf->Cell(25,5,"  ".$lista['codigofin'],0,0,'');
$pdf->Cell(15,5,"Cod. Alt.:",0,0,'C',0);
$pdf->Cell(44,5,"  ".$lista['codaltfin'],0,0,'',0);




       
$pdf->Ln(4);
$pdf->Cell(18,5,"Producto:",0,0,'R',0);
$pdf->SetFont('Arial','B',7);
$pdf->MultiCell(80, 4,utf8_decode( "  ".$lista['descripcionfin']),0,'L');
       $pdf->SetFont('Arial','B',8);
       
       
  $pdf->Ln(1);     
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,5,"Cantidad:",0,0,'R',0);

$pdf->Cell(40,5,"  ".$lista['prefila_cantidad_fin'] ." Und.",0,0,'');
$pdf->Cell(15,5,"Peso:",0,0,'C',0);
$pdf->Cell(44,5,$lista['prefila_peso']. " Kg.",0,0,'L',0);



  $pdf->Ln();     
$pdf->SetFillColor(201, 201, 201);
$pdf->Cell(18,5,"Fec. Creac:",0,0,'R',0);

$pdf->Cell(40,5,"  ".$lista['fecha_modif'],0,0,'');
$pdf->Cell(15,5,"Turno:",0,0,'C',0);

if($turnos){
    foreach ($turnos as $turno){
        if($lista['fec_turno']> $turno['tur_inicio'] and $lista['fec_turno']< $turno['tur_fin']){
            $pdf->Cell(44,5,utf8_decode($turno['tur_titulo']),0,0,'L',0);
        }
    }
}

$pdf->Cell(44,10,'',0,0,'L',0);

$pdf->Ln(1);
$pdf->SetFillColor(201, 201, 201);
 $pdf->SetFont('Arial', 'B', 6); 
 
 $pdf->SetFillColor(null, null, null);
$pdf->EAN13(30, 50, $id,5,0.5,10);


    }
    
}

                
$pdf->Output();
?>
