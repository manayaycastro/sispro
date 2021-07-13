<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/maquinas.php';
require_once 'model/maquinameta.php';
require_once 'model/usuarios.php';
require_once 'model/areas.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';


function _listarAction() {   //producción 2019  
    $maquina = new maquinas();
    $maquinas = $maquina->consultar();
    $usuario = new Usuario();


    require 'view/maquinas-registro.php';
}

function _ajaxverdetallemaquinaAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $maquina = new maquinas();
    $maquina->obtenerxId($id);
    $permiso = $_POST['permiso'];

    $area = new areas();
    $areas = $area->consultarActivos();

    require_once 'view/maquinas-form.php';
}

function _ajaxverdetalledepresiacionAction() {//producción 2019
    $id = $_POST['id'];


    $maquina = new maquinas();
    $maquinas = $maquina->depresiacion($id);
//    $permiso = $_POST['permiso'];



    require_once 'view/depreciacion-form.php';
}

function _insertarAction() { //producción 2019

    session_start();

    $filter = new InputFilter();

    $maq_id = $filter->process($_POST["maq_id"]);
    $maq_nombre = $filter->process($_POST["maq_nombre"]);
    
    
    $maq_fec = $filter->process($_POST["maq_fec_adq"]);
      $date_maq_fec_adq = date_create($maq_fec);
$maq_fec_adq = date_format($date_maq_fec_adq, 'Y-d-m H:i:s');
    
    
    
    $maq_fec_pue = $filter->process($_POST["maq_fec_pue_mar"]);
    //$maq_fec_pue_mar
    $date_maq_fec_pue_mar = date_create($maq_fec_pue);
$maq_fec_pue_mar = date_format($date_maq_fec_pue_mar, 'Y-d-m H:i:s');
    
    $maq_vid_util = $filter->process($_POST["maq_vid_util"]);
    $maq_porce_depreanual = $filter->process($_POST["maq_porce_depreanual"]);
    $maq_valor_adqui = $filter->process($_POST["maq_valor_adqui"]);
    $are_id = $filter->process($_POST["are_id"]);
    $maq_estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];



    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $maquina = new maquinas($id, $maq_nombre, $maq_estado, $maq_fec_adq, $maq_fec_pue_mar, $maq_vid_util, $maq_porce_depreanual, $maq_valor_adqui, $usr, $are_id, NULL);
            $maquina->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAS', null, null);
            $bitacora->insertar();
        } else {
            $maquina = new maquinas
                    (null, $maq_nombre, $maq_estado, $maq_fec_adq, $maq_fec_pue_mar, $maq_vid_util, $maq_porce_depreanual, $maq_valor_adqui, $usr, $are_id, NULL);
            $maquina->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAS', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=maquinas&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _modificarAction() { //producción 2019
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);

    $maquina = new maquinas();
    $maquina->obtenerxId($id);

    $area = new areas();
    $areas = $area->consultar();




    require 'view/maquinas-form.php';
}

function _listarmetaAction() { //producción 2019
    $filter = new InputFilter();

    $maquinameta = new maquinas();
    $maquinametas = $maquinameta->Listarmeta();


    require 'view/maquinameta-registro.php';
}

function _ajaxverdetallemaquinametaAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $maquinameta = new maquinameta();
    $maquinameta->obtenerxId($id);
    $permiso = $_POST['permiso'];

    $maquina = new maquinas();
    $maquinas = $maquina->consultar();



    require_once 'view/maquinameta-form.php';
}

function _insertarmetaAction() { //producción 2019

    session_start();

    $filter = new InputFilter();

    $maq_id = $filter->process($_POST["maq_id"]);
    $maqmet_unidadmed = $filter->process($_POST["maqmet_unidadmed"]);
    $maqmet_anio = $filter->process($_POST["maqmet_anio"]);
    $maqmet_valor = $filter->process($_POST["maqmet_valor"]);

    $estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];


    $validacion = new maquinameta();
    $validar = $validacion->validarMetaMaquina($maqmet_anio, $maq_id);

    if ($validar and empty($_GET["id"])) {
        echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Esta programación para esta máquina y este año ya existen')  ; 
              window.location = 'index.php?page=maquinas&accion=listarmeta';
                </script>";
    } elseif($validar and  !empty($_GET["id"])) {
        try {
          
                $id = $filter->process($_GET["id"]);
                $maquinameta = new maquinameta($id, $maqmet_anio, $maqmet_unidadmed, $maqmet_valor, $maq_id, $usr, $estado, NULL);
                $maquinameta->modificar();

                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAMETA', null, null);
                $bitacora->insertar();
          
            header("location: index.php?page=maquinas&accion=listarmeta");
            die;
        } catch (Exception $exc) {
            $error = urlencode($exc->getTraceAsString());
            header("location: error.php?mssg=:$error");
            die;
        }
    }else{
        try {
            


                $maquinameta = new maquinameta(null, $maqmet_anio, $maqmet_unidadmed, $maqmet_valor, $maq_id, $usr, $estado, NULL);
                $maquinameta->insertar();
                
                for ($i = 1; $i<=12; $i++){
                   $maquinameta = new maquinameta(); 
                   $maquinameta->insertarmaqmetdet($i,$maqmet_anio, $maqmet_valor, $maq_id,'0', $usr);
                }

                $accion = 'Insertar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAMETA', null, null);
                $bitacora->insertar();
            

            header("location: index.php?page=maquinas&accion=listarmeta");
            die;
        } catch (Exception $exc) {
            $error = urlencode($exc->getTraceAsString());
            header("location: error.php?mssg=:$error");
            die;
        }
    }
}

function _modificarmetaAction() { //producción 2019
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);

    $maquina = new maquinas();
    $maquina->obtenerxId($id);

    $area = new areas();
    $areas = $area->consultar();




    require 'view/maquinas-form.php';
    
}


function _ajaxverdetallemaquinametadetAction() {//producción 2019
    
     $filter = new InputFilter();
      $id = $filter->process($_POST["id"]);
      $anio = $filter->process($_POST["anio"]);
      $maquina= $filter->process($_POST["maquina"]);
    
  $metadet = new maquinameta();
  $listar = $metadet->listarmaqmetdet($anio, $maquina);



    require_once 'view/vistahtml/mostrarmetdet-form.php';
}

function _ajaxmanejarestadometdetAction() { //producción 2019


    $response = array();

    $usuario = $_SESSION['idusuario'];

    $valormensual = $_POST['valormensual'];

    $idmetdet= $_POST['idmetdet'];
    $accion= $_POST['accion'];


   

    if ($accion == "agregar") {
        $estado = 0;
        $updatemetadet = new maquinameta();
        $status = $updatemetadet->updatemetdet($idmetdet,$valormensual,$estado,$usuario);

       
    } else {
        $estado = 1;
        $updatemetadet = new maquinameta();
        $status = $updatemetadet->updatemetdet($idmetdet,$valormensual,$estado,$usuario);
        
    }

    $response["status"] = $status;

    header('Content-Type: application/json');



    echo json_encode($response);
}














function _eliminarAction() {


//    $usr = $_SESSION["idusuario"];
    $usr = $filter->process($_SESSION["idusuario"]);
    $filter = new InputFilter();

    try {



        $id = $filter->process($_GET['id']);
        $maquina = new maquinas();

        $validar = $maquina->validarSubMenucount($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=submenu&accion=listar';
                </script>";
        } else {
            $submenu->eliminar($id);
            $accion = 'Eliminar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGMAQUINAS', null, null);
            $bitacora->insertar();

//            $menu->eliminar($id);
            header("location: index.php?page=submenu&accion=listar");
        }








//        header("location: index.php?page=submenu&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
    
    
    
    
    
}

?>
