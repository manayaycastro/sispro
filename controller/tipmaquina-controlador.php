<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/areas.php';
require_once 'model/tipmaquina.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';


function _listarAction() {   //PRODUCCION 2020 
    $tipmaq = new tipomaquina();
    $tipmaquina = $tipmaq->consultar();

  

    require 'view/tipmaquina-registro.php';
}

function _ajaxverdetalletipmaquinaAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $tipmaq = new tipomaquina();
    $tipmaq->obtenerxId($id);
    $permiso = $_POST['permiso'];
    
    $area = new areas();
    $areas= $area->consultarActivos();

    require_once 'view/tipmaquina-form.php';
}

function _insertarAction() {//producción 2019
    session_start();

    $filter = new InputFilter();

    $tipmaq_titulo = $filter->process($_POST["tipmaq_titulo"]);
    $estado = $filter->process($_POST["optionsRadios"]);
    $usr = $filter->process($_SESSION["idusuario"]);
    $area = $filter->process($_POST["are_id"]);
    $accion = '';

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $tipmaquina = new tipomaquina ($id, $tipmaq_titulo, $usr, $estado, null, $area);
            $tipmaquina->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGTIPMAQUINA', null, null);
            $bitacora->insertar();
        } else {
            $tipmaquina = new tipomaquina(null, $tipmaq_titulo, $usr, $estado, null , $area);
            $tipmaquina->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGTIPMAQUINA', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=tipmaquina&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}


function _eliminarAction() {//producción 2019
    /*
     * Funcion para eliminar un registro
     */
    $filter = new InputFilter();
    $usr = $filter->process($_SESSION["idusuario"]);
    try {
        $id = $filter->process($_GET['id']);
        $tipmaquina = new tipomaquina();
        $tipmaquina->eliminar($id);

        $accion = 'Eliminar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROMGTIPMAQUINA', null, null);
        $bitacora->insertar();


        header("location: index.php?page=tipmaquina&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>