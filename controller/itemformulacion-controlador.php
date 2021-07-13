<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/itemformulacion.php';
require_once 'model/clasifsemit.php';
require_once 'model/usuarios.php';
require_once 'model/semiterminado.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';



function _listarAction() { //producción 2019
    $filter = new InputFilter();

    $itemform = new itemformulacion();
    $itemformulacion = $itemform->consultar();


    require 'view/itemformulacion-registro.php';
}

function _ajaxverdetalleitemformAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $itemform = new itemformulacion();
    $itemform->obtenerxId($id);
    $permiso = $_POST['permiso'];

    $clasifsemit= new clasifsemit();
    $clasifsemiterminado = $clasifsemit->consultarActivos();
    
    $semiterminado= new semiterminado();
    $semiterminados = $semiterminado->consultarActivos();



    require_once 'view/itemformulacion-form.php';
}

function _insertarAction() { //producción 2019

    session_start();

    $filter = new InputFilter();


    $itemform_descripcion = $filter->process($_POST["itemform_descripcion"]);
    $itemform_pocision = $filter->process($_POST["itemform_pocision"]);

    $tipsem_id = $filter->process($_POST["tipsem_id"]);
    $clasem_id = $filter->process($_POST["clasem_id"]);

    $estado = $filter->process($_POST["optionsRadios"]);


    $accion = '';

    $usr = $_SESSION["idusuario"];


    
     try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            
            $id = $filter->process($_GET["id"]);
                $itemform = new itemformulacion($id, $itemform_descripcion, $itemform_pocision,  $tipsem_id,$clasem_id, $usr, $estado, NULL);
                $itemform->modificar();

                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMFORMULACION', null, null);
                $bitacora->insertar();
            
            
        } else {
            $itemform = new itemformulacion(null, $itemform_descripcion, $itemform_pocision, $tipsem_id,$clasem_id, $usr, $estado, NULL);
            $itemform->insertar();
            
                $accion = 'Modificar';
                $bitacora = new bitacora(null, $usr, $accion, 'PROITEMFORMULACION', null, null);
                $bitacora->insertar();
        }

        header("location: index.php?page=itemformulacion&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
 
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