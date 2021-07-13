<?php


if(isset($_SESSION['modusuario'])){
    if($_SESSION['modusuario'] == "Administrador"){
        
    }else{
        $error = "Usted no tiene suficientes privilegios";
        header("location: error.php?mssg=$error");
    }
}

?>