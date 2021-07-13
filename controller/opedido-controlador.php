<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/perfiles.php';
require_once 'model/usuarios.php';
require_once 'model/opedido.php';
require_once 'controller/class.inputfilter.php';
include 'controller/validar-sesion.php';



function _listarAction() {//producción 2019
    
   
    require_once 'view/opedido-registro.php';
}
function _ajaxverpdfAction() {//producción 2019
    $id = $_POST['id'];
    $ops = new opedido();
    $opedidos =$ops->consultarOp($id);
   
   

    require_once 'view/vistahtml/verpdfop-form.php';
}


function _ajaxvernotapedAction() {//producción 2019  
    $id = $_POST['id'];
    $ops = new opedido();
    $opedidos =$ops->consultarNotaPed($id);
   
   

    require_once 'view/vistahtml/verpdfnotaped-form.php';
}


function _ajaxvercomentariopedAction() {//producción 2019  ajaxvercomentarioped
    $id = $_POST['id'];
     $tipdoc = $_POST['tipdoc'];
    $ops = new opedido();
    $opedidos_coments =$ops->consultarcomentarios($id,$tipdoc);
   
   

    require_once 'view/vistahtml/vercomentariosped-form.php';
}


function _ajaxregistrarcomentsAction() {//producción 2019  ajaxvercomentarioped
    $comentario = $_POST['comentario'];
    $id = $_POST['op'];
//    $tipodoc = 'PEDIDO';
      $tipdoc = $_POST['tipdoc'];
     $tipodoc = $_POST['tipdoc'];
    $usuario_id = $_SESSION["idusuario"];
      $usuario_nickname= $_SESSION["usuario"];
    
    $ops = new opedido();
 $ops->insertarcoments($tipodoc,$id,$usuario_id,$comentario,$usuario_nickname);
    $opedidos_coments =$ops->consultarcomentarios($id,$tipdoc);
   

    require_once 'view/vistahtml/vercomentariosped-form.php';
}

function _ajaxverobspedAction() {//producción 2019  
    $id = $_POST['id'];
    $vbpermiso= $_POST['vbpermiso'];
    
    $ops = new opedido();
    $opedidos_obs =$ops->consultarobs($id);
   
   

    require_once 'view/vistahtml/verobsped-form.php';
}


function _ajaxregistrarobsAction() {//producción 2019  ajaxvercomentarioped
    $obs = $_POST['obs'];
    $id = $_POST['op'];
    $tipodoc = 'PEDIDO';
     $vbpermiso= $_POST['vbpermiso'];
    
    $usuario_id = $_SESSION["idusuario"];
      $usuario_nickname= $_SESSION["usuario"];
    
    $ops = new opedido();
 $ops->insertarobs($tipodoc,$id,$usuario_id,$obs,$usuario_nickname);
     
    $opedidos_obs =$ops->consultarobs($id);
   

    require_once 'view/vistahtml/verobsped-form.php';
}

function _corregirobsAction() { //producción 2019
    $response = array();

    $usuario_id = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

     $idobs = $_POST['idobs'];
    $id = $_POST['op'];
    $vbpermiso = $_POST['vbpermiso'];
    $accion = $_POST['accion'];
    //$fecha = getdate();
    
     $opedido = new opedido();
    if ($accion == "agregar") {
        $estado = 1;

             
        
        $status = $opedido->corregirobs($idobs,$usuario_id,$usuario_nickname,$id,$estado);
    } else {
         echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una obserbaciòn ya corregida, comunicase con el administrador del sistema', function(){}); 
                </script>";
         
       // $status=  "  <script> bootbox.alert('Para poder agregar una observaciòn, debe escribir un mensaje valido', function(){}); </script>";
    }

//    $response["status"] = $status;
//
//    header('Content-Type: application/json');


 $opedidos_obs =$opedido->consultarobs($id);
   

    require_once 'view/vistahtml/verobsped-form.php';
}



//producción 2019  solo para pruebas
function _mostrarreporteopAction(){

    $id = $_GET['id'];
  $ops = new opedido();

 $opedidos =$ops->consultarOp($id);


require_once 'view/reportes/reporte-op.php';
 
}


function _mostrarnotapedAction(){//para vista rapida de pdf

    $id = $_GET['id'];
 
  $ops = new opedido();

 $opedidos =$ops->consultarNotaPed($id);


require_once 'view/reportes/notaped-op.php';
 


}


function _ajaxverdisenoAction() {//producción 2019
    $id = $_POST['id'];
    $ops = new opedido();
    $disenos =$ops->consultarDisenoActivo($id);
   
   

    require_once 'view/vistahtml/verdisenovig-form.php';
}

function _aprobventasAction() { //producción 2019
    $response = array();

    $prodped_usr = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

     $idop = $_POST['idop'];
     $accion = $_POST['accion'];
      $iddiseno = $_POST['iddiseno'];
     $prodped_tipaprob = '1'; // 1 PARA LA APROBACION DE VENTA
     $ini = $_POST['ini'];
     $fin = $_POST['fin'];

    
     $opedido = new opedido();
    if ($accion == "agregar") {
       

        $status = $opedido->insertarAprob($idop,$iddiseno, $prodped_tipaprob, $prodped_usr);
      $response["status"] = $status;
    } else {
         echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una aprobación, comunicase con el administrador del sistema', function(){}); 
                </script>";
         

    }

   
 $ops = new opedido();
    $opedidos =$ops->consultar2($ini,$fin);

   
    require_once 'view/tablas/ajax-opedidos.php';
}

function _listarvbventasAction() {//producción 2019
    
   
    require_once 'view/opedidovbventas-registro.php';
}


function _listarObsAction() {//producción 2019
    
   
    require_once 'view/opedidoobs-registro.php';
}


function _aprobPlanificacionAction() { //producción 2019
    $response = array();

    $prodped_usr = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

     $idop = $_POST['idop'];
     $accion = $_POST['accion'];
      $iddiseno = $_POST['iddiseno'];
     $prodped_tipaprob = '2'; // 1 PARA LA APROBACION DE PLANIFICACION
     $ini = $_POST['ini'];
     $fin = $_POST['fin'];

    
     $opedido = new opedido();
    if ($accion == "agregar") {
       

        $status = $opedido->insertarAprob($idop,$iddiseno, $prodped_tipaprob, $prodped_usr);
      $response["status"] = $status;
    } else {
         echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una aprobación, comunicase con el administrador del sistema', function(){}); 
                </script>";
         

    }

   
 $ops = new opedido();
    $opedidos =$ops->consultarVbVentas($ini,$fin);

   
    require_once 'view/tablas/ajax-vbventas.php';
}


?>