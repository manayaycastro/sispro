<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/extordentrabajo.php';
require_once 'model/areas.php';
require_once 'model/bitacora.php';
require_once 'model/usuarios.php';
require_once 'model/artsemiterminado.php';
require_once 'model/maquinas.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';

function _ajaxGetTipTuboAction() { //producción 2020

    $maquina = $_POST['maquina'];

    $maq = new maquinas();

    $lista = $maq->gettipTuboXmaquina($maquina);

    if (count($lista)):
        ?>
        <option value=-1>Selecione un tipo de tubo</option>
        <?php foreach ($lista as $list): ?>
            <option value="<?php echo $list['pespro_id'] ?>"
                    <?php  if (!empty($_GET["id"])): ?>
                            <?php   if ($list ['pespro_id'] == $extordentrabajo->getTip_tubo()): ?>
                     selected
                            <?PHP else: ?>
                              disabled="disabled"
                           <?PHP  endif; ?>
                    <?PHP  endif; ?>
                    
                    >
            <?php echo $list['pespro_descripcion']; ?>
            </option>
        <?php endforeach; ?> 
    <?php else : ?>
        <? echo '<option value=-1> No existen registros </option>'; ?>
    <?php endif; ?>
    <?php
}

function _ajaxregistrarproduccionAction() { //producción 2019


    $response = array();

    $usuario = $_SESSION['idusuario'];

    $extotpro_id = $_POST['extotpro'];
    $numcaja= $_POST['numcaja'];
    $numbob= $_POST['numbob'];
    $peso= $_POST['peso'];   
    $art= $_POST['art'];
    
    $tipdoc_id= $_POST['tipdoc_id'];
    $are_id= $_POST['are_id'];  
     
     
     
     
     //$extot_fecdoc= $_POST['extot_fecdoc'];
       $fec = $_POST["extot_fecdoc"];
      $date = date_create($fec);
$extot_fecdoc = date_format($date, 'Y-d-m H:i:s');
   
    
    $barcode = $_POST['barcode'];
    
    $accion= $_POST['accion'];
        $usr_nickname = $_SESSION["usuario"];
        
        
 $extotpro_tiptubo= $_POST['tubo'];// solo id de la tabla
  $extotpro_tipenvase= $_POST['envase'];
   $extotpro_numcarro= $_POST['carrito'];
   
   $lista_peso = new maquinas();
   $lista = $lista_peso->getConsultarPesos($extotpro_tiptubo,$extotpro_tipenvase,$extotpro_numcarro);
   
   if($lista){
       foreach ($lista as $list){
           if($list['pespro_id']== $extotpro_tiptubo ){
               $pesotub_total = $numbob*$list['pespro_peso'];
           }else if($list['pespro_id']== $extotpro_tipenvase){
               $pesoenv_total = $numcaja*$list['pespro_peso'];
           }else if ($list['pespro_id']== $extotpro_numcarro){
               $pesocarr_total = $list['pespro_peso'];
           }
       }
   }
   
   
   
   $peso_dest = $peso - ($pesotub_total + $pesoenv_total + $pesocarr_total);

    if ($accion == "agregar") {
        $estado = 1;
        $registrar = new extordentrabajo();
        $status = $registrar->registrar_produccionOT($extotpro_id,$numcaja,$numbob,$peso, $usr_nickname,$estado,$barcode,$extotpro_tiptubo,$extotpro_tipenvase,$extotpro_numcarro , $peso_dest);
        $status = $registrar->insertarCANTLote($art,$barcode, $peso_dest,$peso_dest, $usr_nickname,$numcaja,$numcaja,$numbob,$numbob);
        $status = $registrar->kardexsSEMITERMINADO($are_id,$tipdoc_id,$extot_fecdoc,$art ,"KG",$peso_dest,"0",$usr_nickname,$usr_nickname, $barcode,'0');

       
    } else {
        $estado = 1;
        $update = new extordentrabajo();
        $status = $update->update_produccionOT($extotpro_id,$estado,$usr_nickname );
        
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}

function _formsalidaAction() { //producción 2020  150220 084900
    $tipomov = 'salida';

    require 'view/salidacintas-form.php';
}

function _formreingresoAction() { //producción 2020  150220 084900
               $semiterminado  = new artsemiterminado();
    $listasemiterminado = $semiterminado->consultar2();

$tipomov = 'reingreso';
    require 'view/salidacintas-form.php';
}

function _ajaxGetMostrarsalidadetAction(){//verrrrrrrrrrrrrrrrrrrrrrr

     $movim = $_POST['movim'];
    $carro = new maquinas();
  $listacarro = $carro->getCarrito(); 
  
  if($movim == 'salida'){
       $codbarra = $_POST['codbarra'];
    
  $codbarra_mostrar = $_POST['codbarra_mostrar'];
  
  
  
 $listaitems = new extordentrabajo();
 $listar = $listaitems->regsalidacinta($codbarra);
  }else if($movim == 'reingreso'){
      
        $codart = $_POST['codbarra'];
//      
//      
//      
//      
//      
//       $codbarra = $_POST['codbarra'];
//    
//  $codbarra_mostrar = $_POST['codbarra_mostrar'];
      
       $listaitems = new extordentrabajo();
 $listar = $listaitems->regsalidacintaXart($codart);
  }
   

require_once 'view/vistahtml/salidaproduccion-form.php';
 


}

function _ajaxregistrarSalidProducAction() { //producción 2019


    $response = array();

    $usuario = $_SESSION['idusuario'];
        $movim = $_POST['movim'];
        if($movim == 'salida'){
           (float) $valormov = -1;
        }else{
             (float)$valormov = 1;
        }
    $insertsalida = (int) $_POST['insertsalida'];
    $numcaja= $_POST['numcaja'];
    $numbob= $_POST['numbob'];
    $peso= (float)round ($_POST['peso'],2);   
    
     $pesounitcaja= round ($_POST['pesounitcaja'],2);
      $pesounittub= round ($_POST['pesounittub'],2);
       $carro= round($_POST['carro'],2);
        $kanban= $_POST['kanban'];
    
    
      $numcajamov= round ($_POST['numcajamov'],2);
    $numbobmov= round ($_POST['numbobmov'],2);
    
    
    $pesomov= (float)((float)($_POST['pesomov']) - ((float)$pesounitcaja*(float)$numcajamov + (float)$numbobmov*(float)$pesounittub + (float)$carro ));
    //    $pesomov= $_POST['pesomov'];  
    
    
    $caj_fin = $numcaja + ($valormov)* $numcajamov;
    $bob_fin = $numbob + ($valormov)* $numbobmov;
    
    
//    $kil_fin = (float)(((float)$peso )+ (((float)$valormov)* ((float)$pesomov)));
  //  $kil_fin = (float)(((float)$peso )+ (((float)$valormov)* ((float)$pesomov)));
    $var = ((float)$valormov)* ((float)$pesomov);
    
    $kil_fin = (int)$peso + (int)$var;
 
    
    $art= $_POST['art'];
    
    $tipdoc_id= $_POST['tipdoc_id'];
    $are_id= $_POST['are_id'];   
    //$fecdoc= $_POST['fecdoc'];
        $fec =$_POST['fecdoc'];
      $date = date_create($fec);
$fecdoc = date_format($date, 'Y-d-m H:i:s');
    
    $barcode = $_POST['barcode'];
    

    
    $accion= $_POST['accion'];
    $usr_nickname = $_SESSION["usuario"];


    if ($accion == "agregar") {
        $estado = 1;
        $registrar = new extordentrabajo();
//        $status = $registrar->registrar_produccionOT($insertsalida,$numcaja,$numbob,$peso, $usr_nickname,$estado,$barcode);
        $status = $registrar->update_LOTEart($insertsalida,$caj_fin,$bob_fin,$kil_fin); //update de saldo que queda
        $status = $registrar->kardexsSEMITERMINADO($are_id,$tipdoc_id,$fecdoc,$art ,"KG",$pesomov*$valormov,"0",$usr_nickname,$usr_nickname, $barcode,$kanban);

       
    } else {
//        $estado = 1;
//        $update = new extordentrabajo();
//        $status = $update->update_produccionOT($insertsalida,$estado,$usr_nickname );
        
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}


function _ajaxregistrarReingProducAction() { //producción 2019


    $response = array();

    $usuario = $_SESSION['idusuario'];
        $movim = $_POST['movim'];
        if($movim == 'salida'){
            $valormov = -1;
        }else{
             $valormov = 1;
        }
    $insertsalida = $_POST['insertsalida'];
    $numcaja= $_POST['numcaja'];
    $numbob= $_POST['numbob'];
    $peso= $_POST['peso'];   
    
    $pesounitcaja= $_POST['pesounitcaja'];
      $pesounittub= $_POST['pesounittub'];
       $carro= $_POST['carro'];
        $kanban= $_POST['kanban'];
    
    
    
    
    
      $numcajamov= $_POST['numcajamov'];
    $numbobmov= $_POST['numbobmov'];
       $pesomov= $_POST['pesomov']- ($pesounitcaja*$numcajamov + $numbobmov*$pesounittub + $carro );
//    $pesomov= $_POST['pesomov'];   
    
    $caj_fin = $numcaja + ($valormov)* $numcajamov;
    $bob_fin = $numbob + ($valormov)* $numbobmov;
    
    
    $kil_fin = $peso + ($valormov)* $pesomov;
    
    
    
    $art= $_POST['art'];
    
    $tipdoc_id= $_POST['tipdoc_id'];
    $are_id= $_POST['are_id'];   
   
   
      $fec =$_POST['fecdoc'];
      $date = date_create($fec);
$fecdoc = date_format($date, 'Y-d-m H:i:s');  
    //$fecdoc= $_POST['fecdoc'];
    
    $barcode = $_POST['barcode'];
    

    
    $accion= $_POST['accion'];
        $usr_nickname = $_SESSION["usuario"];


    if ($accion == "agregar") {
        $estado = 1;
        $registrar = new extordentrabajo();
//        $status = $registrar->registrar_produccionOT($insertsalida,$numcaja,$numbob,$peso, $usr_nickname,$estado,$barcode);
        $status = $registrar->update_LOTEart($insertsalida,$caj_fin,$bob_fin,$kil_fin); //update de saldo que queda
        $status = $registrar->kardexsSEMITERMINADO($are_id,$tipdoc_id,$fecdoc,$art ,"KG",$pesomov*$valormov,"0",$usr_nickname,$usr_nickname, $barcode,$kanban);

       
    } else {
//        $estado = 1;
//        $update = new extordentrabajo();
//        $status = $update->update_produccionOT($insertsalida,$estado,$usr_nickname );
        
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}











































function _formAction() {//producción 2019
    require 'view/menu-form.php';
}

function _listarAction() {    //producción 2019
   

    require 'view/paradas-registro.php';
}


function _registroparadasAction() {    //producción 2019
   
    
     $area = new areas();
    $areas = $area->consultar();

    require 'view/paradas-registro2.php';
}

function _ajaxGetParadasAction(){

        
//     $area = new areas();
//    $areas = $area->consultar();

    
        $bitacora = new bitacora();
    $listar = $bitacora->consultar();
    require_once 'view/tablas/ajax-paradas.php';

}


//************************prueba******************



function _registroparadas2Action() {    //producción 2019
   
    
     $area = new areas();
    $areas = $area->consultar();

    require 'view/paradas-registro2.php';
}
function _ajaxGetParadas2Action(){

            $area = new areas();
    $areas = $area->consultar();
    
//     $bitacora = new bitacora();
//    $listar = $bitacora->consultar();

    require_once 'view/tablas/ajax-paradas2.php';

}


    function _cargarporempAction(){
        
       
//        $opc = '9020352';
//                 $_POST["cmbreporte"];
 
     $html = ""; 
    $html .= "<div class='row-fluid'  >";

  
         $html .= "<div class='row'>";
                   $html .= "<div class='col-xs-12'>";
                             $html .= "<div class='row'>";
                                       $html .= "<div class='col-xs-12' >";
                                                 $html .= "<div class='col-xs-12'>"; 
                                                         $html .= "<div class='col-xs-9'>";
                                                                 $html .= "<h4 class='header smaller lighter blue'>Cantidad de registros <span class='badge'>  50 </span></h4>";
                                                                 
                                                         $html .= "</div>";

                                                 $html .="</div>";
                                                 $html .= "<br>";
                                                 $html .= "<div class='clearfix'>";
                                                           $html .= "<div class='pull-right tableTools-container'></div>";
                                             $html .="</div>";
                                            $html .= " <div class='table-header'>";
                                             $html .= "Results for 'Latest Registered Domains'";
                                             $html .= "</div>   <div  >";
                                                
                                                 $html .=" <table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
                                                     $html .= "<thead>";
                                                        $html .= " <tr>";
                                                             $html .= "<th class='center'>";
                                                                 $html .= "<label class='pos-rel'>";
                                                                    $html .= " <input type='checkbox' class='ace' />";
                                                                    $html .= " <span class='lbl'></span>";
                                                              $html .="   </label>   </th>   <th>Id</th>     <th>Titulo</th>";
                                                            $html .= "<th class='hidden-480'>Estado</th>";
                                                           $html .= "<th>";
                                                               $html .="   <i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
                                                             $html .="    Fecha Registro <th>Acción</th> </tr>   </thead>  <tbody    >";
                                                       $html .= "   <tr>";
                                                                $html .= "     <td class='center'>  <label class='pos-rel'> ";
                                                                     $html .="        <input type='checkbox' class='ace' />   <span class='lbl'></span>";
                                                                     $html .= "    </label>  </td>
                                                                    
                                                                    <td > hola  </td>
                                                                    <td >  nesto </td>
                                                                    <td > d  </td>
                                                                    <td > ff  </td>
                                                                    <td >  sd </td>
                                                                    
                                                                    
                                                       </tr>
                                                    </tbody>
                                                </table>
       
         
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
   
                              
                        </div> ";
 
   

    echo $html;
}
  


?>

        
        
