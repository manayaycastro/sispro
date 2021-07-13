<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/submenu.php';
require_once 'model/subsubmenu.php';
require_once 'model/usuarios.php';
require_once 'model/menu.php';
require_once 'controller/class.inputfilter.php';


include 'controller/validar-sesion.php';

function _formAction(){
 
   require 'view/submenu-form.php';
}

function _listarAction(){   //producción 2019  

    $subsubmenu = new subsubmenu();
    $subsubmenus = $subsubmenu->consultar();
  
    require 'view/subsubmenu-registro.php';
}

function _ajaxverdetallesubsubmenuAction() {//producción 2019
   
    if(!empty($_POST['id'])){
         $id = $_POST['id'];
     
    }else{
        $id = 0;
    }
       $subsubmenu = new subsubmenu();
    $subsubmenu->obtenerxId($id);
    $permiso = $_POST['permiso'];
      
    $submenu = new Submenu();
    $submenus = $submenu->consultar();

    require_once 'view/subsubmenu-form.php';
}



function _insertarAction(){ //producción 2019
//    $menu = new Menu();
//    $menus = $menu->consultar();

    session_start();
    
    $filter = new InputFilter();
    
    $subsubmenu1 = $filter->process($_POST["subsubmenu"]);
    $submenu = $filter->process($_POST["submenu"]);
    $enlacesubsub = $filter->process($_POST["enlacesubsub"]);
    $usr = $_SESSION["idusuario"];

    
   
    try{
        if (!empty($_GET["id"])){
            $id = $filter->process($_GET["id"]);
            $subsubmenu = new subsubmenu($id, $subsubmenu1, $enlacesubsub, $usr, null, $submenu,'0');
            $subsubmenu->modificar();

        }else{
            $subsubmenu = new subsubmenu(null, $subsubmenu1, $enlacesubsub, $usr,NULL, $submenu, '0');
            $subsubmenu->insertar();
          
        }

        header("location: index.php?page=subsubmenu&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}

function _modificarAction(){ //producción 2019
    $filter = new InputFilter();
    
    $id = $filter->process($_GET['id']);
    
    $subsubmenu = new subsubmenu();
    $subsubmenu->obtenerxId($id);

           $submenu = new Submenu();
    $submenus = $submenu->consultar();
   


    require 'view/submenu-form.php';   
}

function _eliminarAction(){
    /*
     * Funcion para eliminar un registro
     */
    session_start();
    $accion = '';
    $usr = $_SESSION["idusuario"];

    $filter = new InputFilter();
    
    try{
        $id = $filter->process($_GET['id']); 
        $subsubmenu = new subsubmenu();
        $subsubmenu->eliminar($id);

       
        header("location: index.php?page=subsubmenu&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>