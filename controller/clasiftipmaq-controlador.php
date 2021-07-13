<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/clasiftipmaq.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';


function _listarAction() {   //PRODUCCION 2019 
    $clasiftipmaq = new clasiftipmaq();
    $clasiftipomaquina = $clasiftipmaq->consultar();

    require 'view/clasiftipmaq-registro.php';
}

function _ajaxverdetalleclasiftipmaqAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $clasiftipmaq = new clasiftipmaq();
    $clasiftipmaq->obtenerxId($id);
    $permiso = $_POST['permiso'];

    require_once 'view/clasiftipmaq-form.php';
}

function _insertarAction() {//producción 2019
    session_start();

    $filter = new InputFilter();

    $clatipmaq_titulo = $filter->process($_POST["clatipmaq_titulo"]);
    $estado = $filter->process($_POST["optionsRadios"]);
    $usr = $filter->process($_SESSION["idusuario"]);
    $accion = '';

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $clasiftipmaq = new clasiftipmaq ($id, $clatipmaq_titulo, $usr, $estado, null);
            $clasiftipmaq->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROCLASIFTIPOMAQUINA', null, null);
            $bitacora->insertar();
        } else {
            $clasiftipmaq = new clasiftipmaq(null, $clatipmaq_titulo, $usr, $estado, null);
            $clasiftipmaq->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROCLASIFTIPOMAQUINA', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=clasiftipmaq&accion=listar");
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
        $clasiftipmaq = new clasiftipmaq();
        $clasiftipmaq->eliminar($id);

        $accion = 'Eliminar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROCLASIFTIPOMAQUINA', null, null);
        $bitacora->insertar();


        header("location: index.php?page=clasiftipmaq&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>