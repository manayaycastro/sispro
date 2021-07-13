<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/tabgeneral.php';
require_once 'model/areas.php';
require_once 'model/kanban.php';
require_once 'model/prensa.php';
require_once 'model/planificacion.php';
require_once 'model/usuarios.php';
require_once 'controller/class.inputfilter.php';

include 'controller/validar-sesion.php';



function _formgantttelAction() {   //PRODUCCION 2021 
   

    require 'view/gantttelares-form.php';
}
function _formreportsegpedAction() {   //PRODUCCION 2021 
   

    require 'view/reportestadoped-form.php';
}


function _reportsegpedimpAction() {   //PRODUCCION 2021 
	 $filter = new InputFilter();

    $rango = $filter->process($_POST["rango"]);
   
   
   $fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');


$planificacion = new planificacion();
    $lista_resumen =$planificacion->ConsultarSegPed($ini,$fin);
$a= 0;

    require 'view/reportes/reporte-seguimientoped.php';
}

function _formstockrollAction() {   //PRODUCCION 2021 
   

    require 'view/stockrollos-form.php';
}


function _reportstockrollosimpAction() {   //PRODUCCION 2021 
$filter = new InputFilter();	
$telares = '167';
$laminado = '168';
$impresion = '169';
$conversion = '170';
$bastillado = '171';


    $tipo_report_roll = $filter->process($_POST["tipo_report_roll"]);
    
    
if($tipo_report_roll == 'stock_proc'){
      require 'view/reportes/reporte-stockrollos.php';
}else if($tipo_report_roll== 'stock_sgte_proc'){
      require 'view/reportes/reporte-stockrollos-sgteproc.php';
}


  
}

function _programaprocAction() {   //PRODUCCION 2021 
    $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();

    require 'view/reportprogramaproc-form.php';
}
function _programaprocReportAction() {   //PRODUCCION 2021 
	 $filter = new InputFilter();

    $rango = $filter->process($_POST["rango"]);
   
   
   $fecinicio = substr($rango, 0, 10);  
$fecfinal = substr($rango, 13, 21);  
    
 $fecini = date_create($fecinicio)  ; 
 $ini= date_format($fecini, 'Y-m-d');
 
 $fecfin= date_create($fecfinal)  ; 
 $fin=  date_format($fecfin, 'Y-m-d');

    $procesos = $filter->process($_POST["procesos"]);
    
    
    
$planificacion = new planificacion();
  //  $lista =$planificacion-> Programacion_proceso_Actual($ini , $fin,$procesos);

    
    if($procesos=='167'){
          $lista =$planificacion-> Programacion_proceso_Actual($ini , $fin,$procesos);
          require 'view/reportes/reporte-programaprocTel.php';
    }elseif($procesos=='168'){
          $lista =$planificacion-> Programacion_proceso_Actual($ini , $fin,$procesos);
         require 'view/reportes/reporte-programaprocLam.php';
    }elseif($procesos=='169'){
          $lista =$planificacion->Programacion_proceso_Actual_Maq($ini , $fin,$procesos);
          require 'view/reportes/reporte-programaprocImp.php';
    }elseif($procesos=='170'){
          $lista =$planificacion-> Programacion_proceso_Actual($ini , $fin,$procesos);
          require 'view/reportes/reporte-programaprocConv.php';
    }
}

function _programaprocSegAction() {  
    $procesos = new kanban();
    $listaprocesos = $procesos->ListaProcesos();

    require 'view/reportSegui-form.php';
}

function _programaprocReportSegAction() {  
	 $filter = new InputFilter();


    $procesos = $filter->process($_POST["procesos"]);
     $tipo = $filter->process($_POST["tipo"]);
    
    
    
    
$planificacion = new planificacion();
   

    
    if($tipo=='seguimiento'){
         $lista =$planificacion-> Proceso_op_Iniciado($procesos);
          require 'view/reportes/reporte-programaprocSeg.php';
          
    }elseif($tipo=='Cambio'){
         $lista =$planificacion-> prog_cambiotej($procesos);
         require 'view/reportes/reporte-programaprocCamb.php';
    }
}

function _CerrarOrdAction() {  
   
$tabgen_id = 20;

     
 $tabgen = new tabgeneral();
 $lista = $tabgen->consultarActivosXtabGen($tabgen_id);
    
    

    require_once 'view/cerrarord-registro.php';
}


function _cerrarOpsAction() { 
    $response = array();

    $prodped_usr = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

     $idop = $_POST['idop'];
     $accion = $_POST['accion'];
      $op = $_POST['op'];
    
     $ini = $_POST['ini'];
     $fin = $_POST['fin'];
       $estado = $_POST['estado'];
    
     $opedido = new planificacion();
    if ($accion == "agregar") {
       

       $status = $opedido->cerrarOps($op,$idop, $prodped_usr);
      $response["status"] = $status;
    } else {
        
        if($prodped_usr== '1'){
             $status = $opedido->LiberarOps($op,$idop, $prodped_usr);
      $response["status"] = $status;
        }else{
           echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar, comuniquese con el administrador del sistema', function(){}); 
                </script>";
         
        }
        
      

    }

   
$progprocesos = new planificacion();

	 $listaprocesos =$progprocesos->ConsultarSegPedForm($ini,$fin,$estado);

   
    require_once 'view/tablas/ajax-cerrarops.php';
}


function _cambioMaqFormAction() {
     $cambiomaq= new planificacion();
    $lista_cambiomaq =$cambiomaq->listacambiomaq();
    
     
    $ops=$cambiomaq->ConsultarOPabierta();
    
     $procesos = new kanban();
    $listaprocesos = $procesos->ListaProcesos();
    
    require_once 'view/cambiomaq-registro.php';
}


function _cambiomaqAction() { 
    
     $filter = new InputFilter();


    $id = $filter->process($_POST["id"]);
     $maq_detino = $filter->process($_POST["maq_detino"]);
      $motivo = $filter->process($_POST["motivo"]); 
       $op = $filter->process($_POST["op"]);
        $accion = $filter->process($_POST["accion"]);
         $maqori = $filter->process($_POST["maqori"]);
          $idkanban = $filter->process($_POST["kanban"]);
      
            $artsemi = $filter->process($_POST["artsemi"]);
          $fecdispo = $filter->process($_POST["fecdispo"]);
          $mtrs = $filter->process($_POST["mtrs"]);
            $proceso= $filter->process($_POST["procesos"]);
    
    
    $response = array();

    $prodped_usr = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];
    
    //**************************** PARA CÁLCULO DE TIEMPO procesos
      $kanban = new kanban();
        $planificacion = new planificacion();
     $buscarConfigMaquina_destino = $kanban->BuscarConifgMaquina($artsemi, $maq_detino); // busca vel ini y tiempo de puesta apunto
      $buscarConfigMaquina_origen = $kanban->BuscarConifgMaquina($artsemi, $maqori);
      $fechadispo_destino = $planificacion->ListFecDispoxMaquina($maq_detino);
      
     $cuerpokanban = $kanban->cuerpokanban( $artsemi);
            if ($buscarConfigMaquina_destino) {
                foreach ($buscarConfigMaquina_destino as $lista) {
                    $velInicial_dest = $lista['artsemimaq_velinicial'];
                    $puestaMarcha_det = $lista['artsemimaq_puestapunto']; // esta en formato hr- min- seg
                }
            }
            
            if ($buscarConfigMaquina_origen) {
                foreach ($buscarConfigMaquina_origen as $list) {
                    $velInicial_ori = $list['artsemimaq_velinicial'];
                    $puestaMarcha_ori = $list['artsemimaq_puestapunto']; // esta en formato hr- min- seg
                }
            }
        
           if( $cuerpokanban){
                           foreach( $cuerpokanban as $listacue){
                                    $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
                           }
           }
	    if( $fechadispo_destino){
                           foreach( $fechadispo_destino as $listades){
                                    $fec_maq_destino= $listades['fecdispmaq_fechadisp'];
                           }
           }
$long_corte =  $cuerpo['48'];  
    
     $datos_dest = $kanban->calcular_tiempoXsigno($velInicial_dest, $mtrs,$fec_maq_destino,$proceso,$long_corte,'+');
     $datos_ori = $kanban->calcular_tiempoXsigno($velInicial_ori, $mtrs,$fecdispo,$proceso,$long_corte,'-');
 $nuevaFecha_produccion_dest = $datos_dest['1'];
 $tiempo_produccion_dest = $datos_dest['2'];
 $nuevaFecha_produccion_ori = $datos_ori['1'];
 
    //*************************FIN DE CALCULO DE TIEMPO

   /*UpdateFecDisponiMaq
    OBTENER EL SEMITERMINADO ID POR KANBAN
    OBTENER FECHA DE DISPONIBILIDAD DE MAQUINA DESTINO 
    
    */
    
   
    if ($accion == "agregar") {
       

       $status = $planificacion-> UpdateTblKanbanDet($idkanban,$maq_detino );
     $status = $planificacion-> UpdateTblDisponibilidadMaq($idkanban,$maq_detino,$fec_maq_destino,$tiempo_produccion_dest,$nuevaFecha_produccion_dest,$id );
     
        $status = $planificacion-> insertarCambioMaq($idkanban,$maqori,$maq_detino,$proceso,$motivo,$usuario_nickname ); 
        
           $status = $planificacion-> UpdateFecDisponiMaq($maq_detino,$nuevaFecha_produccion_dest );
              $status = $planificacion-> UpdateFecDisponiMaq($maqori,$nuevaFecha_produccion_ori );
       
      $response["status"] = $status;
    } else {
        
       
           echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar, comuniquese con el administrador del sistema', function(){}); 
                </script>";
      
    }

 header('Content-Type: application/json');



    echo json_encode($response);
}


?>
