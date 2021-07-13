<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/maquinas.php';
require_once 'model/itemcaractipmaq.php';
require_once 'model/artsemiterminado.php';
require_once 'model/tipmaquina.php';
require_once 'model/usuarios.php';
require_once 'model/maquinafamilia.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';

function _formAction() { //producción 2020
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }

    $permiso = "enabled";
   
    $maquinafamilia = new maquinafamilia();
    $maquinafamilia->obtenerxId($id);

    $tipomaquina = new tipomaquina();
    $tipomaquinas = $tipomaquina->consultarActivos();

    $maquina = new maquinas();
    $maquinas = $maquina->consultar();

    require 'view/maquinafamilia-form.php';
}

function _listarAction() { //producción 2020
    $maqfamilia = new maquinafamilia();
    $maquinafamilia = $maqfamilia->consultar();


    require 'view/maquinafamilia-registro.php';
}

function _cargarportipmaquinaAction() {//producción 2020

    $id = $_GET["id2"];
    $permiso = $_GET["permiso"];
    $maqfamid = $_GET["maqfamid"];

    $listaitemcarac = new itemcaractipmaquina();
    $items = $listaitemcarac->consultaritemXtipoFinal($id, $maqfamid);

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
            $html .= "" . $clasi['clatipmaq_titulo'] . " - " . $maqfamid . "";
            $html .= "  </a>";
            $html .= "   </h4>";
            $html .= "</div>";



            $html .= "<div class='panel-collapse collapse in' id='" . $a . "'>";
            $html .= "<div class='panel-body'>";

            if ($items) {
                foreach ($items as $item) {

                    if ($clasi ['clatipmaq_id'] == $item['clatipmaq_id']) {

                        $html .= "<div class='form-group'>";
                        $html .= "<label class='col-sm-3 control-label no-padding-right' for='form-field-1-1'> " . $item["itemcaractipmaq_descripcion"] . " </label>";

                        $html .= " <div class='col-sm-9'>";
//                        SI ES CAJA TEXTO O SI ES UN SELECT
                        if ($item['itemcaractipmaq_tipodato'] == '_caja'){
                             $html .= "<input type='text'name = '" . $item["itemcaractipmaq_id"] . "' ". $permiso." id='form-field-1-1' value = '" . $item["valitemcaractipmaq_valor"] . "' placeholder='Ingrese un valor' class='form-control' />";
                        }else if ($item['itemcaractipmaq_tipodato'] == '_combo'){

                         $listar = listacombo($item['itemcaractipmaq_tabla'],  $id);
                         
                                            $html .= "<select name='" . $item["itemcaractipmaq_id"] . "' class='chosen-select form-control' ". $permiso." id='" . $item["itemcaractipmaq_id"] . "' data-placeholder='Choose a State...'> ";
                                            $html .= "<option value='-1'>    Seleccione una opción  </option>";
                                                   if (count($listar)):
                                                       foreach ($listar as $lista):
                                                           $html .=   "<option value='". $lista [$item['itemcaractipmaq_tabla_id']] ."'";
                                                                   if (!empty($item["valitemcaractipmaq_valor"])):
                                                                       if ( $lista [$item['itemcaractipmaq_tabla_id']] == $item["valitemcaractipmaq_valor"]): 
                                                                          $html .= " selected  ";
                                                                       endif;
                                                                   endif;
                                                                           $html .= ">". $lista[$item['itemcaractipmaq_tabla_descripcion']]."</option>";

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


function  listacombo($itemcaracsemi_tabla,  $id){//producción 2020
    //solo se incluira para rrecorridos de tablas que pertenescan al select de familia de maquina
    $lista = [];
    if($itemcaracsemi_tabla == 'proafirmacion'){
         $artsemiter = new maquinafamilia();
         $lista = $artsemiter->consultarafirmacion();
    }else if ($itemcaracsemi_tabla == 'pesoproducto'){
        $maquina = new maquinas();
        $lista = $maquina->gettipTubo();
    }else{
        
    }
   return $lista;
}

function _insertarAction() { //producción 2020

    session_start();

    $filter = new InputFilter();

    $maq_id = $filter->process($_POST["maq_id"]);
    $tipmaq_id = $filter->process($_POST["tipmaq_id"]);

    $estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];

     $maqfamid = $filter->process($_POST["maqfamid"]);
     


    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);

            $maquinafamilia = new maquinafamilia($id, $maq_id, $tipmaq_id, $usr, $estado, NULL); //inserta sola en la tabla donde se relaciona maquina familia
            $maquinafamilia->modificar();

                            $listaitemcarac = new itemcaractipmaquina();
                            $items = $listaitemcarac->consultaritemXtipoFinal($tipmaq_id,$maqfamid);// muestra consulta de descripcion de itemns con sus respectivos valores

                            if ($items) {
                                foreach ($items as $item) {
                                   
                                        $valor = $filter->process($_POST[$item["itemcaractipmaq_id"]]); //valor del campo de texto - item carac
                                        $itemcarac = $item["itemcaractipmaq_id"]; //valor del campo de texto - item carac
                                        $val_item_carac_id = $item["valitemcaractipmaq_id"]; // verificar si un nuevo item a sido insertado me mostrara 0 (ver en la consulta), entonces hay que insertarlo
                                        
                                        if($val_item_carac_id > 0){
                                        $modif = new maquinafamilia();
                                        $modif->modificarValores($id, $itemcarac ,  $valor, $usr, '1'); 
                                        }else{
                                            $insertar = new maquinafamilia();
                                        $insertar->insertarValores($id,$itemcarac, $valor, $usr, '0');
                                        }
                                        
                                      
                                 
                                }
                            }


            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROVALITEMSCARACTTIPMAQUINA', null, null);
            $bitacora->insertar();
        } else {
            $maquinafamilia = new maquinafamilia(null,  $maq_id, $tipmaq_id, $usr, $estado, NULL);
            $maquinafamilia->insertar();

            $nuevoID = $maquinafamilia->nuevoIdRegistro(); // se obtiene el ultimo registro de la tabla maquinafamilia para ser insertada en los valores de la tabla 
            if ($nuevoID) {
                foreach ($nuevoID as $nid) {
                    $idfin = $nid["id"];
                }
            }


            $listaitemcarac = new itemcaractipmaquina();
            $items = $listaitemcarac->consultaritemXtipo($tipmaq_id);

            if ($items) {
                foreach ($items as $item) {
                    $valor = $filter->process($_POST[$item["itemcaractipmaq_id"]]);
                    $insertar = new maquinafamilia();
                    $insertar->insertarValores($idfin, $item["itemcaractipmaq_id"], $valor, $usr, '0');
                }
            }





            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROARTSEMITERMINADO', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=maquinafamilia&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _verdetallemaquinafamiliaAction() {//producción 2020
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);


   $maquinafamilia = new maquinafamilia();
    $maquinafamilia->obtenerxId($id);
    $permiso = "disabled";

   

    $tipomaquina = new tipomaquina();
    $tipomaquinas = $tipomaquina->consultarActivos();

    $maquina = new maquinas();
    $maquinas = $maquina->consultar();




    require_once 'view/maquinafamilia-form.php';
}

function _modificarartmaquinafamiliaAction() {//producción 2020
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);



    $maquinafamilia = new maquinafamilia();
    $maquinafamilia->obtenerxId($id);
    $permiso = "enabled";

   

    $tipomaquina = new tipomaquina();
    $tipomaquinas = $tipomaquina->consultarActivos();

    $maquina = new maquinas();
    $maquinas = $maquina->consultar();




    require_once 'view/maquinafamilia-form.php';
}


function _eliminarAction() {//producción 2020

    $filter = new InputFilter();
//    $usr = $_SESSION["idusuario"];
    $usr = $filter->process($_SESSION["idusuario"]);


    try {

        $id = $filter->process($_GET['id']);
        $maquinafamilia = new maquinafamilia();
  

        $validar = $maquinafamilia->Validarmaquinafamilia($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=maquinafamilia&accion=listar';
                </script>";
        } else {
            $maquinafamilia->eliminar($id);


            header("location: index.php?page=maquinafamilia&accion=listar");
        }


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


?>