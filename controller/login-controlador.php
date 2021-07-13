<?php

session_start();
/*
 * Script para validar el inicio de sesion
 * 
 */
require_once 'model/usuarios.php';
require_once 'class.inputfilter.php';



function _formAction(){ 
    
    require_once 'login.php';
}

function _loginAction() { //ok sqlserver
    $filter = new InputFilter();

    $user = $filter->process($_POST["user"]);
    $pass = $filter->process($_POST["pass"]);
     $_SESSION['server_vinculado'] = '[192.168.10.242].ELAGUILA.DBO.';

    $usuario = new Usuario();
    $validar = $usuario->validarID($user, $pass);

    if ($validar == true) {
        $_SESSION['usuario'] =  $usuario->getUsr_nickname(); // Guarda nombre de usuario
        $_SESSION['idusuario'] = $usuario->getUsr_id();     // Guarda id de usuario
        $_SESSION['perusuario'] =  $usuario->getPer_id();    // Guarda perfil del usuario
        
        $_SESSION['are_id'] = $usuario->getArea();     // Guarda id del area de referencia
        $_SESSION['nombres'] =  $usuario->getNombres();    // Guarda perfil los nombres de los empleados
        $_SESSION['codempl'] =  $usuario->getEmp_id();
       

//alert('hola');

       
        header("location: index.php");
    } else {
        header("location: index.php?page=login&accion=form");
    }
}

function _cerrarAction() {
    if (isset($_SESSION['usuario'])) {

        unset($_SESSION['usuario']); // Elimina usuario
        unset($_SESSION['idusuario']); // Elimina idusuario
        unset($_SESSION['modusuario']); // Elimina modo

        header("location: index.php?page=login&accion=form");
        die;
    }
}

?>
