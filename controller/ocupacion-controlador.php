<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/usuarios.php';
require_once 'model/ocupacion.php';
require_once 'controller/class.inputfilter.php';
include 'controller/validar-sesion.php';

function _formAction(){

    require 'view/grupos-form.php';
}

function _listarAction(){    //producción 2019

    $ocupacion= new Ocupacion();
    $ocupaciones = $ocupacion->consultar();
    $usuario = new Usuario();

    require 'view/ocupacion-registro.php';
}

function _ajaxverdetalleocupacionAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $ocupacion_id = new Ocupacion();
    $ocupacion_id->obtenerxId($id);
    $permiso = $_POST['permiso'];

    require_once 'view/ocupacion-form.php';
}


function _insertarAction(){ //producción 2019
    
    session_start();
     $filter = new InputFilter();
    $ocupacion = $filter->process($_POST["ocupacion"]);
    $estado = $filter->process( $_POST["optionsRadios"]);
    $usr = $_SESSION["idusuario"];


    
    try{
        if (!empty($_GET["id"])){
            $id = $filter->process( $_GET["id"]);
            $ocupacion = new Ocupacion($id, $ocupacion, $estado, $usr, null,'0');
            $ocupacion->modificar();
         
        }else{
            $ocupacion = new Ocupacion(null, $ocupacion, $estado, $usr, '0');
            $ocupacion->insertar();
         
        }

        header("location: index.php?page=ocupacion&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}




function _eliminarAction(){//producción 2019
  
   $filter = new InputFilter();

    try{
        $id = $filter->process ($_GET['id']); 
        
          $ocupacion = new Ocupacion();
      
      
        $validar = $ocupacion->validarocupacioncount($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=ocupacion&accion=listar';
                </script>";
        } else {
          $ocupacion->eliminar($id);
          header("location: index.php?page=ocupacion&accion=listar");
        }

        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>