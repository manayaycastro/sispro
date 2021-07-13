<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/areas.php';
require_once 'model/prensa.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';



function _formreportresdiaAction() {   //PRODUCCION 2021 
   

    require 'view/reportresumendia-form.php';
}
function _formreportresdiaimpAction() {   //PRODUCCION 2021 
   

    require 'view/reportresumendiaimp-form.php';
}
function _reportresdiaimpAction() {   //PRODUCCION 2021 
	 $filter = new InputFilter();

    $rango = $filter->process($_POST["rango"]);
   
   
   $fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');


$produccion = new prensa();
    $lista_resumen =$produccion->ConsultarProduccResumenDia($ini,$fin);
$a= 0;

    require 'view/reportes/reporte-enfardadoresumenpordia.php';
}

function _ajaxverclasebAction() {//producción 2019
	
	$filter = new InputFilter();

   $id  = $filter->process($_POST['id']);
   // $id = $_POST['id'];
   $tipo = '';
    $claseb = new prensa();
    $claseb_lista =$claseb->conultarClaseB($id);
   
   

    require_once 'view/vistahtml/mostrar-contenido-claseb-form.php';
}

?>
