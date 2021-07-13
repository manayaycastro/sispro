<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/areas.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';



function _listarAction() {   //PRODUCCION 2019 
    $area = new areas();
    $areas = $area->consultar();
    
    $areareferenc = $area->consultarreferencia();

    $usuario = new Usuario();

    require 'view/areas-registro.php';
}

function _ajaxverdetalleareaAction() {//producción 2019
    
     $area_id = new areas();
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
         $areareferenc = $area_id->consultarreferenciaid();
    } else {
        $id = 0;
         $areareferenc = $area_id->consultarreferenciaid();
    }
   
    $area_id->obtenerxId($id);
    
    $permiso = $_POST['permiso'];

    require_once 'view/area-form.php';
}

function _insertarAction() {//producción 2019
   

    $filter = new InputFilter();

    $area = $filter->process($_POST["area"]);
    $arearef = $filter->process($_POST["are_referencia"]);
    $estado = $filter->process($_POST["optionsRadios"]);
    $usr = $filter->process($_SESSION["idusuario"]);
    $accion = '';
if($arearef >= 1){
    

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $area = new areas($id, $area, $usr, $estado, null,$arearef);
            $area->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGAREAS', null, null);
            $bitacora->insertar();
        } else {
            $area = new areas(null, $area, $usr, $estado, null,$arearef);
            $area->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGAREAS', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=areas&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
    
    }else {
          echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... No existe referencia alguna seleccionada')  ; 
              window.location = 'index.php?page=areas&accion=listar';
                </script>";
    }
}

function _modificarAction() {//producción 2019
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);

    $area = new areas();
    $area->obtenerxId($id);

    require 'view/area-form.php';
}

function _eliminarAction() {//producción 2019
    /*
     * Funcion para eliminar un registro
     */
    $filter = new InputFilter();
    $usr = $filter->process($_SESSION["idusuario"]);
    try {
        $id = $filter->process($_GET['id']);
        $areas = new areas();
        $areas->eliminar($id);

        $accion = 'Eliminar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROMGMENU', null, null);
        $bitacora->insertar();


        header("location: index.php?page=areas&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>
