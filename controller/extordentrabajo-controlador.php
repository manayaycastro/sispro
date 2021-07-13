<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/maquinas.php';
require_once 'model/areas.php';
require_once 'model/extordentrabajo.php';
require_once 'model/artsemiterminado.php';
require_once 'model/usuarios.php';
require_once 'model/produccion.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';

function _listarAction() { //producción 2020 150220 084600
    $extot = new extordentrabajo();
    $extordentrabajo = $extot->consultar();

$id_usuario = $_SESSION["idusuario"];
    require 'view/extordentrabajo-registro.php';
}

function _listarOTAction() { //producción 2020 150220 084600
    $extot = new extordentrabajo();
   // $extordentrabajo = $extot->consultar();


    require 'view/extordentrabajov01-registro.php';
}

function _formAction() { //producción 2020  150220 084900
     if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        // $idmaq = $_POST['idmaq'];
    } else {
        $id = 0;
       //  $idmaq ='0';
    }
       

      $extordentrabajo = new extordentrabajo();
    $extordentrabajo->obtenerxId($id);
    $are_id = $_SESSION['are_id'];
  
    $permiso = "enabled";
    $tipdoc = new produccion();
    $tipdocumentos = $tipdoc->consultartipdoc($are_id);
    
    $turnos= $tipdoc->consultarturno();
    
  

    $area = new areas();
    $areas = $area->consultarActivos();

    
    $maquina = new maquinas();
    $maquinas = $maquina->ConsultarxArea('2');
    
//     $lista = $maquina->gettipTubo($idmaq);
    
    

    require 'view/extordentrabajo-form.php';
}


    function _cargardetalleAction(){ //produccion 2020 150220 084900
        
         $peine =  $_GET["peine"];
         $bajada =  $_GET["bajada"];
          $ot =  $_GET["ot"];
         
             $semiterminado  = new artsemiterminado();
    $listasemiterminado = $semiterminado->consultar2();
    
    $detot = new extordentrabajo();
    $listdet = $detot->listardetalleot($ot);
$semiterminado1 = ''    ;
$semiterminado2 = ''     ;
$ur1 = ''    ;
$tr1 = ''     ;
$ur2 = ''    ;
$tr2 = ''     ;
$a=0;
    if($listdet){
        foreach ($listdet as $list){ 
                $a++;
                if($a== '1'){
                     $semiterminado1 =   $list["artsemi_id"]; 
                     if( $list["extotdet_tipcinta"] == 'tr1'){
                         $tr1 =$list["extotdet_tipcinta"];
                     }elseif( $list["extotdet_tipcinta"] == 'ur1'){
                          $ur1 =$list["extotdet_tipcinta"]; 
                     }
                }elseif($a== '2'){
                       $semiterminado2 =   $list["artsemi_id"];  
                       
                       if( $list["extotdet_tipcinta"] == 'tr2'){
                         $tr2 =$list["extotdet_tipcinta"];
                     }elseif( $list["extotdet_tipcinta"] == 'ur2'){
                          $ur2 =$list["extotdet_tipcinta"]; 
                     }
                }
          
       }
    }

$html = "";
if($peine == '0'){
    
    
        $html .="<tr>";
                        $html .="<td>";
                                $html .= "<input type='text' name='items1' id='items1' value='1' readonly='readonly'>";
                        $html .="</td>";

                        $html .="<td class='hidden-480'>";
                                $html .="<select name='lado1' id='lado1'>";
                                    $html .= "<option selected value='Lado A y B'>Lado A y B</option>";
                                    $html .="<option disabled='disabled' value='Lado A'>Lado A</option>";
                                    $html .="<option disabled='disabled' value='Lado B'>Lado B</option>";
                                $html .= "</select>";
                        $html .="</td>";
                        
                        $html .= "<td>";
                                $html .= "<select name='semiterminado1' id='semiterminado1' class='chosen-select form-control' >";
                                           if($listasemiterminado){ 
                                           foreach ($listasemiterminado as $lista){ 
                                               
                                                    
                                                    $html .= "<option value='".  $lista['artsemi_id']."'";
                                                    if($lista['artsemi_id'] ==$semiterminado1 ){
                                                           $html .="selected";
                                                    }
                                                    
                                                    $html .= "> (".$lista['artsemi_id'].") ".$lista ['artsemi_descripcion']." </option>";
                                           }
                                           }                            
                                $html .= "</select>";
                                                                        
                        $html .= "</td>";
                        
                        $html .= "<td class='hidden-480'>";
                                $html .= "<select name='tipcinta1' id='tipcinta1' class='chosen-select form-control'>";
                                        $html .= "<option value='tr1'";
                                            if("tr1" == $tr1){
                                               $html .="selected"; 
                                            }
                                        $html .=">Trama</option>";
                                        
                                        $html .= "<option value='ur1'";
                                         if("ur1" == $ur1){
                                               $html .="selected"; 
                                            }
                                         $html .=">Urdimbre</option>";
                                                                              
                                $html .="</select>";
                                
                        $html .= "</td>";
                        
                        $html .="<td>";
                                $html .="<input type='text' name='bajada1'  id='bajada1' value='".$bajada."' readonly='readonly'>";
                        $html .="</td>";

                $html .="</tr>";
}else{
    
    
                         
                $html .="<tr>";
                        $html .="<td>";
                                $html .= "<input type='text' name='items1' id='items1' value='1' readonly='readonly'>";
                        $html .="</td>";

                        $html .="<td class='hidden-480'>";
                                $html .="<select name='lado1' id='lado1'>";
                                    $html .= "<option  disabled='disabled'  value='Lado A y B'>Lado A y B</option>";
                                    $html .="<option  selected  value='Lado A'>Lado A</option>";
                                    $html .="<option   disabled='disabled' value='Lado B'>Lado B</option>";
                                $html .= "</select>";
                        $html .="</td>";
                        
                        $html .= "<td>";
                                $html .= "<select name='semiterminado1' id='semiterminado1' class='chosen-select form-control' >";
                                           if($listasemiterminado){ 
                                           foreach ($listasemiterminado as $lista){ 
                                                $html .= "<option value='".  $lista['artsemi_id']."'";
                                                    if($lista['artsemi_id'] ==$semiterminado1 ){
                                                           $html .="selected";
                                                    }
                                                    
                                                    $html .= "> (".$lista['artsemi_id'].") ".$lista ['artsemi_descripcion']." </option>";
                                           }
                                           }                            
                                $html .= "</select>";
                                                                        
                        $html .= "</td>";
                        
                        $html .= "<td class='hidden-480'>";
                                $html .= "<select name='tipcinta1' id='tipcinta1' class='chosen-select form-control'>";
                                        $html .= "<option value='tr1'";
                                            if("tr1" == $tr1){
                                               $html .="selected"; 
                                            }
                                        $html .=">Trama</option>";
                                        
                                        $html .= "<option value='ur1'";
                                         if("ur1" == $ur1){
                                               $html .="selected"; 
                                            }
                                         $html .=">Urdimbre</option>";
                                                                              
                                $html .="</select>";
                                
                        $html .= "</td>";
                        
                        $html .="<td>";
                                $html .="<input type='text' name='bajada1'  id='bajada1' value='".$bajada."' readonly='readonly'>";
                        $html .="</td>";

                $html .="</tr>";
                
                
                
                
                $html .="<tr>";
                        $html .="<td>";
                                $html .= "<input type='text' name='items2' id='items2' value='2' readonly='readonly'>";
                        $html .="</td>";

                        $html .="<td class='hidden-480'>";
                                $html .="<select name='lado2' id='lado2'>";
                                    $html .= "<option  disabled='disabled' value='Lado A y B'>Lado A y B</option>";
                                    $html .="<option  disabled='disabled' value='Lado A'>Lado A</option>";
                                    $html .="<option selected value='Lado B'>Lado B</option>";
                                $html .= "</select>";
                        $html .="</td>";
                        
                        $html .= "<td>";
                                $html .= "<select name='semiterminado2' id='semiterminado2' class='chosen-select form-control' >";
                                           if($listasemiterminado){ 
                                           foreach ($listasemiterminado as $lista){ 
                                                  $html .= "<option value='".  $lista['artsemi_id']."'";
                                                    if($lista['artsemi_id'] ==$semiterminado2 ){
                                                           $html .="selected";
                                                    }
                                                    
                                                    $html .= "> (".$lista['artsemi_id'].") ".$lista ['artsemi_descripcion']." </option>";
                                           }
                                           }                            
                                $html .= "</select>";
                                                                        
                        $html .= "</td>";
                        
                        $html .= "<td class='hidden-480'>";
                                $html .= "<select name='tipcinta2' id='tipcinta2' class='chosen-select form-control'>";
                                         $html .= "<option value='tr2'";
                                            if("tr2" == $tr2){
                                               $html .="selected"; 
                                            }
                                        $html .=">Trama</option>";
                                        
                                        $html .= "<option value='ur2'";
                                         if("ur2" == $ur2){
                                               $html .="selected"; 
                                            }
                                         $html .=">Urdimbre</option>";
                                                                              
                                $html .="</select>";
                                
                        $html .= "</td>";
                        
                        $html .="<td>";
                                $html .="<input type='text' name='bajada2'  id='bajada2' value='".$bajada."' readonly='readonly'>";
                        $html .="</td>";

                $html .="</tr>";
            
    
}

       echo $html;
    }
    

    
    
    

function _verdetalleextordentrabajoAction() {//producción 2020 150220 101600
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);
    $idmaq = $filter->process($_GET['idmaq']);

     $are_id = $_SESSION['are_id'];
    $permiso = "disabled";
    
    $extordentrabajo = new extordentrabajo();
    $extordentrabajo->obtenerxId($id);
    
    $tipdoc = new produccion();
    $tipdocumentos = $tipdoc->consultartipdoc($are_id);
    
    $turnos= $tipdoc->consultarturno();
    
  

    $area = new areas();
    $areas = $area->consultarActivos();

    
    $maquina = new maquinas();
    $maquinas = $maquina->consultar();
    
   

    $lista = $maquina->gettipTubo($idmaq);
    



    require_once 'view/extordentrabajo-form.php';
}

function _modificarextordentrabajoAction() {//producción 2020 150220 101500
   $filter = new InputFilter();

    $id = $filter->process($_GET['id']);
    $idmaq = $filter->process($_GET['idmaq']);


     $are_id = $_SESSION['are_id'];
    $permiso = "enabled";
    
    $extordentrabajo = new extordentrabajo();
    $extordentrabajo->obtenerxId($id);
    
    $tipdoc = new produccion();
    $tipdocumentos = $tipdoc->consultartipdoc($are_id);
    
    $turnos= $tipdoc->consultarturno();
    
  

    $area = new areas();
    $areas = $area->consultarActivos();

    
    $maquina = new maquinas();
    $maquinas = $maquina->consultar();
    
        $lista = $maquina->gettipTubo($idmaq);


    require_once 'view/extordentrabajo-form.php';
}

function _insertarAction() { //producción 2020 150220 095600
    session_start();

    $filter = new InputFilter();


    $tipdoc_id = $filter->process($_POST["tipdoc_id"]);
    $codempl = $filter->process($_POST["codempl"]);
    $optionsRadios = $filter->process($_POST["optionsRadios"]);
    
    $are_id= $filter->process($_POST["are_id"]);
    $tur_id = $filter->process($_POST["tur_id"]);
    $maq_id = $filter->process($_POST["maq_id"]);
    
//$extot_fecdoc = $filter->process($_POST["extot_fecdoc"]);
    $extot_fecdoc_format = $filter->process($_POST["extot_fecdoc"]);
    
       $date = date_create($extot_fecdoc_format);
$extot_fecdoc = date_format($date, 'Y-d-m H:i:s');
    
    $value= $filter->process($_POST["value"]);
    $tip_tubo = $filter->process($_POST["tip_tubo"]);
    
    $observacion = $filter->process($_POST["observacion"]);
   
    $accion = '';
    $bucle = $optionsRadios +1;
    $usr_nickname = $_SESSION["usuario"];
     $usr = $_SESSION["idusuario"];
$formulacion_actual = '';
    try {
        if (!empty($_GET["id"])) {
  
            $id = $filter->process($_GET["id"]);
            $extordentrabajo = new extordentrabajo($id,$tipdoc_id,$codempl,$optionsRadios,$are_id,$tur_id,$maq_id,
                    $extot_fecdoc,$value,$tip_tubo,$observacion,null,$usr_nickname,null,$usr_nickname,null);
            $extordentrabajo->modificar();

            

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROEXTORDENTRABAJO', null, null);
            $bitacora->insertar();
        } else {
            $extordentrabajo = new extordentrabajo(null,$tipdoc_id,$codempl,$optionsRadios,$are_id,$tur_id,$maq_id,
            $extot_fecdoc,$value,$tip_tubo,$observacion,null,$usr_nickname,null,$usr_nickname,null);
            $extordentrabajo->insertar();
            
            $ultimoId = $extordentrabajo->consultarUltimoIDextot();
            if($ultimoId){
                foreach ($ultimoId as $ultid) {
                    $ult_id = $ultid["extot_id"];
                }
            }
            
                    for ($index = 1; $index <= $bucle; $index++) {
                        $items = $filter->process($_POST["items" . $index]);
                        $lado = $filter->process($_POST["lado" . $index]);
                        $semiterminado = $filter->process($_POST["semiterminado" . $index]);
                        $tipcinta = $filter->process($_POST["tipcinta" . $index]);

                        $inserdet = new extordentrabajo();
                        //buscamos formulacion vigente para  el articulo
                        $formulacion = $inserdet->FormulacionActual($semiterminado);
                        if($formulacion){
                            foreach ($formulacion as $form){
                                $formulacion_actual = $form["valitemcarac_valor"];
                            }
                        }
                        
                        // fin de busqueda de la formulacion
                        
                        $inserdet->insertardetalle($ult_id, $items, $lado, $semiterminado, $tipcinta, $value,$formulacion_actual);

                                $ultimoId_det = $inserdet->consultarUltimoIDextotdet();
                                if ($ultimoId_det) {
                                    foreach ($ultimoId_det as $ultid_det) {
                                        $ult_id_det = $ultid_det["extotdet_id"];
                                    }
                                }

                                            for ($index1 = 1; $index1 <= $value*5; $index1++) {
                                                   $inserdet->insertardetalleproduc($ult_id,$ult_id_det,$usr_nickname,$index1 ); 
                                            }

                    }


            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROEXTORDENTRABAJO', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=extordentrabajo&accion=listarot");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}


function _eliminarAction() {//producción 2020 150220 100800
    $filter = new InputFilter();

    $usr = $filter->process($_SESSION["idusuario"]);


    try {



        $id = $filter->process($_GET['id']);
        $extordentrabajo = new extordentrabajo();

        $validar = $extordentrabajo->ValidarExtOT($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=artsemiterminado&accion=listarot';
                </script>";
        } else {
            $extordentrabajo->eliminar($id);
            $accion = 'Eliminar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAS', null, null);
            $bitacora->insertar();

//            $menu->eliminar($id);
            header("location: index.php?page=artsemiterminado&accion=listarot");
        }


        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}


function _RegistrarProducOTAction() {//producción 2020 19022020 121700
   $filter = new InputFilter();

    $id = $filter->process($_GET['id']);
    $idmaq = $filter->process($_GET['idmaq']);

     $are_id = 1;    //$_SESSION['are_id'];
    $permiso = "disabled";
    
    $extordentrabajo = new extordentrabajo();
    $extordentrabajo->obtenerxId($id);
    
    $tipdoc = new produccion();
    $tipdocumentos = $tipdoc->consultartipdoc($are_id);
    
    $turnos= $tipdoc->consultarturno();
    
  

    $area = new areas();
    $areas = $area->consultarActivos();

    
    $maquina = new maquinas();
    $maquinas = $maquina->consultar();
    
   

    $lista = $maquina->gettipTubo($idmaq);
    


    require_once 'view/extordentrabajoproduc-form.php';
}

function _cargardetalleProduccionAction(){ //produccion 2020 150220 084900
        
         $peine =  $_GET["peine"];
         $bajada =  $_GET["bajada"];
         $ot =  $_GET["ot"];
         
if($peine == '0'){
    $columna = '12';
}else{
    
    $columna = '6';      
    
}  
    $extordentrabajo  = new extordentrabajo();
    $listar_det = $extordentrabajo->listardetalleot($ot);
    
    $producto = new maquinas();
   
    
    $tubo = $producto->gettipTubo();
    
    $carrito = $producto->getCarrito();
      
    $envasado = $producto->getEnvasado();
            
 
    

$html = "";


   if($listar_det){
        foreach ($listar_det as $listar){
       
            $html .= "<div class='col-sm-".$columna."'>";
                    $html .=  "<div class='widget-body'>";
                            $html .= "<div class='widget-main'>";
                                    $html .= "<h3 class='header blue lighter smaller'>";
                                             $html .= "<i class='ace-icon fa fa-retweet smaller-90'></i> ". $listar['extotdet_lado']." ----> ".$listar['artsemi_descripcion']." (" .$listar['artsemi_id'].")";
                                            if('tr'== substr($listar['extotdet_tipcinta'],0,2)){
                                                $html .= "---> Trama";
                                            }else{
                                                 $html .= "---> Urdimbre";
                                            }
                                    $html .= "</h3>";

                                            $html .="<div class='row'>";
                                                    $html .="<div class='col-xs-12'>";
                                                            $html .= "<table id='simple-table' class='table  table-bordered table-hover'>";
                                                                $html .= "<thead>";
                                                                    $html .= "<th class='detail-col'>Ítem</th>";
                                                                    $html .= "<th>Carros </th>";
                                                                     $html .= "<th>Envasado</th>";
                                                                    $html .= "<th>Num. Bultos</th>";
                                                                    $html .= "<th class='hidden-480'>Num. Bob.</th>";
                                                                    $html .= "<th class='hidden-480'>Peso</th>";
                                                                    $html .= "<th class='hidden-480'>Capturar</th>";
                                                                  
                                                                    $html .= "<th class='hidden-480'>Registrar</th>";
                                                                    $html .= "<th class='hidden-480'></th>";
                                                                    
                                                                $html .= "</thead>";
                                                                 $extordentrabajo  = new extordentrabajo();
                                                            $listar_det_producc = $extordentrabajo->listardetalleotProducc($ot, $listar['extotdet_id']);
                                                        
                                                                
                                                                    
                                                                $html .= "<tbody>";
                                                                if($listar_det_producc){
                                                            foreach ($listar_det_producc as $list){
                                                                     $html .="<tr>";
                                                                        $html .="<td>";
                                                                          $html .=  $list['extotdet_items'];
                                                                        $html .="</td>";
                                                                        
                                                                        $html .="<td>";
                                                                                $html .= "<select name='carrito-".$list['extotpro_id']."' id='carrito-".$list['extotpro_id']."' class='chosen-select form-control' >";
                                                                                                if($carrito){ 
                                                                                                        foreach ($carrito as $lista){ 
                                                                                                                 $html .= "<option value='".  $lista['pespro_id']."' > ".$lista ['pespro_descripcion']." </option>";


                                                                                                        }
                                                                                                }                            
                                                                                     $html .= "</select>";
                                                                        $html .="</td>";
                                                                        
                                                                         $html .="<td>";
                                                                                $html .= "<select name='envase-".$list['extotpro_id']."' id='envase-".$list['extotpro_id']."' class='chosen-select form-control' >";
                                                                                            if($envasado){ 
                                                                                                    foreach ($envasado as $lista){ 
                                                                                                             $html .= "<option value='".  $lista['pespro_id']."' > ".$lista ['pespro_descripcion']." </option>";


                                                                                                    }
                                                                                            }                            
                                                                                 $html .= "</select>";
                                                                        $html .="</td>";
                                                                        
                                                                        $html .="<td>";
                                                                            $html .= "<input type= 'text' name='numcaja-".$list['extotpro_id']."' id='numcaja-".$list['extotpro_id']."'
                                                                                    style='width: 35px; height:32px'value='". $list['extotpro_numcaja']."'/>";
                                                                        $html .="</td>";
                                                                        
                                                                        $html .="<td>";
                                                                            $html .= "<input type= 'text' name='numbob-".$list['extotpro_id']."' id='numbob-".$list['extotpro_id']."'
                                                                                     style='width: 40px; height:32px' value='".$list['extotpro_numbob']."'/>";
                                                                        $html .="</td>";
                                                                        
                                                                        $html .="<td>";
                                                                            $html .= "<input type= 'text' name='pesomov-".$list['extotpro_id']."' id='pesomov-".$list['extotpro_id']."'
                                                                                    style='width: 60px; height:32px' value='".$list['extotpro_peso']."'/>";
                                                                        $html .="</td>";
                                                                                 
                                                                        $html .="<td>";
                                                                             $html.= "<input type='hidden' id='input-url' size='50' value='http://localhost:84/proyecto_produccion/data.txt'></input>";//borrar
                                                                                    if($list['estado'] =='0'){
                                                                                    $html .= "<a  class='btn btn-minier btn-yellow' enabled id='mostrar' data-estado = '".$list['extotpro_id']."' >Capturar</a>";
                                                                                     }else{
                                                                                         $html .= "<a  class='btn btn-minier btn-yellow' disabled id='mostrar' data-estado = '".$list['extotpro_id']."' >Capturar</a>"; 
                                                                                     }
                                                                             
//                                                                             $html .= "<input  id='prueba03-".$list['extotpro_id']."' name='prueba03-".$list['extotpro_id']."' value=''>";
                                                                       
                                                                            
                                                                        $html .="</td>";
                                                                        
                                                                      
                                                                        
                                                                        $html .="<td>";
                                                                                 $html .="<img width='18px' height='18px' style='margin-top: -7px; display: none;'";
                                                                                 $html .="src='view/img/loading.gif' class='loading-".$list['extotpro_id']."' >";
                                                                                 $html .="<input name='switch-field-1' class='ace ace-switch ace-switch-6' type='checkbox' "; 
                                                                                 if($list['estado'] =='0'){
                                                                                   $html .=" enabled " ;
                                                                                 }else{
                                                                                    $html .=" disabled checked='checked'" ;
                                                                                 }
                                                                                 $html .="id='extotpro' data-extotpro='".$list['extotpro_id']."' ";

                                                                                 $html .="/>";
                                                                                  $html .="<span class='lbl'></span>";
                                                                                  $html .= "<input type='hidden' id='art-".$list['extotpro_id']."' name='art-".$list['extotpro_id']."' value='".$listar['artsemi_id']."' /> ";
                                                                        $html .="</td>";
                                                                        
                                                                        
                                                                        
                                                                        $html .="<td>";
                                                                                $html .="<center><a class='blue'";
                                                                                $html .= "onclick='false' target='_blank' href='index.php?page=extordentrabajo&accion=reporteext&idpro=".$list['extotpro_id']."&fechapro=".$list['extotpro_id']."'  data-print='".$list['extotpro_id']."'";
                                                                                $html .= ">";
                                                                                $html .="<i class='ace-icon fa fa-print bigger-130'></i>";
                                                                                $html .="</a></center>";
                                                                                    $cod = $list['extotpro_id'];
                                                                                       //     str_pad($input, 10, "-=", STR_PAD_LEFT)
                                                                                    $html .= "<input type='hidden' id='barcode-".$list['extotpro_id']."' name='barcode-".$list['extotpro_id']
                                                                                           ."' value='".  str_pad($cod, 12, "0", STR_PAD_LEFT)."' /> ";
                                                                        $html .="</td>";

                                                                     $html .="</tr>";
                                                                   }
                                                        }  

                                                                $html .= "</tbody>";
                                                            $html .="</table>";
                                                    $html .= "</div>";
                                            $html .= "</div>";
//                                $html.= "<input type='hidden' id='input-url' size='50' value='http://localhost:84/proyecto_produccion/data.txt'></input>";//borrar  
//                                 $html .= "<a  class='btn btn-minier btn-yellow' id='mostrar' name = 'mostrar' >Capturar</a>";
//                                 $html .= "<input  id='prueba03' name='prueba03' value=''>";
                                 
                            $html .= "</div>";
                    $html .= "</div>";
            $html .= "</div>   ";  

       }
    }
            


       echo $html;
    }
    
    
function _reporteextAction(){
    $id= $_GET['idpro'];
 //   $fechapro = $_POST['fechapro'];
        
    require_once 'view/reportes/reporteext.php';
}
    
function _reportotXfechaAction() { 
   $turno = new produccion();
   $listaTur = $turno->consultarturno();
   
     $are_id = $_SESSION['are_id'];
     
   $maquina = new maquinas();
   $listamaq = $maquina->consultar();

    require 'view/reportot-form.php';
}

function _mostrarreportotAction() { 
    $filter = new InputFilter();

    $turno = $filter->process($_POST['tur_id']);
    $maquina = $filter->process($_POST['maq_id']);
    
    $rango = $filter->process($_POST['rango']);
    
    $fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d'); //fecha inicial formateada
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d'); //fecha final formateada


    require 'view/reportes/reporte-reportot.php';
}

function _reporteAction() { 
    
    $tipo='stockFecha';
    require 'view/reportstock-form.php';
}

function _stockAction() { 
    
       $filter = new InputFilter();
    $fecha = $filter->process($_POST['fecha']); 
   $stock = new produccion();
   $lista = $stock->consultarStock($fecha);
   
    

    require 'view/reportes/reporte-stock.php';
}

function _kardexsAction() { 
    $articulo = new artsemiterminado();
    $tipsemi_id= '1';
    $lista = $articulo->consultarXsemiterminado($tipsemi_id);

  require 'view/kardexs-form.php';

}

function _rpteTiemAlmAction() { 
    
    $tipo='tiempoAlmacenamientoXlote';
    require 'view/reportstock-form.php';
}
function _rpteTiemAlmImpAction() { 
    
        $filter = new InputFilter();
    $fecha = $filter->process($_POST['fecha']); 
   $tiempoTranscurrido = new produccion();
   $lista = $tiempoTranscurrido->consultarStock($fecha);
   
    

    require 'view/reportes/reporte-TiempoAlmCintas.php';
}

function _rpteTurnoAction() { 
    
    $tipo='produccionxturno';
    require 'view/reportstock-form.php';
}
function _rpteTurnoImpAction() { 
    
        $filter = new InputFilter();
    $rango = $filter->process($_POST['rango']); 
    $estado = $filter->process($_POST['estado']); 
   
$fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');
    
   $producTurno = new artsemiterminado();
   $lista = $producTurno->Produccion_x_turno($ini, $fin,$estado);
   
    

    require 'view/reportes/reporte-turno.php'; 
}
?>
