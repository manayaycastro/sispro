<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/menu.php';
require_once 'model/bitacora.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';

function _formAction() {//producción 2019
    require 'view/menu-form.php';
}

function _listarAction() {    //producción 2019
    $menu = new Menu();
    $menus = $menu->consultar();
  
    
        $icons = $menu->listaricons();

    require 'view/menu-registro.php';
}
function _listar2Action() {    //producción 2019
 

    require 'view/vista-registro.php';
}

function _ajaxverdetallemenuAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }  
    $permiso = $_POST['permiso'];
    $menu_id = new Menu();
    $menu_id->obtenerxId($id);
    
    $icons = $menu_id->listaricons();
  

    require_once 'view/menu-form-detalle.php';
}

function _ajaxverdetallemenuurlAction() {//producción 2019
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
         
    } else {
        $id = 0;
       
    } 
      $permiso = $_GET['permiso'];
    $menu_id = new Menu();
    $menu_id->obtenerxId($id);
   
    $icons = $menu_id->listaricons();
 

    require_once 'view/menu-form-detalle.php';
}

function _insertarAction() { //producción 2019
    session_start();

    $filter = new InputFilter();

    $menu = $filter->process($_POST["menu"]);
    $enlace = $filter->process($_POST["enlace"]);
    $posicion = $filter->process($_POST["posicion"]);
    $icon = $filter->process($_POST["icon"]);

    $usr = $filter->process($_SESSION["idusuario"]);
    $accion= '';
   

    try {
        if (!empty($_GET["id"])) {
            $id = $filter->process($_GET["id"]);
            $menu = new Menu($id, $menu, $enlace, $posicion, $usr, null,$icon ,'0');
            $menu->modificar();
            
            $accion = 'Modificar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGMENU',null,null);
            $bitacora->insertar();
        } else {
            $menu = new Menu(null, $menu, $enlace, $posicion, $usr, $icon,'0');
            $menu->insertar();
            
            $accion = 'Insertar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGMENU',null,null);
            $bitacora->insertar();
        }

        header("location: index.php?page=menu&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _eliminarAction() { //producción 2019
//    session_start();
    $filter = new InputFilter();
 $usr = $filter->process($_SESSION["idusuario"]);
    try {

        $id = $filter->process($_GET['id']);
        $menu = new Menu();
        $validar = $menu->validarMenucount($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=perfiles&accion=listar';
                </script>";
        } else {
            $menu->eliminar($id);
             $accion = 'Eliminar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGMENU',null,null);
            $bitacora->insertar();
            header("location: index.php?page=menu&accion=listar");
        }

        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>