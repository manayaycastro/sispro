<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/areas.php';
require_once 'model/prensa.php';
require_once 'model/usuarios.php';
require_once 'model/kanban.php';
require_once 'model/planificacion.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';
      date_default_timezone_set('America/Lima');
function _formreportProdTelAction() {   //PRODUCCION 2021 
    $tipo = 'ProduccionDetalleXCintas';
    $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
	$proceso_id = '167';
    require 'view/reportproces-form.php';
}

function _reportprodprocimpAction() {   //PRODUCCION 2021 
	 $filter = new InputFilter();

    $rango = $filter->process($_POST["rango"]);
     $procesos = $filter->process($_POST["procesos"]);
   
   
   $fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');
 
  
 $fechaInicio=strtotime($fecinicio);
$fechaFin=strtotime($fecfinal);


$a= 0;
$produccion = new planificacion();
    if($procesos == '170'){
         $lista_resumen =$produccion->ConsultarProducProcesoXfecha2($ini, $fin, $procesos);
          require 'view/reportes/reporte-produccprocesos2.php';
    
    }elseif ($procesos == '167') {     
            $lista_resumen =$produccion->ConsultarProducProcesoXfecha_TEL($ini, $fin, $procesos);
          require 'view/reportes/reporte-produccprocesos3.php';
    }else{
         $lista_resumen =$produccion->ConsultarProducProcesoXfecha($ini, $fin, $procesos);
          require 'view/reportes/reporte-produccprocesos.php';
    }
//    $lista_resumen =$produccion->ConsultarProducProcesoXfecha($ini, $fin, $procesos);


   
}

function _formreportProdTel2Action() {   //PRODUCCION 2021 
    $tipo = 'ProduccionDetalleXDescripcion';
    $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
	$proceso_id = '167';
    require 'view/reportproces-form.php';
}

function _reportprodprocimp2Action() {   //PRODUCCION 2021 
	 $filter = new InputFilter();

    $rango = $filter->process($_POST["rango"]);
     $procesos = $filter->process($_POST["procesos"]);
   
   
   $fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');
 
  
 $fechaInicio=strtotime($fecinicio);
$fechaFin=strtotime($fecfinal);


$a= 0;
$produccion = new planificacion();
    if($procesos == '170'){
         $lista_resumen =$produccion->ConsultarProducProcesoXfecha2($ini, $fin, $procesos);
          require 'view/reportes/reporte-produccprocesos2.php';
    
    }elseif ($procesos == '167') {     
            $lista_resumen =$produccion->ConsultarProducProcesoXfecha_TEL($ini, $fin, $procesos);
          require 'view/reportes/reporte-produccprocesosCosTel.php';
    }else{
         $lista_resumen =$produccion->ConsultarProducProcesoXfecha($ini, $fin, $procesos);
          require 'view/reportes/reporte-produccprocesos.php';
    }
//    $lista_resumen =$produccion->ConsultarProducProcesoXfecha($ini, $fin, $procesos);


   
}

?>
