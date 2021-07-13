<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/paradatipo.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';

function _formAction() {//PRODUCCION 2019  
    /*
     * Cargar datos en formulario de registro
     */

    require 'view/paradatipo-form.php';
}

function _listarAction() {   //PRODUCCION 2019 
    $paradatipo = new paradatipo();
    $paradatipos = $paradatipo->consultar();

    $usuario = new Usuario();

    require 'view/paradatipo-registro.php';
}

function _ajaxverdetalleparadatipoAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $paradatipo = new paradatipo();
    $paradatipo->obtenerxId($id);
    $permiso = $_POST['permiso'];

    require_once 'view/paradatipo-form.php';
}

function _insertarAction() {//producción 2019
    session_start();

    $filter = new InputFilter();

    $paradatipo = $filter->process($_POST["paradatipo"]);
    $estado = $filter->process($_POST["optionsRadios"]);
    $usr = $filter->process($_SESSION["idusuario"]);
    $accion = '';

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $paradatipo = new paradatipo($id, $paradatipo, $usr, $estado, null);
            $paradatipo->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGPARADATIPO', null, null);
            $bitacora->insertar();
        } else {
            $paradatipo = new paradatipo(null, $paradatipo, $usr, $estado, null);
            $paradatipo->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROMGPARADATIPO', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=paradatipo&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _modificarAction() {//producción 2019
    $filter = new InputFilter();

    $id = $filter->process($_GET['id']);

    $paradatipo = new paradatipo();
    $paradatipo->obtenerxId($id);

    require 'view/paradatipo-form.php';
}

function _eliminarAction() {//producción 2019
    /*
     * Funcion para eliminar un registro
     */
    $filter = new InputFilter();
    $usr = $filter->process($_SESSION["idusuario"]);
    try {
        $id = $filter->process($_GET['id']);
        $paradatipo = new paradatipo();
        $paradatipo->eliminar($id);

        $accion = 'Eliminar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROMGPARADATIPO', null, null);
        $bitacora->insertar();


        header("location: index.php?page=paradatipo&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>