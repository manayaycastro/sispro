
<?php

require 'view/fpdf17/fpdf.php';
include 'view/barcode.php';
$meses = array('01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO'
    , '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');

class PDF extends FPDF {

    function Footer() {
        // To be implemented in your own inherited class
        //$this->Ln(2);
        $this->SetY(-15);
         $this->Cell(35, 5, "", 0, 0, 'C'); //no texto 
    $this->Cell(40, 5, "SUPERVISOR DE VENTAS", 'T', 0, 'C');
     $this->Cell(40, 5, "", 0, 0, 'C'); //no texto 
    $this->Cell(40, 5, "PLANIFICACION", 'T', 0, 'C');
    
     $this->Ln(); //no texto 
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(330, 10, utf8_decode("Fecha de creación: ") . date("d-m-Y H:i") . "             " . "Pag " . $this->PageNo(), 0, 0, 'C');
    }

    function Header() {
        // To be implemented in your own inherited class
        //$this->Ln(2);
               date_default_timezone_set('America/Lima');
        $this->SetFont('Arial', '', 10);
//    $this->Image("view/img/logo.png",5, 5, 15, 10);
//    $this->Image("view/img/logo.png", 190, 5, 15, 10);
    }

}

$pdf = new PDF();
$pdf->AddPage();
  ini_set('date.timezone','America/Lima'); 
if ($opedidos) {
    foreach ($opedidos as $opedido) {

        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(155, 4, "EL AGUILA SRL", 0, 0);
        $pdf->Cell(15, 4, "FECHA", 0, 0);
        $pdf->Cell(2, 4, ": ", 0, 0);
        $pdf->Cell(20, 4, date("d/m/yy"), 0, 0);
        $pdf->ln(4);
        $pdf->Cell(155, 4, "20395263952 ", 0, 0);
        $pdf->Cell(15, 4, "HORA", 0, 0);
        $pdf->Cell(2, 4, ": ", 0, 0);
        $pdf->Cell(20, 4, date("H:i:s"), 0, 0);
        $pdf->ln();
        $pdf->Cell(40, 7, "ORDEN DE PEDIDO : ", 0, 0);
        $pdf->Cell(20, 7, $opedido['nroped'], 1, 0, 'C');
        $pdf->ln();
        
        $pdf->Rect(10, 25, 120, 24, '');
        $pdf->Rect(135, 25, 65, 24, '');
        $pdf->Cell(40, 5, " DATOS DEL CLIENTE ", 0, 0);
        $pdf->Cell(95, 5, "", 0, 0);
         $pdf->Cell(145, 5, " REGISTRO", 0, 0);
         $pdf->SetFont('Arial', '', 8);
         //INICIO DE PRIMERA FILA
         $pdf->ln();
          $pdf->Cell(25, 4,utf8_decode( " Código"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4,  $opedido['codcli'], 0, 0);
          
          $pdf->Cell(25, 4,utf8_decode( " RUC/DNI"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4, "20395263952", 0, 0);
          
           $pdf->Cell(21, 4, "", 0, 0);
          
          $pdf->Cell(26, 4,utf8_decode( "  Fecha Ord.Pedido"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4,  $opedido['fecped'], 0, 0);
          
           //FIN DE PRIMERA FILA
         $pdf->ln();
           //INICIO DE SEGUNDA FILA
          $pdf->Cell(25, 4,utf8_decode( " Clte. Principal"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);

          $pdf->MultiCell(90, 4, utf8_decode ( $opedido['razonsocialprincipal']), 0);
           
            $pdf->Setx(90); 
          $pdf->SetY(34); 
          $pdf->Cell(125, 4, "", 0, 0);
           $pdf->Cell(26, 4,utf8_decode( "  Fecha de entrega"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4,  $opedido['fechaentrega'], 0, 0);
           //FIN DE SEGUNDA FILA
           $pdf->ln();
           //INICIO DE TERCERA FILA
            $pdf->Cell(125, 4, "", 0, 0);
          
           $pdf->Cell(26, 4,utf8_decode( "  Tiempo de entrega"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4,  $opedido['difer'] ." dias", 0, 0);
           //FIN DE TERCERA FILA
          
          $pdf->ln();
           //INICIO DE CUARTA FILA
            $pdf->Cell(125, 4, "", 0, 0);
          
           $pdf->Cell(26, 4,utf8_decode( "  Condicion de pago"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4,  $opedido['nomconpag'], 0, 0);
          //FIN DE CUARTA FILA
          
          $pdf->ln(8);
          
           //INICIO DE quinta FILA
          $pdf->Cell(25, 4,utf8_decode( " Vendedor"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(65, 4,  $opedido['apellidos']." ".$opedido['nombres'], 0, 0);
           $pdf->Cell(33, 4, "", 0, 0);
         $pdf->Cell(26, 4,utf8_decode( "  Recoge clase B"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(15, 4, "" , 0, 0);
           //FIN DE quinta FILA
          
          $pdf->ln(5);
          
           $pdf->Rect(10, 55, 190, 24, '');
            //INICIO DE SEXTA FILA
             $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(40, 5, " DATOS DEL PRODUCTO ", 0, 0);
            $pdf->ln();
            
              $pdf->SetFont('Arial', '', 8);
           $pdf->Cell(25, 4,utf8_decode( " Código"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4,  $opedido['codart'], 0, 0);
          
          $pdf->Cell(25, 4,utf8_decode( " Código alterno"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4, $opedido['codalt'], 0, 0);
            //FIN DE SEXTA FILA codalt
          $pdf->ln();
          
          //INICIO DE SEPTIMA FILA
          $pdf->Cell(25, 4,utf8_decode( " Descripción"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->MultiCell(160, 4,  $opedido['desart'], 0,'L');
          
            //FIN DE SEPTIMA FILA
          $pdf->ln(1);
                    
           //INICIO DE OCTAVA FILA
            $pdf->Cell(25, 4,utf8_decode( " Cantidad (+3%)"), 0, 0);
          $pdf->Cell(2, 4, ": ", 0, 0);
          $pdf->Cell(25, 4,  number_format ($opedido['cantped']), 0, 0);
           //INICIO DE OCTABA FILA
           $pdf->ln(12);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(90, 5, utf8_decode("CARÁCTERISTICAS TÉCNICAS"), 'B', 0);
            $pdf->Cell(2, 5, "  ", 'B', 0);
            $pdf->Cell(40, 5, utf8_decode("VALOR"), 'B', 0);
            
            $categoria = new opedido();
            $categorias = $categoria->consultarCatporarticulo($opedido['codart']) ;
            $valores = $categoria->MostrarValorXCatporarticulo($opedido['codart']);
            
            $pdf->ln();
            
            if($categorias){
                foreach ($categorias as $lista){
                    $pdf->SetFont('Arial', 'B', 8); 
                     $pdf->Cell(90, 5, utf8_decode($lista['descategoria']), 0, 0);
                       $pdf->ln();
                        if($valores){
                            foreach ($valores as $valor){
                               
                                if($valor['descategoria'] == $lista['descategoria'] ){
                                     $pdf->SetFont('Arial', '', 8); 
                                    $pdf->Cell(5, 5, "  ", 0, 0);
                                    $pdf->Cell(60, 5, utf8_decode($valor['descaracteristica']), 0, 0);
                                    $pdf->Cell(27, 5, " : ", 0, 0);
                                    $pdf->Cell(35, 5, utf8_decode($valor['valcartecnica']),0, 0);
                                     $pdf->ln();
                                }
                            }
                        }
                    
                }
            }
            
            
            
    }
}



$pdf->Output();
?>
