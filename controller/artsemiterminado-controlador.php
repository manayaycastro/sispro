<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/maquinas.php';
require_once 'model/itemcaracsemit.php';
require_once 'model/articulocaractecnicas.php';
require_once 'model/artsemiterminado.php';
require_once 'model/formulacion.php';
require_once 'model/usuarios.php';
require_once 'model/semiterminado.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';

function _formAction() { //producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $permiso = "enabled";
    $artsemiter = new artsemiterminado();
    $artsemiter->obtenerxId($id);
    
    
    $colores = $artsemiter->consultarcol();

    $fomulac = new formulacion();
    $fomulacion = $fomulac->consultar();

   

    $semiterminado = new semiterminado();
    $semiterminados = $semiterminado->consultarActivos();

    require 'view/artsemiterminadoprueba-form.php';
}

function _listarAction() { //producción 2019
    $artsemiter = new artsemiterminado();
    $idsemiterminado = '1';
    $artsemiterminado = $artsemiter->consultarXsemiterminado($idsemiterminado);


    require 'view/artsemiterminado-registro.php';
}

function _verdetalleartsemiterminadoAction() {//producción 2019
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);


    $artsemiter = new artsemiterminado();
    $artsemiter->obtenerxId($id);
    $permiso = "disabled";

    $fomulac = new formulacion();
    $fomulacion = $fomulac->consultar();

    $colores = $artsemiter->consultarcol();

    $semiterminado = new semiterminado();
    $semiterminados = $semiterminado->consultarActivos();



    require_once 'view/artsemiterminadoprueba-form.php';
}

function _modificarartsemiterminadoAction() {//producción 2019
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);



    $artsemiter = new artsemiterminado();
    $artsemiter->obtenerxId($id);
    $permiso = "enabled";

    $fomulac = new formulacion();
    $fomulacion = $fomulac->consultar();

    $colores = $artsemiter->consultarcol();

    $semiterminado = new semiterminado();
    $semiterminados = $semiterminado->consultarActivos();



    require_once 'view/artsemiterminadoprueba-form.php';
}

function _insertarAction() { //producción 2019

    session_start();

    $filter = new InputFilter();


    $artsemi_descripcion = $filter->process($_POST["artsemi_descripcion"]);
    $col_id = $filter->process($_POST["col_id"]);
//    $itemcaracsemi_pocision = $filter->process($_POST["$itemcaracsemi_pocision"]);
    $tipsem_id = $filter->process($_POST["tipsem_id"]);
    $form_id = $filter->process($_POST["form_id"]);

    $estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];

     $idsemiterminado = $filter->process($_POST["idsemiterminado"]);
     


    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);

            $id = $filter->process($_GET["id"]);
            $artsemiter = new artsemiterminado($id, $artsemi_descripcion, $col_id, $tipsem_id, $form_id, $usr, $estado, NULL);
            $artsemiter->modificar();

                            $listaitemcarac = new itemcarcsemiterminado();
                            $items = $listaitemcarac->consultaritemXtipoFinal($tipsem_id,$idsemiterminado);

                            if ($items) {
                                foreach ($items as $item) {
                                   
                                        $valor = $filter->process($_POST[$item["itemcaracsemi_id"]]); //valor del campo de texto - item carac
                                        $itemcarac = $item["itemcaracsemi_id"]; //valor del campo de texto - item carac
                                        $val_item_carac_id = $item["valitemcarac_id"]; // verificar si un nuevo item a sido insertado me mostrara 0 , entonces hay que insertarlo
                                        
                                        if($val_item_carac_id > 0){
                                            $modif = new artsemiterminado();
                                        $modif->modificarValores($id, $itemcarac ,  $valor, $usr, '1'); 
                                        }else{
                                            $insertar = new artsemiterminado();
                                        $insertar->insertarValores($id,$itemcarac, $valor, $usr, '0');
                                        }
                                        
                                      
                                 
                                }
                            }


            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROARTSEMITERMINADO', null, null);
            $bitacora->insertar();
        } else {
            $artsemiter = new artsemiterminado(null, $artsemi_descripcion, $col_id, $tipsem_id, $form_id, $usr, $estado, NULL);
            $artsemiter->insertar();

            $nuevoID = $artsemiter->nuevoIdRegistro();
            if ($nuevoID) {
                foreach ($nuevoID as $nid) {
                    $idfin = $nid["id"];
                }
            }


            $listaitemcarac = new itemcarcsemiterminado();
            $items = $listaitemcarac->consultaritemXtipo($tipsem_id);

            if ($items) {
                foreach ($items as $item) {
                    $valor = $filter->process($_POST[$item["itemcaracsemi_id"]]);
                    $insertar = new artsemiterminado();
                    $insertar->insertarValores($idfin, $item["itemcaracsemi_id"], $valor, $usr, '0');
                }
            }





            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROARTSEMITERMINADO', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=artsemiterminado&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _cargarportipsemiAction() {//producción 2019

    $id = $_GET["id2"];
    $permiso = $_GET["permiso"];
    $idart = $_GET["idsemiterminado"];

    $listaitemcarac = new itemcarcsemiterminado();
    $items = $listaitemcarac->consultaritemXtipoFinal($id, $idart);

    $clasifi = $listaitemcarac->consultaritemXtipoXclase($id);

    $html = " ";

    $a = 0;
    
    

    $html .= "<div class='widget-body'>";
    $html .= "<div class='widget-main'>";


    $html .= "<div class='col-sm-12'>";
    if ($clasifi) {
        foreach ($clasifi as $clasi) {
            $a = $a + 1;
            $html .= "<div id='accordion' class='accordion-style1 panel-group'>";
            $html .= "<div class='panel panel-default'>";

            $html .= " <div class='panel-heading'>";
            $html .= " <h4 class='panel-title'>";
            $html .= "<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#" . $a . "'>";
            $html .= "<i class='ace-icon fa fa-angle-down bigger-110' data-icon-hide='ace-icon fa fa-angle-down' data-icon-show='ace-icon fa fa-angle-right'></i>";
            $html .= "" . $clasi['clasem_titulo'] . " - " . $idart . "";
            $html .= "  </a>";
            $html .= "   </h4>";
            $html .= "</div>";



            $html .= "<div class='panel-collapse collapse in' id='" . $a . "'>";
            $html .= "<div class='panel-body'>";

            if ($items) {
                foreach ($items as $item) {

                    if ($clasi ['clasem_id'] == $item['clasem_id']) {

                        $html .= "<div class='form-group'>";
                        $html .= "<label class='col-sm-3 control-label no-padding-right' for='form-field-1-1'> " . $item["itemcaracsemi_descripcion"] . " </label>";

                        $html .= " <div class='col-sm-9'>";
//                        SI ES CAJA TEXTO O SI ES UN SELECT
                        if ($item['itemcaracsemi_tipodato'] == '_caja'){
                             $html .= "<input type='text'name = '" . $item["itemcaracsemi_id"] . "' ". $permiso." id='form-field-1-1' value = '" . $item["valitemcarac_valor"] . "' placeholder='Ingrese un valor' class='form-control' />";
                        }else if ($item['itemcaracsemi_tipodato'] == '_combo'){

                         $listar = listacombo($item['itemcaracsemi_tabla'],  $id);
                         
                                            $html .= "<select name='" . $item["itemcaracsemi_id"] . "' class='chosen-select form-control' ". $permiso." id='" . $item["itemcaracsemi_id"] . "' data-placeholder='Choose a State...'> ";
                                            $html .= "<option value='-1'>    Seleccione una opción  </option>";
                                                   if (count($listar)):
                                                       foreach ($listar as $lista):
                                                           $html .=   "<option value='". $lista [$item['itemcaracsemi_tabla_id']] ."'";
                                                                   if (!empty($item["valitemcarac_valor"])):
                                                                       if ( $lista [$item['itemcaracsemi_tabla_id']] == $item["valitemcarac_valor"]): 
                                                                          $html .= " selected  ";
                                                                       endif;
                                                                   endif;
                                                                           $html .= ">". $lista[$item['itemcaracsemi_tabla_descripcion']]."</option>";

                                                       endforeach;
                                           
                                                   endif;
                                                   $html .= "</select>";
                        }
                       
                        
                        $html .= "</div> ";
                        $html .= "</div>";
                    }
                }
            }

            $html .= " </div>";
            $html .= "</div>";


            $html .= " </div>";
            $html .= "</div>";
        }




        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
    } else {
        $html .= "<div>  no existe carácteristicas para este tipo de formulación. Dede crearlas antes.</div>";
    }




    echo $html;
}

function  listacombo($itemcaracsemi_tabla,  $id){//producción 2019
    $lista = [];
    if($itemcaracsemi_tabla == 'colores'){
         $artsemiter = new artsemiterminado();
         $lista = $artsemiter->consultarcol();
    }else if ($itemcaracsemi_tabla == 'formulacion'){
        $formulacion = new formulacion();
        $lista = $formulacion->consultarporSemiterm( $id);
    }else if ($itemcaracsemi_tabla == 'tipouso'){
		$artsemiter = new artsemiterminado();
         $lista = $artsemiter->consultaruso();
	}
   return $lista;
}
function _eliminarAction() {//producción 2019

    $filter = new InputFilter();
//    $usr = $_SESSION["idusuario"];
    $usr = $filter->process($_SESSION["idusuario"]);


    try {



        $id = $filter->process($_GET['id']);
        $semiterminado = new artsemiterminado();

        $validar = $semiterminado->ValidarSemiterminado($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=artsemiterminado&accion=listar';
                </script>";
        } else {
            $submenu->eliminar($id);
            $accion = 'Eliminar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAS', null, null);
            $bitacora->insertar();

//            $menu->eliminar($id);
            header("location: index.php?page=artsemiterminado&accion=listar");
        }








//        header("location: index.php?page=submenu&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _ajaxmostrarmaquinaAction() {//producción 2019
    $filter = new InputFilter();

  // $id = $filter->process($_POST['tipsem_id']);        para mostrar el numero de cintas
    $idsemiterminado = $filter->process($_POST['idsemiterminado']);
//   $texto = $filter->process($_POST['id_semiterminado_tex']);
   $permiso = $filter->process($_POST['permiso']);

  


    $maquina = new artsemiterminado();
    $semiterminado_maquina =$maquina->Lista_maq_semiterminado($idsemiterminado);
    

    require_once 'view/vistahtml/listamaquina-form.php';
}

function _ajaxlistarmaquinaAction() {//producción 2019
    $filter = new InputFilter();

   $tiposemi_id = $filter->process($_GET['tipSemiActual']);
   
   $id = $filter->process($_GET['idsemi']);
   
  
 //$idart = $_POST["idsemi"];
    $idfinal;
   
    if($id == '0'){
        $semiterminado = new artsemiterminado();
        $ultimoID = $semiterminado->consultarUltimoSemiID();
        if($ultimoID){
            foreach ($ultimoID as $ult){
               $idfinal = $ult["artsemi_id"] + 1; 
            }
                
            
        }
    }else{
        $idfinal = $id;
    }
   $permiso = $filter->process($_POST['permiso']);


    $maquina = new artsemiterminado();
    
    $maquinas =$maquina->AsignarMaquinaporTipoSemniterminado($idfinal,$tiposemi_id);
    

    require_once 'view/vistahtml/mostrarmaquina-form.php';
}

function _ajaxlistarmaquinaV2Action() {//producción 2019
    $filter = new InputFilter();

  $tiposemi_id = $filter->process($_POST['tipSemiActual']);
   
   $idfinal = $filter->process($_POST['idsemi']);
   
  
   $permiso = $filter->process($_POST['permiso']);


    $maquina = new artsemiterminado();
    
    $maquinas =$maquina->AsignarMaquinaporTipoSemniterminado($idfinal,$tiposemi_id );
    

    require_once 'view/vistahtml/mostrarmaquina-form.php';
}



function _ajaxregistrarmaqsemiterminadoAction() { //producción 2019


    $response = array();

    $usuario = $_SESSION['idusuario'];

    $maq_id = $_POST['maq_id'];
    $numcintas= $_POST['numcintas'];
    $asig_maq_semi= $_POST['asig_maq_semi'];
    
    
    
    $semi_id= $_POST['semi_id'];
    
    $accion= $_POST['accion'];



    if ($accion == "agregar") {
        $estado = 0;
        $registrar_maq_semiterminado = new artsemiterminado();
        $status = $registrar_maq_semiterminado->registrar_maq_semiterminado($estado,$numcintas,$semi_id,$maq_id,$usuario,$estado);

       
    } else {
        $estado = 1;
        $updatemetadet = new artsemiterminado();
        $status = $updatemetadet->update_maq_semiterminado($asig_maq_semi);
        
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}

function _listarArtiSacAction() { //producción 2019
	$artsemi = '2';
  $artsemiter = new articulocaractecnicas();
    $artsemiterminado_lista = $artsemiter->consultar($artsemi);



    require 'view/articuloprocesomaq-registro.php';
}

function _listarArtiParchAction() { //producción 2019
	$artsemi = '8';
  $artsemiter = new articulocaractecnicas();
    $artsemiterminado_lista = $artsemiter->consultar($artsemi);



    require 'view/articuloprocesomaqparch-registro.php';
}

?>
