<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/areas.php';
require_once 'model/semiterminado.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';


function _listarAction() {   //PRODUCCION 2019 
    $semiter = new semiterminado();
    $semiterminados = $semiter->consultar();

    $usuario = new Usuario();

    require 'view/semiterminado-registro.php';
}

function _ajaxverdetallesemiterAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $semiter = new semiterminado();
    $semiter->obtenerxId($id);
    $permiso = $_POST['permiso'];
    
    $area = new areas();
    $areas= $area->consultarActivos();

    require_once 'view/semiterminado-form.php';
}

function _insertarAction() {//producción 2019
    session_start();

    $filter = new InputFilter();

    $tipsem_titulo = $filter->process($_POST["tipsem_titulo"]);
    $estado = $filter->process($_POST["optionsRadios"]);
    $usr = $filter->process($_SESSION["idusuario"]);
    $area = $filter->process($_POST["are_id"]);
    $accion = '';

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $semit = new semiterminado ($id, $tipsem_titulo, $usr, $estado, null, $area);
            $semit->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGTIPOSEMITERMINADO', null, null);
            $bitacora->insertar();
        } else {
            $semit = new semiterminado(null, $tipsem_titulo, $usr, $estado, null , $area);
            $semit->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGTIPOSEMITERMINADO', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=semiterminado&accion=listar");
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
        $semit = new semiterminado();
        $semit->eliminar($id);

        $accion = 'Eliminar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROMGTIPOSEMITERMINADO', null, null);
        $bitacora->insertar();


        header("location: index.php?page=semiterminado&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>