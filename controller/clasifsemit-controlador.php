<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/clasifsemit.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';


function _listarAction() {   //PRODUCCION 2019 
    $clasifsemit = new clasifsemit();
    $clasifsemiterminado = $clasifsemit->consultar();

    $usuario = new Usuario();

    require 'view/clasifsemit-registro.php';
}

function _ajaxverdetalleclasifsemitAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $clasifsemit = new clasifsemit();
    $clasifsemit->obtenerxId($id);
    $permiso = $_POST['permiso'];

    require_once 'view/clasifsemit-form.php';
}

function _insertarAction() {//producción 2019
    session_start();

    $filter = new InputFilter();

    $clasem_titulo = $filter->process($_POST["clasem_titulo"]);
    $estado = $filter->process($_POST["optionsRadios"]);
    $usr = $filter->process($_SESSION["idusuario"]);
    $accion = '';

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $clasifsemit = new clasifsemit ($id, $clasem_titulo, $usr, $estado, null);
            $clasifsemit->modificar();

            $accion = 'Modificar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROCLASIFSEMITERMINADO', null, null);
            $bitacora->insertar();
        } else {
            $clasifsemit = new clasifsemit(null, $clasem_titulo, $usr, $estado, null);
            $clasifsemit->insertar();

            $accion = 'Insertar';
            $bitacora = new bitacora(null, $usr, $accion, 'PROCLASIFSEMITERMINADO', null, null);
            $bitacora->insertar();
        }

        header("location: index.php?page=clasifsemit&accion=listar");
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
        $clasifsemit = new clasifsemit();
        $clasifsemit->eliminar($id);

        $accion = 'Eliminar';
        $bitacora = new bitacora(null, $usr, $accion, 'PROCLASIFSEMITERMINADO', null, null);
        $bitacora->insertar();


        header("location: index.php?page=clasifsemit&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>