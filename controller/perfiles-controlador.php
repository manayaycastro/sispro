<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/perfiles.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';
include 'controller/validar-sesion.php';

function _formAction(){

    require 'view/perfiles-form.php';
}

function _listarAction(){  //producción 2019  

    $perf = new NombrePerfil();
    $perfs = $perf->consultar();
    $usuario = new Usuario();

    require 'view/perfiles-registro.php';
}

function _ajaxverdetalleperfilesAction() {//producción 2019
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $id = 0;
    }
    $perfil_id = new NombrePerfil();
    $perfil_id->obtenerxId($id);
    $permiso = $_POST['permiso'];

    require_once 'view/perfiles-form.php';
}




function _insertarAction(){//producción 2019
    
    session_start();
    $filter = new InputFilter();
    $perf = $filter->process ($_POST["perf"]);
    $estado = $filter->process ( $_POST["optionsRadios"]);
    $usr = $_SESSION["idusuario"];
     $accion= '';

    try{
        if (!empty($_GET["id"])){
            $id = $filter->process($_GET["id"]);
            $perf = new NombrePerfil($id, $perf, $estado, $usr, null,'0');
            $perf->modificar();
            
             $accion = 'Modificar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGPERFILES',null,null);
            $bitacora->insertar();


        }else{
            $perf = new NombrePerfil(null, $perf, $estado, $usr, '0');
            $perf->insertar();
            
            $accion = 'Insertar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGPERFILES',null,null);
            $bitacora->insertar();

           
        }

        header("location: index.php?page=perfiles&accion=listar");
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getTraceAsString());
        header("location: error.php?mssg=:$error");
        die;
    }
}


function _eliminarAction(){//producción 2019
 
   $filter = new InputFilter();
   $usr = $filter->process($_SESSION["idusuario"]);
    try{
        $id = $filter->process ($_GET['id']); 
        $perf = new NombrePerfil();
      
        $validar = $perf->validarperfilusuariocount($id);

        if ($validar) {

            echo "<script type='text/javascript'> 
             
               alert('ERROR!! ... Este registro mantiene relacion con otros registros')  ; 
              window.location = 'index.php?page=perfiles&accion=listar';
                </script>";
        } else {
           $perf->eliminar($id);
             $accion = 'Eliminar';
            $bitacora = new bitacora(null,$usr,$accion,'PROMGPERFILES',null,null);
            $bitacora->insertar();
            header("location: index.php?page=perfiles&accion=listar");
        }

       
        die;
    } catch (Exception $exc) {
        $error = urlencode($exc->getMessage());
        header("location: error.php?mssg=:$error");
        die;
    }
}

?>