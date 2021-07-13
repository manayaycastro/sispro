<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'model/bitacora.php';
require_once 'model/perfiles.php';
require_once 'model/maquinas.php';
require_once 'model/usuarios.php';
require_once 'model/opedido.php';
require_once 'model/kanban.php';
require_once 'controller/class.inputfilter.php';
include 'controller/validar-sesion.php';




function _listarprogkanbanAction() {//producción 2019
    $area = '4';
   
    require_once 'view/opedidovbplanif-registro.php';
}



function _progkanbanAction() { //producción 2019
    $response = array();
    $kanban = new kanban();
    $prodped_usr = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

    $idop = $_POST['idop'];
    $accion = $_POST['accion'];
    $idmetrosxrollo = $_POST['idmetrosxrollo'];
    $idlargocorte = $_POST['idlargocorte'];
    $idclaseb = $_POST['idclaseb'];
    $idcantped = $_POST['idcantped'];
    $prodped_tipaprob = '3'; // 1 PARA LA APROBACION DE PLANIFICACION, para este caso funciona como un booleano
    $ini = $_POST['ini'];
    $fin = $_POST['fin'];
        $idlargoparche = $_POST['idlargoparche'];
        $artsemi = $_POST['artsemi'];
  //buscar tipo de producto   
  $color_op = $kanban->color_rand();
  
  $tipproducto='';
  $variedad=''; 
  $ancho=''; 
   $lagcorte= '';  
         $consultarTipProducto=$kanban->ConsultarTipoProducto($idop);
         if( $consultarTipProducto){
			 foreach ($consultarTipProducto as $lista){
				 $tipproducto = round ($lista['tipproducto'],0);
				  $variedad = round ($lista['variedad'],0);
				   $ancho = round ($lista['ancho'],0);
				    $lagcorte = round ($lista['lagcorte'],2);
			 }
			 		 
		 }
		 
		 if($tipproducto =='59' and  $variedad =='1'){ //arpilleras
			 $cant_sacos_producir = $idcantped + ($idcantped * $idclaseb) / 100;
			 $cant_metros_totales = ($cant_sacos_producir * $idlargocorte);
			 $cant_rollos_final =  $cant_sacos_producir;
			 $cant_rollos_final_pucho = 0;
			 $totalkanban= $cant_rollos_final;
			 
		 }elseif($tipproducto =='67' and  $variedad =='2'){//mantas
			 $cant_paños = 0;
			 
			 if($ancho%6== 0){
				 $cant_paños = $ancho/6;
			 }elseif ($ancho%5 == 0){
				 $cant_paños = $ancho/5;
			 }elseif($ancho%4 == 0){
				 $cant_paños = $ancho/4;
			 }else{
				 $cant_paños = 1;
			 }
			 $cant_sacos_producir = $idcantped;
			 $cant_metros_totales = ($cant_sacos_producir * $idlargocorte)*$cant_paños ;
			 $cant_rollos_final = $cant_metros_totales / $idmetrosxrollo;
			  $cant_rollos_final_pucho = $cant_metros_totales % $idmetrosxrollo;
			 
			// $totalkanban= round ($cant_rollos_final);
			
				$totalkanban=0;
				 if ($cant_rollos_final_pucho > 0) {
					 $totalkanban = (int)$cant_rollos_final+1;
				 }else{
					  $totalkanban = (int)$cant_rollos_final;
				 }
			
		 }else{ // sacos
			 // *************** Inicio de calculos para sacos sacos
				$cant_sacos_producir = $idcantped + ($idcantped * $idclaseb) / 100;
				$cant_metros_totales = ($cant_sacos_producir * $idlargocorte) / 39.37;
				

				$cant_rollos_final = $cant_metros_totales / $idmetrosxrollo;
				$cant_rollos_final_pucho = $cant_metros_totales % $idmetrosxrollo;
				//$mostrar = $cant_rollos_final_pucho;
				
				$totalkanban=0;
				 if ($cant_rollos_final_pucho > 0) {
					 $totalkanban = (int)$cant_rollos_final+1;
				 }else{
					  $totalkanban = (int)$cant_rollos_final;
				 }
			// *************** fin de calculos para sacos sacos
		 }
        
//print_r ($mostrar);

// *************** Inicio de calculos para sacos sacos
$cant_metros_parche = (($cant_sacos_producir*$idlargoparche)/(8))/100; //8 por la cantidad de parches que sale cada largo de parche, 
	 															//100 de conversion cm a m
	$totalkanban_parch= '0';
 $tipoacabado='0';
$codbaseplana='0';
$largoparche='0';
$artsemi_parche='0';


 $consultarbaseplana=$kanban->ConsultarBasePlanaOP($idop);
		
		 if($consultarbaseplana){
			 foreach($consultarbaseplana as $lista){
				 $tipoacabado= round ($lista['tipacabado'],2);
				 $codbaseplana= round ($lista['codbaseplana'],2);
				 $largoparche=$lista['largoparche'];
				 $artsemi_parche=$lista['artsemi_id'];
			 }
		 
		 }
		
		 if($tipoacabado == '145'){
			   $cant_rollos_final_parch = $cant_metros_parche / 3000;
						$cant_rollos_final_pucho_parch = $cant_metros_parche % 3000;
			 
						 if ($cant_rollos_final_pucho_parch > 0) {
							 $totalkanban_parch = (int) $cant_rollos_final_parch+1;
						 }else{
							 $totalkanban_parch = (int)$cant_rollos_final_parch;
						 }
			
		 }

// *************** Fin de calculos para sacos sacos




//10 clase b



    if ($accion == "agregar") {

        $status=$kanban->insertarkanban($idop, $idmetrosxrollo, $idlargocorte, $idclaseb, $cant_metros_totales, $usuario_nickname,$totalkanban, $cant_metros_parche,  	$totalkanban_parch,$color_op);

$a=0;
        for ($index = 1; $index <= $cant_rollos_final; $index++) {
             $status=$kanban->insertarkanbandet($idop, $index, $idmetrosxrollo, $usuario_nickname, 'saco', $artsemi);
             $a++;
        }
        
        




        if ($cant_rollos_final_pucho > 0) {
             $a++;
             if($cant_rollos_final_pucho < 500){
				 if($tipproducto =='67' and  $variedad =='2'){
					   $redondeo = $cant_rollos_final_pucho;
				 }else{
					  $redondeo = '500';
				 }
				
			 }else{
				  $redondeo= $cant_rollos_final_pucho;
			 }
            $status=$kanban->insertarkanbandet($idop, $a,$redondeo, $usuario_nickname,'saco', $artsemi);
        }

		 if($tipoacabado== '145'){
			 
						for ($index = 1; $index <=  $cant_rollos_final_parch ; $index++) {
							 $a++;
							 $status=$kanban->insertarkanbandet($idop, $a, '3000', $usuario_nickname, 'parche', $codbaseplana);
							  $status=$kanban->insertarkanbandet($idop, $a, '3000', $usuario_nickname, 'parche', $codbaseplana);
							
						}

						if ($cant_rollos_final_pucho_parch  > 0) {
							 $a++;
							$status=$kanban->insertarkanbandet($idop, $a, $cant_rollos_final_pucho_parch, $usuario_nickname,'parche', $codbaseplana);
							$status=$kanban->insertarkanbandet($idop, $a, $cant_rollos_final_pucho_parch, $usuario_nickname,'parche', $codbaseplana);
						}
			 
		 }
		
		
		
		
   
        $response["status"] = $status;
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una aprobación, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }


    $ops = new kanban();
    $opedidos = $ops->consultarVbPlanificacion($ini, $fin);


    require_once 'view/tablas/ajax-vbplanificacion.php';
}


function _ajaxListarKanbanAction() {//producción 2019  ajaxvercomentarioped
    $op = $_POST['op'];
      $codart = $_POST['codart'];
      
       $artsemi = $_POST['artsemi'];
       $area = $_POST['area'];
     $proceso = '167';
     $estado = '1';
    $kanban = new kanban();
//    $listakanban =$kanban->ListaKanban($op);
    $listakanban =$kanban->ListaKanbanV02($op,$area,$proceso);
   
   $listamaquinas = $kanban->ListaMaquinas($area);

    require_once 'view/vistahtml/verkanban-form.php';
}

function _InsertTelarAction() { //producción 2019
    $response = array();

    $prodped_usr = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

    $idkanban = $_POST['idkanban'];
    
    $op = $_POST['op'];
    $accion = $_POST['accion'];
    
    $telar = $_POST['telar'];
   
    $ini = $_POST['ini'];
    $fin = $_POST['fin'];


    $kanban = new kanban();
    if ($accion == "agregar") {

        $status=$kanban->insertarTelar($idkanban, $telar);

        $response["status"] = $status;
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una aprobación, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }


     $kanban = new kanban();
    $listakanban =$kanban->ListaKanban($op);
   
   $listamaquinas = $kanban->ListaMaquinas();

    require_once 'view/vistahtml/verkanban-form.php';
}
function _progprocesosAction() {//producción 2019
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}


function _progprocesosGuardarAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $id_kanban_det = $filter->process($_POST['id_kanban_det']);
    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']);
    
   //********************FECHA  
       $fec = $filter->process($_POST['fecha_programacion']);
      $date_fec = date_create($fec);
$fecha_programacion = date_format($date_fec, 'Y-d-m H:i:s');
    
 //  $fecha_programacion = $filter->process($_POST['fecha_programacion']);
  // ****************FECHA 

    $procesos = $filter->process($_POST['procesos']);
    
    $estado = $filter->process($_POST['estado']);
    $accion = $filter->process($_POST['accion']);
           

    $usuario_nickname = $filter->process($_SESSION['usuario']);
    
    $codart = $filter->process($_POST['codart']);
    $artsemi_id = $filter->process($_POST['artsemi_id']);
    $items = $filter->process($_POST['items']);
      $opedido = $filter->process($_POST['opedido']);

    $kanban = new kanban();
    $a=0;$b= 0; $siguiente_proceso=0;
    if ($accion == "agregar") {
        $buscarSiguienProceso=$kanban->ListaProcesoXarticulo($artsemi_id, $id_kanban_det);
        if($buscarSiguienProceso){
            foreach ($buscarSiguienProceso as $list) {
                $a++;
                $lista_arreglo [$a] = $list['valitemcarac_valor'];
                if ($list['valitemcarac_valor'] == $procesos) {
                    $b = $a;
                }
            }


            for ($index = 1; $index <= count($lista_arreglo); $index++) {
                if ($index == ($b + 1)) {
                    $siguiente_proceso = $lista_arreglo[$index];
                }
            }
        }
      //***************prueba para ingresar doble programacion en rollo tipo parche  $items['prokandet_id']
        if( $procesos == '167'){
			  $listaXitems = $kanban->BuscarItemsduplicados($opedido, $items);
			   if ($listaXitems) {
				     foreach ($listaXitems as $lista) {
					
						  $status=$kanban->insertarProgProcesos($procesos, $lista['prokandet_id'],  $lista['prokandet_id'],  $fecha_programacion,$usuario_nickname,$siguiente_proceso);
					
					 }
				   
			   }else {
			
			   }
			   
			   
		}else{
			
			 $status=$kanban->insertarProgProcesos($procesos,$id_kanban_det, $id_kanban_det,  $fecha_programacion,$usuario_nickname,$siguiente_proceso);
		}
       
         //***************fin para ingresar doble programacion en rollo tipo parche  

       // $status=$kanban->insertarProgProcesos($procesos,$id_kanban_det, $id_kanban_det,  $fecha_programacion,$usuario_nickname,$siguiente_proceso);

        $response["status"] = $status;
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una programación, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }


    $ops = new kanban();
    $listaprocesos = $ops->consultarProceso($ini, $fin,$procesos,$estado);


    require_once 'view/tablas/ajax-progprocesos.php';
}

function _inicprocesoAction() {
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/inicprocesos-registro.php';
}


function _ajaxInicProcesoAction() {
    
    

    $propro_id =  $_POST['propro_id'];
    
        $ini = $_POST['ini'];
    $fin = $_POST['fin']; 
    $procesos = $_POST['procesos'];
    $estado = $_POST['estado'];
      $area = $_POST['area'];
      $maquina = $_POST['maquina'];
        $items = $_POST['items'];
      $opedido = $_POST['opedido'];
     


    require_once 'view/vistahtml/mostrarinicioprog-form.php';
}

function _insertarinicioAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $propro_id = $filter->process($_POST['propro_id']);
    $fecha_inicio = $filter->process($_POST['fecha_inicio']);
    $hora_inicio = $filter->process($_POST['hora_inicio']);
    

    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
      $items = $filter->process($_POST['items']);
      $opedido = $filter->process($_POST['opedido']);

    $usuario_nickname = $filter->process($_SESSION['usuario']);
$ultimoid= '0';
    $kanban = new kanban();
    
    $buscar_inicio =$kanban->ConsultarMaqXprogpro_id($propro_id);
    
    if($buscar_inicio){
         echo "<script type='text/javascript'> 
             
               bootbox.alert('Se encontro un inicio ya registrado, se recomienda actualizar el navegador, de lo contrario comnunicarte con el area de TI', function(){}); 
                </script>";
         
    }else{
          if ($fecha_inicio != "" and $hora_inicio != "") {
		
		
  
   if( $procesos == '167'){
	    //***************prueba para ingresar doble al dar inicio en rollo tipo parche  
	    $listaprog=$kanban->ConsultarProgProcesXopXitem($procesos,$opedido,$items);
	    if($listaprog){
			foreach($listaprog as $list){
				//****************** registro doble*****************
				  $status=$kanban->insertarInicProg($list['progpro_id'],$fecha_inicio, $hora_inicio,$usuario_nickname);
       
					$ultimoID =$kanban->ultimoID();
					 if($ultimoID){
					 foreach($ultimoID as $list){
						 $ultimoid = $list['progprodet_id'];
					 }
					}
       
					$status=$kanban->insertarProducRollo($ultimoid, $usuario_nickname);
				
				
				//****************** registro doble*****************
			}
		}
	    
          //***************fin para ingresar doble programacion en rollo tipo parche  
   }else{
	   
	    $status=$kanban->insertarInicProg($propro_id,$fecha_inicio, $hora_inicio,$usuario_nickname);
       
        $ultimoID =$kanban->ultimoID();
         if($ultimoID){
         foreach($ultimoID as $list){
             $ultimoid = $list['progprodet_id'];
         }
        }
       
        $status=$kanban->insertarProducRollo($ultimoid, $usuario_nickname);
   }
   
   
   
       

    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('Ingresar valores validos', function(){}); 
                </script>";
    }

    }
    
  

//    $ops = new kanban();
//    $listaprocesos = $ops->consultarProcesoIniciar($ini, $fin,$procesos,$estado);
//    

    $response = array();

    $response['inserted'] = $status;

    header('Content-Type: application/json');

    echo json_encode($response);
}

function _ajaxGetListaInicProcesoAction(){
    $filter = new InputFilter();
 $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
       $maquina = $filter->process($_POST['maquina']);
    

    // $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);

$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarProcesoIniciar($ini,$fin,$procesos,$estado,$maquina);
    require_once "view/tablas/ajax-proginicioprocesos.php";
}


//************************************** registro de produccion rollos*******************************
function _producrolloAction() {
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/listaregistroproduc-registro.php';
}

function _ajaxFormRegisProduccAction() {
    
    

    $proroll_id =  $_POST['proroll_id'];
    
    $ini = $_POST['ini'];
    $fin = $_POST['fin']; 
    $procesos = $_POST['procesos'];
    $estado = $_POST['estado'];
      $maquina = $_POST['maquina'];
      
      $items = $_POST['items'];
      $opedido = $_POST['opedido'];
       $acceso = $_POST['acceso'];
    
    $mtrstotales = $_POST['mtrstotales'];
     
 $emp = new kanban();
  //$listaemp = $emp->consultarEmp();
  
  if($procesos== '167' and $maquina!= '-1'){
	  $listaemp = $emp->consultarEmpXmaq($maquina);
  }else{
	   $listaemp = $emp->consultarEmp();
  }
  
  $listProductos = $emp->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);

    require_once 'view/vistahtml/mostrarregistroproduccrollo-form.php';
}

function _insertarProduccRolloAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $proroll_id = $filter->process($_POST['proroll_id']);
    $emp = $filter->process($_POST['emp']);
    $mtrslineales = $filter->process($_POST['mtrslineales']);
    $comentario = $filter->process($_POST['comentario']);
    $peso = $filter->process($_POST['peso']);
    

    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
    
     $items = $filter->process($_POST['items']);
    $opedido = $filter->process($_POST['opedido']); 
     $acceso = $filter->process($_POST['acceso']); 
    
    
    if ( $procesos == '167'){
		  $mtrstotales = ($filter->process($_POST['mtrsavance']))*(-1)+  $mtrslineales;
	}
     // $mtrstotales = ($filter->process($_POST['mtrsavance']))*(-1)+  $mtrslineales;

    $usuario_nickname = $filter->process($_SESSION['usuario']);

    $kanban = new kanban();
    $metros_totales = '0';
    $peso_totales= '0';
    if ($mtrslineales != "" and $peso != "") {
		
        if( $procesos == '167'){
			// ingresar doble la produccion para tipo parche
			
			  $listaproducc=$kanban->ConsultarProgRollXopXitem($procesos,$opedido,$items);
	    if($listaproducc){
                foreach($listaproducc as $list){
                        //****************** registro doble*****************
                        $status=$kanban->insertarProduccRolloParcial($list['proroll_id'],$mtrslineales, $peso,$emp,$comentario,$usuario_nickname);

                            $sumaProduccion= $kanban->sumaacumulada($list['proroll_id']);
                            if($sumaProduccion){
                                    foreach ($sumaProduccion as $lista){
                                       $metros_totales = $metros_totales + $lista ['prorolldet_mtrs'];
                                       $peso_totales = $peso_totales + $lista ['prorolldet_peso'];
                                    }
                            }

                            $status=$kanban->UpdateTotalAvance($list['proroll_id'],$metros_totales,$peso_totales);
                            $metros_totales = '0';
                            $peso_totales= '0';

                        //****************** registro doble*****************
                }
            }
			
			
			
			// fin de ingresar  doble la produccion para tipo parche
        }else{

        $status=$kanban->insertarProduccRolloParcial($proroll_id,$mtrslineales, $peso,$emp,$comentario,$usuario_nickname);
        
        $sumaProduccion= $kanban->sumaacumulada($proroll_id);
            if($sumaProduccion) {
                foreach ($sumaProduccion as $lista) {
                    $metros_totales = $metros_totales + $lista ['prorolldet_mtrs'];
                    $peso_totales = $peso_totales + $lista ['prorolldet_peso'];
                }
            }

            $status=$kanban->UpdateTotalAvance($proroll_id,$metros_totales,$peso_totales);
       } 
        
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('Ingresar valores validos', function(){}); 
                </script>";
    }


 $kanban= new kanban();
  $listaemp = $kanban->consultarEmp();
  $listProductos = $kanban->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);

//    $response['inserted'] = $status;
//    header('Content-Type: application/json');
//    echo json_encode($response);
  
    require_once 'view/vistahtml/mostrarregistroproduccrollo-form.php';
}

function _ajaxGetActualizarListRolloAction(){
    $filter = new InputFilter();
 $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
      $maquina = $filter->process($_POST['maquina']);
    
    $proroll_id = $filter->process($_POST['proroll_id']);
    

$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarAvanceProduccRollo($ini,$fin,$procesos,$estado,$maquina);
    require_once "view/tablas/ajax-avanceproduccrollos.php";
}



function _cargarlistaAction() {//producción 2019

    $proroll_id = $_GET["cod"];
    
    

    $lista = new kanban();
    $listadet = $lista->listarProduccRolloDet($proroll_id);
    
     
    

    $html = " ";

          

       
     $html .= "<div class='widget-box transparent'>";
            $html .= "<div class='widget-header widget-header-flat'>";
                $html .= "<h4 class='widget-title lighter'>";
                    $html .= "<i class='ace-icon fa fa-star orange'></i>";
                        $html .= "Lista de diseños";
                $html .= "</h4>";

                        $html .= "<div class='widget-toolbar'>";
                            $html .= "<a href='#' data-action='collapse'> <i class='ace-icon fa fa-chevron-up'></i> </a>";
                        $html .= "</div>";
            $html .= "</div>";

            $html .="<div class='widget-body'>";
                $html .= "<div class='widget-main no-padding'>";
                    $html .= "<table class='table table-bordered table-striped'>";
                        
                        $html .= "<thead class='thin-border-bottom'>";
                        
                            $html .= "<tr>";
                                $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Còdigo</th>";
                                
                                $html .="<th><i class='ace-icon fa fa-caret-right blue'></i>ID Rollo </th>";
                                
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total metros</th>";
                                
                                 $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total peso</th>";

                                $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Operario</th>";
                                
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Usuario</th>";
                                 
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Fec. Creación</th>";
                            $html .= "</tr>";
                        $html .= "</thead>";

                        $html .= "<tbody>";

                    if ($listadet) {
                        foreach ($listadet as $lis){
                            
                       
                            $html .="<tr>";
                                $html .="<td>".$lis['prorolldet_id'];
                                       
                                $html .= "</td>";

                                $html .= "<td><b class='blue'>".$lis['proroll_id'];
                                
                                $html .= "</b></td>";
                                
                               
                                
                                $html .="<td>".$lis['prorolldet_mtrs'];
                                       
                                $html .= "</td>";

                                $html .= "<td class='hidden-480'>".$lis['prorolldet_peso'];
                                   
                                $html .= "</td>";
                                $html .= "<td class='hidden-480'>".$lis['prorolldet_operario'];
                                   
                                $html .= "</td>";
                                $html .= "<td class='hidden-480'>".$lis['usuario_creacion'];
                                   
                                $html .= "</td>";
                                
                                
                                  $date_fecped = date_create($lis['fecha_creacion']);

                                
                                $html .="<td>".$lis['fecha_creacion'];
                                       
                                $html .= "</td>";
                                
                                   $html .= "<input type='hidden' id = 'proroll_id' value='". $lis ['proroll_id']. "'>";
                            $html .= "</tr>";
                         }
                     } else {
                         $html .="<tr>";
                                $html .="<td colspan = '5'>";
                                       $html .= "no se encontraron registros!!";
                                $html .= "</td>";
                         $html .= "</tr>";
    }        

                        $html .="</tbody>";
                    $html .= "</table>";
                $html .="</div>";
            $html .= "</div>";
	$html .= "</div>";
        
        $html .= "<input type='hidden' id = 'prorollactual' value='". $proroll_id. "'>";
      





   




    echo $html;
}

function _cerrarProduccRolloAction() { //producción 2019
    $response = array();
    $filter = new InputFilter();
 $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
    $progprodet_id = $filter->process($_POST['progprodet_id']);
    
    $kandet_id = $filter->process($_POST['kandet_id']);
     $maquina = $filter->process($_POST['maquina']);

    $usuario_nickname = $filter->process( $_SESSION['usuario']);

    $proroll_id = $filter->process($_POST['proroll_id']);
    $accion = $filter->process($_POST['accion']);
    
        $items = $filter->process($_POST['items']);
    $opedido = $filter->process($_POST['opedido']); 

ini_set('date.timezone','America/Lima'); 
    $hora_actual = date("H:i:s");                         // 17:16:18
 $fecha_actual= date("Y-m-d");  
    
    $kanban = new kanban();
    if ($accion == "agregar") {
		
        if(  $procesos == '167'){

            $listaproducc=$kanban->ConsultarProgRollXopXitem($procesos,$opedido,$items);
            if($listaproducc){
                foreach($listaproducc as $list){
                        //****************** registro doble***************** $list['proroll_id']
                       $status=$kanban->CerraProduccRollo($list['proroll_id'], $usuario_nickname); //UPDATE

                        $status=$kanban->UpdateProgDetProceso($list['progprodet_id'], $fecha_actual,$hora_actual,$usuario_nickname);

                        $status=$kanban->UpdateCerraDisponibilidadTelar($list['prokandet_id']);
                        $status=$kanban->UpdateProgProcesosAtendido($list['prokandet_id']);		 

                        //****************** registro doble*****************
                }
            }

        }elseif($procesos == '171'){
                $lista=$kanban->ConsultarpendientesaPrensa($proroll_id);
                    if(count ($lista)==0){
                                     $status=$kanban->CerraProduccRollo($proroll_id, $usuario_nickname); //UPDATE

                                    $status=$kanban->UpdateProgDetProceso($progprodet_id, $fecha_actual,$hora_actual,$usuario_nickname);

                                    $status=$kanban->UpdateCerraDisponibilidadTelar($kandet_id);
                                    $status=$kanban->UpdateProgProcesosAtendido($kandet_id);
                    }else{
                            echo "<script type='text/javascript'> 

                       bootbox.alert('No se puede cerrar la atencion, aun se tiene pendiente de envios a prensa', function(){}); 
                            </script>";
                            $status = false;

                    }

        }else{

                                         $status=$kanban->CerraProduccRollo($proroll_id, $usuario_nickname); //UPDATE

                                $status=$kanban->UpdateProgDetProceso($progprodet_id, $fecha_actual,$hora_actual,$usuario_nickname);

                                $status=$kanban->UpdateCerraDisponibilidadTelar($kandet_id);
                                $status=$kanban->UpdateProgProcesosAtendido($kandet_id);
        }

       

        $response["status"] = $status;
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una aprobación, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }


$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarAvanceProduccRollo($ini,$fin,$procesos,$estado,$maquina);

    require_once 'view/tablas/ajax-avanceproduccrollos.php';
}

//************************************** fin ----> registro de produccion rollos*********************



//************************************** registro de asignacion de telares*******************************
function _ajaxListarTelaresAction() {//producción 2019  ajaxvercomentarioped   items
    $op = $_POST['op'];
    $codart = $_POST['codart'];
    $idkanban = $_POST['idkanban'];
    $mtrs = $_POST['mtrs'];
    $estado = $_POST['estado'];
     $proceso = $_POST['proceso'];
    $area = $_POST['area'];
     $artsemi = $_POST['artsemi'];

     $items = $_POST['items'];
    
    ini_set('date.timezone','America/Lima'); 
    //$hora_actual = date("H:i:s");                         // 17:16:18
 $fecha_actual= date("Y-m-d H:i:s");  
   $kanban = new kanban();

  
    
    $update_maq_disponib = $kanban->listarTiempoPendientes($codart,$area);
    
    if($update_maq_disponib){
        foreach ($update_maq_disponib as $lista){
            if($lista['movdismaq_idmaq'] != null){
				$hora = $kanban-> calcular_tiempo_hor($lista['tiempo_pendiente'] , '0:00');
                $min = $kanban->calcular_tiempo_min( $lista['tiempo_pendiente'] , '0:00');
				
                $fecha_nueva = new DateTime($fecha_actual);
             // $tiempo= round($lista['tiempo_pendiente'],2);
              // $fecha_produccion->modify("+$hora_ocupacion_maq hour");
               // $fecha_produccion->modify("+ $min_ocupacion_maq minute"); 
             
            
                $fecha_nueva->modify("+$hora hour");
                 $fecha_nueva->modify("+$min minute");
                $nuevaFecha_disponible = $fecha_nueva->format('Y-m-d H:i:s');
          
                $kanban->UpdatePROFECHADISPMAQUINA($lista['movdismaq_idmaq'], $nuevaFecha_disponible);
                
            }else{
                  $fecha_nueva = new DateTime($fecha_actual);
                 $kanban->UpdatePROFECHADISPMAQUINA($lista['movdismaq_idmaq'], $fecha_nueva);
            }
        }
    }


    $listamaquinas = $kanban->ListaDisponibilidadMaquinas($artsemi,$proceso,$area);

    require_once 'view/vistahtml/verListamaquinas-form.php';
}


function _ajaxGetDisponibilidadAction(){


    $id_maq_ocupacion = $_POST['id_maq_ocupacion'];

    $lista = new kanban();


    $ocupacion = $lista->ListaOcupacionMaquinas($id_maq_ocupacion);

    require_once 'view/vistahtml/ajaxdisponibilidad-form.php';

}

function _InsertTelarSeleccionadoAction() { //producción 2019
  
  
            
    $response = array();

    $prodped_usr = $_SESSION['idusuario'];
    $usuario_nickname = $_SESSION['usuario'];

    $idkanban = $_POST['idkanban2'];
    $codart = $_POST['codart'];

    $op = $_POST['op'];
    $accion = $_POST['accion'];
    $mtrs = $_POST['mtrs'];
    $maq_id = $_POST['maq_id'];
    $maqdisp = $_POST['maqdisp']; // para insertar o actualizar el tiempo de disponibilidad
    $fecdisp = $_POST['fecdisp'];
    print_r($fecdisp);
    $proceso = $_POST['proceso'];

    $artsemi = $_POST['artsemi'];
    $items = $_POST['items'];

    $ini = $_POST['ini'];
    $fin = $_POST['fin'];

    $velInicial = '0';
    $puestaMarcha = '0';
    $kanban = new kanban();
    if ($accion == "agregar") {

        $buscarKanban = $kanban->BuscarIdKanbanEnDisponib($idkanban, $proceso);
        if ($buscarKanban) {

            echo "<script type='text/javascript'> 
             
               alert('Esta Kanban ya se encuentra programado, ante cualquier cambio comuniquese con el administrador del sistema'); 
                </script>";
        } else {

            $buscarConfigMaquina = $kanban->BuscarConifgMaquina($artsemi, $maq_id); // busca vel ini y tiempo de puesta apunto

            if ($buscarConfigMaquina) {
                foreach ($buscarConfigMaquina as $lista) {
                    $velInicial = $lista['artsemimaq_velinicial'];
                    $puestaMarcha = $lista['artsemimaq_puestapunto']; // esta en formato hr- min- seg
                }

                $buscarConfigMaquinaXOP = $kanban->BuscarConifgMaquinaXOP($op, $maq_id); //para ver si ese pedido ya se encontraba programado en esa maquina

                $cuerpokanban = $kanban->cuerpokanban($artsemi);
                if ($cuerpokanban) {
                    foreach ($cuerpokanban as $listacue) {
                        $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
                    }
                }

                $long_corte = $cuerpo['48'];

                $datos = $kanban->calcular_tiempo($velInicial, $mtrs, $fecdisp, $proceso, $long_corte);
                $nuevaFecha_produccion = $datos['1'];
                $tiempoOcupacMaquina = $datos['2'];
                /*
                  $velocidadHora = $velInicial * 60; //METROS POR MINUTOS
                  // $tiempoOcupacMaquina = ceil($mtrs / $velocidadHora); gmdate('H:i:s', floor(5.5 * 3600));  // tiempo en horas ocupado por los metros a tejer
                  $tiempo_decimal =  round (floatval($mtrs / $velocidadHora),2);
                  $tiempoOcupacMaquina = gmdate('H:i:s', floor($tiempo_decimal * 3600)); // esta en formato hora- min - seg
                  //calculamos las horas  y min transcurridos PARA LA NUEVA PRODUCCION DEL ROLLO

                  $hora_ocupacion_maq = $kanban->calcular_tiempo_hor( $tiempoOcupacMaquina , '0:00');
                  $min_ocupacion_maq = $kanban->calcular_tiempo_min( $tiempoOcupacMaquina , '0:00');
                  //fin del calculo


                  $fecha_produccion = new DateTime($fecdisp);
                  //$fecha_produccion->modify("+$tiempoOcupacMaquina hour");
                  $fecha_produccion->modify("+$hora_ocupacion_maq hour");
                  $fecha_produccion->modify("+ $min_ocupacion_maq minute");
                  $nuevaFecha_produccion = $fecha_produccion->format('Y-m-d H:i:s'); //nueva fecha de disponibilidad cuando ya esta registrado para un op
                 */



                if ($buscarConfigMaquinaXOP) {
                    // inicio
                    if ($proceso == '167') {
                        $listaXitems = $kanban->BuscarItemsduplicados($op, $items);
                        if ($listaXitems) {
                            
                            foreach ($listaXitems as $items) {
                                

                                $status = $kanban->insertarOcupacionMaquina($maq_id, $op, $items['prokandet_id'], $mtrs, $fecdisp, $tiempoOcupacMaquina, $nuevaFecha_produccion, 'Programacion', $proceso, $maq_id);
                                $status = $kanban->insertarTelar($items['prokandet_id'], $maq_id);
                          }
                        } else {
                            $status = $kanban->insertarOcupacionMaquina($maq_id, $op, $idkanban, $mtrs, $fecdisp, $tiempoOcupacMaquina, $nuevaFecha_produccion, 'Programacion', $proceso, $maq_id);
                            $status = $kanban->insertarTelar($idkanban, $maq_id);
                        }
                    } else {

                        $status = $kanban->insertarOcupacionMaquina($maq_id, $op, $idkanban, $mtrs, $fecdisp, $tiempoOcupacMaquina, $nuevaFecha_produccion, 'Programacion', $proceso, $maq_id);
                        if ($proceso == '167') {
                            $status = $kanban->insertarTelar($idkanban, $maq_id);
                        }
                    }



                    if ($maqdisp == '0') {
                        $status = $kanban->InsertPROFECHADISPMAQUINA($maq_id, $nuevaFecha_produccion);
                    } else {
                        $status = $kanban->UpdatePROFECHADISPMAQUINA($maq_id, $nuevaFecha_produccion);
                    }


                    $response["status"] = $status;
                } else {

                    //calculamos las horas  y min transcurridos PARA LA NUEVA PUESTA EN MARCHA DEL ROLLO
                    // $fecha_puestamarcha_hora = new DateTime($fecdisp);
                    // $tiempo_puesta_marcha = $fecha_puestamarcha_hora ->format('H:i'); //TIEMPO EN HORAS DE LA FECHA EN LA QUE ESTA DISPONIBLE LA MAQUINA
                    $hora_ocupacion_puestpunto = $kanban->calcular_tiempo_hor($puestaMarcha, '00:00');
                    $min_ocupacion_puestpunto = $kanban->calcular_tiempo_min($puestaMarcha, '00:00');
                    //fin del calculo 

                    $fecha_puestamarcha = new DateTime($fecdisp);
                    // $fecha_puestamarcha->modify("+$puestaMarcha hour");
                    $fecha_puestamarcha->modify("+$hora_ocupacion_puestpunto hour");
                    $fecha_puestamarcha->modify("+ $min_ocupacion_puestpunto minute");
                    $nuevaFecha_puestamarcha = $fecha_puestamarcha->format('Y-m-d H:i:s'); //nueva fecha disponibilidad sumando Puesta Marcha




                    $status = $kanban->insertarOcupacionMaquina($maq_id, $op, $idkanban, $mtrs, $fecdisp, $puestaMarcha, $nuevaFecha_puestamarcha, 'Puesta Marcha', $proceso, $maq_id);


                    $hora_producPrimerReg = new DateTime($nuevaFecha_puestamarcha);
                    $tiempo_producPrimerReg = $hora_producPrimerReg->format('H:i');
                    // $hora_ocupacion_PrimReg = calcular_tiempo_hor(   $tiempo_producPrimerReg , '0:00');
                    //   $min_ocupacion_PrimReg = calcular_tiempo_hor(   $tiempo_producPrimerReg , '0:00');
                    $hora_ocupacion_maq = $datos['3'];
                    $min_ocupacion_maq = $datos['4'];

                    $fecha_producPrimerReg = new DateTime($nuevaFecha_puestamarcha);
                    $fecha_producPrimerReg->modify("+ $hora_ocupacion_maq hour");
                    $fecha_producPrimerReg->modify("+  $min_ocupacion_maq minute");
                    $nuevaFecha_primerReg = $fecha_producPrimerReg->format('Y-m-d H:i:s');


                    //  $fecha_producPrimerReg->modify("+$tiempoOcupacMaquina hour");
                    //$nuevaFecha_primerReg = $fecha_producPrimerReg->format('Y-m-d H:i:s'); //nueva fecha de disponibilidad cuando no esta registrado para un op (Primera vez)
                    //  $fecha_producPrimerafin = new DateTime($nuevaFecha_primerReg);
                    //  $fecha_producPrimerafin->modify("+$tiempoOcupacMaquina hour");
                    // $nuevaFecha_primerRegFin = $fecha_producPrimerafin->format('Y-m-d H:i:s'); //nueva fecha de disponibilidad cuando no esta registrado para un op (Primera vez)
                    //           $status = $kanban->insertarOcupacionMaquina  ($maq_id, $op, $idkanban, $mtrs, $nuevaFecha_primerReg, $tiempoOcupacMaquina, $nuevaFecha_primerRegFin, 'Programacion',$proceso,$maq_id);

                    if ($proceso == '167') {
                        $listaXitems = $kanban->BuscarItemsduplicados($op, $items);
                        if ($listaXitems) {
                            foreach ($listaXitems as $items) {
                                $status = $kanban->insertarOcupacionMaquina($maq_id, $op, $items['prokandet_id'], $mtrs, $nuevaFecha_puestamarcha, $tiempoOcupacMaquina, $nuevaFecha_primerReg, 'Programacion', $proceso, $maq_id);
                                $status = $kanban->insertarTelar($items['prokandet_id'], $maq_id);
                            }
                        } else {
                            $status = $kanban->insertarOcupacionMaquina($maq_id, $op, $idkanban, $mtrs, $nuevaFecha_puestamarcha, $tiempoOcupacMaquina, $nuevaFecha_primerReg, 'Programacion', $proceso, $maq_id);
                            $status = $kanban->insertarTelar($idkanban, $maq_id);
                        }
                    } else {


                        $status = $kanban->insertarOcupacionMaquina($maq_id, $op, $idkanban, $mtrs, $nuevaFecha_puestamarcha, $tiempoOcupacMaquina, $nuevaFecha_primerReg, 'Programacion', $proceso, $maq_id);

                        if ($proceso == '167') {
                            $status = $kanban->insertarTelar($idkanban, $maq_id);
                        }
                    }





                    if ($maqdisp == '0') {
                        $status = $kanban->InsertPROFECHADISPMAQUINA($maq_id, $nuevaFecha_primerReg);
                    } else {
                        $status = $kanban->UpdatePROFECHADISPMAQUINA($maq_id, $nuevaFecha_primerReg);
                    }

//                    $status = $kanban->UpdatePROFECHADISPMAQUINA($maq_id, $nuevaFecha_primerReg);
                    $response["status"] = $status;
                }
            } else {
                echo "<script type='text/javascript'> 
             
               alert('Este articulo no se encuentra asignada a esta máquina'); 
                </script>";
            }
        }
    }

    header('Content-Type: application/json');



    echo json_encode($response);
}

function _progLamiSistAction() {//producción 2019
    
   $proceso='168'; $area = '5';
    require_once 'view/progprocesossis-registro.php';
}
function _progImpresSistAction() {//producción 2019
    
   $proceso='169'; $area = '6';
    require_once 'view/progprocesossis-registro.php';
}
function _progConversSistAction() {//producción 2019
    
   $proceso='170'; $area = '7';
    require_once 'view/progprocesossis-registro.php';
}

function _progProcSacAction() {//producción 2019
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesossacos-registro.php';
}

function _progCortadSisAction() {//producción 2019
    
   $proceso='173'; $area = '7';
    require_once 'view/progprocesossis-registro.php';
}

//************************************** fin de asignacion de telares*******************************

function _ajaxListaProcesosAction() {//producción 2019  ajaxvercomentarioped  
    $op = $_POST['op'];
      $codart = $_POST['codart'];
       $area = $_POST['area'];
     $proceso = $_POST['proceso'];
     $estado = $_POST['estado'];
     
        $ini = $_POST['ini'];
    $fin = $_POST['fin'];

     
    $kanban = new kanban();
//    $listakanban =$kanban->ListaKanban($op);
    $opedidos =$kanban->ConsultarProgProcesoSistema($ini,$fin,$proceso,$estado);
  

    require_once 'view/tablas/ajax-progprocesossis.php';
}



function _ajaxFormRegisProduccSacosAction() {
    
    

    $proroll_id =  $_POST['proroll_id'];
    
    $ini = $_POST['ini'];
    $fin = $_POST['fin']; 
    $procesos = $_POST['procesos'];
    $estado = $_POST['estado'];
     $maquina = $_POST['maquina'];
       $acceso = $_POST['acceso'];
     
 $emp = new kanban();
  $listaemp = $emp->consultarEmp();
  $listProductos = $emp->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);

    require_once 'view/vistahtml/mostrarregistroproduccsacosconv-form.php';
}

function _ajaxFormRegisProduccSacosConverAction() {
    
    

    $proroll_id =  $_POST['proroll_id'];
    
    $ini = $_POST['ini'];
    $fin = $_POST['fin']; 
    $procesos = $_POST['procesos'];
    $estado = $_POST['estado'];
     $maquina = $_POST['maquina'];
      $acceso = $_POST['acceso'];
 $emp = new kanban();
  $listaemp = $emp->consultarEmp();
  $listProductos = $emp->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);

    require_once 'view/vistahtml/mostrarregistroproduccsacosconvfin-form.php';
}

function _insertarProduccSacoConvAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $proroll_id = $filter->process($_POST['proroll_id']);
    $emp = $filter->process($_POST['emp']);
     $obs = $filter->process($_POST['obs']);
    
    $clasea = $filter->process($_POST['clasea']);
    $telares = $filter->process($_POST['telares']);
    $laminado = $filter->process($_POST['laminado']);
    $impresion = $filter->process($_POST['impresion']);
    $conversion = $filter->process($_POST['conversion']);
    

    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);

    $sacos_total = $clasea +$telares+$laminado+$impresion+$conversion;
    $sacos_totalb =$telares+$laminado+$impresion+$conversion;
    
    $usuario_nickname = $filter->process($_SESSION['usuario']);

    $kanban = new kanban();
    $totales = '0';
    $totalesb= '0';
    if ($clasea != "" ) {

        $status=$kanban->insertarProduccSacoParcial(
                $proroll_id,$clasea,$telares,$laminado,$impresion,$conversion,$sacos_total,$sacos_totalb,$emp,$obs, $usuario_nickname);
        
        $sumaProduccion= $kanban->sumaacumuladaSacos($proroll_id);
        if($sumaProduccion){
            foreach ($sumaProduccion as $lista){
               $totales = $totales + $lista ['prosacodet_total'];
               $totalesb = $totalesb + $lista ['prosacodet_totalb'];
            }
        }
        
        $status=$kanban->UpdateTotalAvance($proroll_id,$totales,$totalesb);
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('Ingresar valores validos', function(){}); 
                </script>";
    }


 $kanban= new kanban();
  $listaemp = $kanban->consultarEmp();
  $listProductos = $kanban->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);


  
    require_once 'view/vistahtml/mostrarregistroproduccsacosconv-form.php';
}


function _cargarlistasacosAction() {//producción 2019

    $proroll_id = $_GET["cod"];
    
     $procesos= $_GET["procesos"];

    $lista = new kanban();
    $listadet = $lista->listarProduccSacoDet($proroll_id);
    
     
    

    $html = " ";

          

       
     $html .= "<div class='widget-box transparent'>";
            $html .= "<div class='widget-header widget-header-flat'>";
                $html .= "<h4 class='widget-title lighter'>";
                    $html .= "<i class='ace-icon fa fa-star orange'></i>";
                        $html .= "Detalle de producción";
                $html .= "</h4>";

                        $html .= "<div class='widget-toolbar'>";
                            $html .= "<a href='#' data-action='collapse'> <i class='ace-icon fa fa-chevron-up'></i> </a>";
                        $html .= "</div>";
            $html .= "</div>";

            $html .="<div class='widget-body'>";
                $html .= "<div class='widget-main no-padding'>";
                    $html .= "<table class='table table-bordered table-striped'>";
                        
                        $html .= "<thead class='thin-border-bottom'>";
                        
                            $html .= "<tr>";
                                $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Còdigo</th>";
                                
                                $html .="<th><i class='ace-icon fa fa-caret-right blue'></i>ID Rollo </th>";
                                
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total Sacos</th>";
                                
                                 $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total ClaseB</th>";
                                 
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Detalle</th>";

                                $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Operario</th>";
                                
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Usuario</th>";
                                 
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Fec. Creación</th>";
                            $html .= "</tr>";
                        $html .= "</thead>";

                        $html .= "<tbody>";

                    if ($listadet) {
                        foreach ($listadet as $lis){
                            
                       
                            $html .="<tr>";
                                $html .="<td>".$lis['prosacodet_id'];
                                       
                                $html .= "</td>";

                                $html .= "<td><b class='blue'>".$lis['proroll_id'];
                                
                                $html .= "</b></td>";
                                
                               
                                
                                $html .="<td>".$lis['prosacodet_total'];
                                       
                                $html .= "</td>";

                                $html .= "<td class='hidden-480'>".$lis['prosacodet_totalb'];
                                   
                                $html .= "</td>";
                                if($procesos == '171'){
                                     $html .= "<td class='hidden-480'> Clase A(".$lis['prosacodet_sacoa'].") - Clase B Bast. (".$lis['prosacodet_sacobast'].")";
                                 
                                }else{
                                     $html .= "<td class='hidden-480'> Clase A(".$lis['prosacodet_sacoa'].") - Clase B Tel. (".$lis['prosacodet_sacotel'].") - Clase B Lam. (".$lis['prosacodet_sacolam'].") - Clase B Imp. (".$lis['prosacodet_sacoimp'].") - Clase B Conv. (".$lis['prosacodet_sacoconv'].")";
                                 
                                }
                                  
                                $html .= "</td>";
                                
                                $html .= "<td class='hidden-480'>".$lis['prosacodet_operario'];
                                   
                                $html .= "</td>";
                                $html .= "<td class='hidden-480'>".$lis['usuario_creacion'];
                                   
                                $html .= "</td>";
                                
                                
                                  $date_fecped = date_create($lis['fecha_creacion']);

                                
                                $html .="<td>".$lis['fecha_creacion'];
                                       
                                $html .= "</td>";
                                
                                   $html .= "<input type='hidden' id = 'proroll_id' value='". $lis ['proroll_id']. "'>";
                            $html .= "</tr>";
                         }
                     } else {
                         $html .="<tr>";
                                $html .="<td colspan = '8'>";
                                       $html .= "no se encontraron registros!!";
                                $html .= "</td>";
                         $html .= "</tr>";
    }        

                        $html .="</tbody>";
                    $html .= "</table>";
                $html .="</div>";
            $html .= "</div>";
	$html .= "</div>";
        
        $html .= "<input type='hidden' id = 'prorollactual' value='". $proroll_id. "'>";
      

    echo $html;
}


function _cargarlistasacosconvAction() {//producción 2019

    $proroll_id = $_GET["cod"];
    
     $procesos= $_GET["procesos"];

    $lista = new kanban();
    $listadet = $lista->listarProduccSacoDet($proroll_id);
    
     
    

    $html = " ";

          

       
     $html .= "<div class='widget-box transparent'>";
            $html .= "<div class='widget-header widget-header-flat'>";
                $html .= "<h4 class='widget-title lighter'>";
                    $html .= "<i class='ace-icon fa fa-star orange'></i>";
                        $html .= "Lista de diseños";
                $html .= "</h4>";

                        $html .= "<div class='widget-toolbar'>";
                            $html .= "<a href='#' data-action='collapse'> <i class='ace-icon fa fa-chevron-up'></i> </a>";
                        $html .= "</div>";
            $html .= "</div>";

            $html .="<div class='widget-body'>";
                $html .= "<div class='widget-main no-padding'>";
                    $html .= "<table class='table table-bordered table-striped'>";
                        
                        $html .= "<thead class='thin-border-bottom'>";
                        
                            $html .= "<tr>";
                                $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Còdigo</th>";
                                
                                $html .="<th><i class='ace-icon fa fa-caret-right blue'></i>ID Rollo </th>";
                                
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total Sacos</th>";
                                
                                 $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total ClaseB</th>";
                                 
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Detalle</th>";

                                $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Operario</th>";
                                
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Usuario</th>";
                                 
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Fec. Creación</th>";
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Enviar</th>";
                            $html .= "</tr>";
                        $html .= "</thead>";

                        $html .= "<tbody>";

                    if ($listadet) {
                        foreach ($listadet as $lis){
                            
                       
                            $html .="<tr>";
                                $html .="<td>".$lis['prosacodet_id'];
                                       
                                $html .= "</td>";

                                $html .= "<td><b class='blue'>".$lis['proroll_id'];
                                
                                $html .= "</b></td>";
                                
                               
                                
                                $html .="<td>".$lis['prosacodet_total'];
                                       
                                $html .= "</td>";

                                $html .= "<td class='hidden-480'>".$lis['prosacodet_totalb'];
                                   
                                $html .= "</td>";
                                if($procesos == '171'){
                                     $html .= "<td class='hidden-480'> Clase A(".$lis['prosacodet_sacoa'].") - Clase B Bast. (".$lis['prosacodet_sacobast'].")";
                                 
                                }else{
                                     $html .= "<td class='hidden-480'> Clase A(".$lis['prosacodet_sacoa'].") - Clase B Tel. (".$lis['prosacodet_sacotel'].") - Clase B Lam. (".$lis['prosacodet_sacolam'].") - Clase B Imp. (".$lis['prosacodet_sacoimp'].") - Clase B Conv. (".$lis['prosacodet_sacoconv'].")";
                                 
                                }
                                  
                                $html .= "</td>";
                                
                                $html .= "<td class='hidden-480'>".$lis['prosacodet_operario'];
                                   
                                $html .= "</td>";
                                $html .= "<td class='hidden-480'>".$lis['usuario_creacion'];
                                   
                                $html .= "</td>";
                                
                                
                                  $date_fecped = date_create($lis['fecha_creacion']);

                                
                                $html .="<td>".$lis['fecha_creacion'];
                                       
                                $html .= "</td>";
                                  $html .= "<td class='hidden-480'>";
                                 $html .="  <label>
                                    <img width='18px' height='18px' style='margin-top: -7px; display: none;'
                                         src='view/img/loading.gif' class='loading-". $lis ['prosacodet_id'];
                                        $html .="' >";
                                        $html .=" <input type='checkbox'";
                                         if ($lis ['estado'] == '1' or $lis ['estado'] == '2'){
                                           $html .="  checked='checked' disabled ";  
                                         }else{
                                             
                                         }
                                         
                                          $html .=" class='ace ace-switch ace-switch-6' id='updateenviar' data-iddetallle=". $lis ['prosacodet_id'];
                                           $html .= "><span class='lbl'></span>
                                   
                                </label>";
                                         
                                $html .= "</td>";
									 $html .= "<input type='hidden' id = 'prosacodet_id-". $lis ['prosacodet_id']."'"." value='". $lis ['prosacodet_id']. "'>";
                                   $html .= "<input type='hidden' id = 'proroll_id' value='". $lis ['proroll_id']. "'>";
                            $html .= "</tr>";
                         }
                     } else {
                         $html .="<tr>";
                                $html .="<td colspan = '8'>";
                                       $html .= "no se encontraron registros!!";
                                $html .= "</td>";
                         $html .= "</tr>";
    }        

                        $html .="</tbody>";
                    $html .= "</table>";
                $html .="</div>";
            $html .= "</div>";
	$html .= "</div>";
        
        $html .= "<input type='hidden' id = 'prorollactual' value='". $proroll_id. "'>";
      

    echo $html;
}


function _progprocesosGuardarSacosAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $id_kanban_det = $filter->process($_POST['id_kanban_det']);
    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']);
    //$fecha_programacion = $filter->process($_POST['fecha_programacion']);
     //*************************FECHA
    $fec = $filter->process($_POST['fecha_programacion']);
      $date_fec = date_create($fec);
$fecha_programacion = date_format($date_fec, 'Y-d-m H:i:s');
    
   
    //$fecha_programacion = $filter->process($_POST['fecha_programacion']);
    //******************************
    
    
    $procesos = $filter->process($_POST['procesos']);
    
    $estado = $filter->process($_POST['estado']);
    $accion = $filter->process($_POST['accion']);
           

    $usuario_nickname = $filter->process($_SESSION['usuario']);
    
    $codart = $filter->process($_POST['codart']);
 
    $artsemi_id = $filter->process($_POST['artsemi_id']);

    $kanban = new kanban();
    $a=0;$b= 0; $siguiente_proceso=0;
    if ($accion == "agregar") {
        $buscarSiguienProceso=$kanban->ListaProcesoXarticulo($artsemi_id, $id_kanban_det);
        if($buscarSiguienProceso){
            foreach ($buscarSiguienProceso as $list) {
                $a++;
                $lista_arreglo [$a] = $list['valitemcarac_valor'];
                if ($list['valitemcarac_valor'] == $procesos) {
                    $b = $a;
                }
            }


            for ($index = 1; $index <= count($lista_arreglo); $index++) {
                if ($index == ($b + 1)) {
                    $siguiente_proceso = $lista_arreglo[$index];
                }
            }
        }
       
       

        $status=$kanban->insertarProgProcesos($procesos,$id_kanban_det, $id_kanban_det,  $fecha_programacion,$usuario_nickname,$siguiente_proceso);

        $response["status"] = $status;
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una programación, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }


    $ops = new kanban();
    $listaprocesos = $ops->consultarProceso($ini, $fin,$procesos,$estado);


    require_once 'view/tablas/ajax-progprocesossacos.php';
}

function _ajaxFormRegisProduccSacosBasAction() {
    
    $are_id = '8';

    $proroll_id =  $_POST['proroll_id'];
    
    $ini = $_POST['ini'];
    $fin = $_POST['fin']; 
    $procesos = $_POST['procesos'];
    $estado = $_POST['estado'];
    
    
     $claseb_ant = $_POST['claseb_ant'];
    
     
 $emp = new kanban();
  $listaemp = $emp->consultarEmp();
  $listProductos = $emp->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);
  $maquinas = $emp->listarMaqBastilladoras($are_id);

    require_once 'view/vistahtml/mostrarregistroproduccsacosbas-form.php';
}


function _insertarProduccSacoBastAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $proroll_id = $filter->process($_POST['proroll_id']);
    $emp = $filter->process($_POST['emp']);
     $obs = $filter->process($_POST['obs']);
    
    $clasea = $filter->process($_POST['clasea']);
    
    $maquina = $filter->process($_POST['maquina']);
    $claseb_bast = $filter->process($_POST['claseb_bast']);
    $claseb_ant = $filter->process($_POST['claseb_ant']);
  

    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);

    $sacos_total = $clasea +$claseb_bast;
    $sacos_totalb =$claseb_bast;
    
    $usuario_nickname = $filter->process($_SESSION['usuario']);

    $kanban = new kanban();
    $totales = '0';
    $totalesb= '0';
    if ($clasea != "" ) {

        $status=$kanban->insertarProduccSacoParcialBast(
                $proroll_id,$clasea,$maquina,$claseb_bast,$sacos_total,$sacos_totalb,$emp,$obs, $usuario_nickname);
        
        $sumaProduccion= $kanban->sumaacumuladaSacos($proroll_id);
        if($sumaProduccion){
            foreach ($sumaProduccion as $lista){
               $totales = $totales + $lista ['prosacodet_total'];
               $totalesb = $totalesb + $lista ['prosacodet_sacobast'];
            }
        }
        $nuevo_claseb = $claseb_ant + $totalesb;
         $nuevo_totales = $claseb_ant + $totales;
        $status=$kanban->UpdateTotalAvance($proroll_id,$nuevo_totales,$nuevo_claseb);
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('Ingresar valores validos', function(){}); 
                </script>";
    }


    
    $are_id = '8';
 $kanban= new kanban();
  $listaemp = $kanban->consultarEmp();
  $listProductos = $kanban->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);
$maquinas = $kanban->listarMaqBastilladoras($are_id);

  
    require_once 'view/vistahtml/mostrarregistroproduccsacosbas-form.php';
}

function _GenerFilAction() {
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesosBast();
  require_once 'view/listaregistroproducprensa-registro.php';
}

function _cerrarProduccGenFilAction() { //producción 2019
    $response = array();
    $filter = new InputFilter();
 $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
    $progprodet_id = $filter->process($_POST['progprodet_id']);
    
     $totala = $filter->process($_POST['totala']);
     $totalb = $filter->process($_POST['totalb']);
     $nroped = $filter->process($_POST['nroped']);
      $cantenfardado = $filter->process($_POST['cantenfardado']);
    
    $kandet_id = $filter->process($_POST['kandet_id']);

    $usuario_nickname = $filter->process( $_SESSION['usuario']);

    $proroll_id = $filter->process($_POST['proroll_id']);
    $accion = $filter->process($_POST['accion']);

ini_set('date.timezone','America/Lima'); 
    $hora_actual = date("H:i:s");                         // 17:16:18
 $fecha_actual= date("Y-m-d");  
    
    $kanban = new kanban();
    if ($accion == "agregar") {

        $status=$kanban->CerraProduccSac($proroll_id, $usuario_nickname, $totala,$totalb ); //UPDATE
        
        $status=$kanban->UpdateProgDetProceso($progprodet_id, $fecha_actual,$hora_actual,$usuario_nickname);

        $status=$kanban->UpdateCerraDisponibilidadTelar($kandet_id);
        $status=$kanban->UpdateProgProcesosAtendido($kandet_id);
        //Generacion de Filas UpdateFilasGenerados
     //generacion de filas para prensa
      $cabecerakanban = $kanban->cabecerakanbanXmaqSaco( $nroped );

 if( $cabecerakanban){
		   foreach( $cabecerakanban as $listacab){

			 $kanban = new kanban();
			      $cuerpokanban = $kanban->cuerpokanban( $listacab['artsemi_id']);
			

				$cuerpo =[];

				if( $cuerpokanban){
								foreach( $cuerpokanban as $listacue){
								$cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
								}

				}

	}
				
				
}

if($cuerpo['15']=='ARPILLERA TEJIDO' and $cuerpo['19'] == 'ARPILLERA'){
	 $status=$kanban-> GuardarRegisArpille($nroped,$kandet_id,$totala, $totalb,$cantenfardado,$proroll_id,$usuario_nickname);
	
}else if ($cuerpo['15']=='MANTA TEJIDO' and $cuerpo['19'] == 'MANTA'){
	  $status=$kanban-> GuardarRegis($nroped,$kandet_id,$totala, $totalb,$cantenfardado,$proroll_id,$usuario_nickname);


}else{
	  $status=$kanban-> GuardarRegis($nroped,$kandet_id,$totala, $totalb,$cantenfardado,$proroll_id,$usuario_nickname);

}
     
     
     
     
     
     
       // $status=$kanban-> GuardarRegis($nroped,$kandet_id,$totala, $totalb,$cantenfardado,$proroll_id,$usuario_nickname);
     // fin de generacion de filas para prensa
  
     
     
            $status=$kanban->UpdateFilasGenerados($proroll_id ); //UPDATE
        // FIN DE generacion de filas
        $response["status"] = $status;
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una aprobación, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }

$maquina= '-1';
$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarAvanceProduccRollo($ini,$fin,$procesos,$estado,$maquina);

    require_once 'view/tablas/ajax-gererarregistros.php';
}
function _ajaxFormMostrarFilasAction() {
    
   

    $proroll_id =  $_POST['proroll_id'];
    
    
     
 $emp = new kanban();

  $lista_filas = $emp->listarFilasGeneradas($proroll_id);

    require_once 'view/vistahtml/mostrarregistrogenprensa-form.php';
}
function _FormRegisPrensaAction() {//producción 2019 ajaxGetDatGen
    
    $opedido = new kanban();

  $ops = $opedido->listarOps();
    require_once 'view/prensaproduccion-form.php';
}

function _ajaxGetDatGenAction() {//producción 2019 
     $filter = new InputFilter();
 $op = $filter->process($_POST['op']);
    $detop = new kanban();

  $detalle = $detop->ajaxGetDatGen($op);
    require_once 'view/vistahtml/mostrar-contenido-articulo-form.php';
}

function _ajaxGetResuAction() {//producción 2019 
     $filter = new InputFilter();
 $op = $filter->process($_POST['op']);
    $detop = new kanban();

  $resumen = $detop->ajaxGetResumen($op);
    require_once 'view/vistahtml/mostrar-contenido-resumen-form.php';
}

function _ajaxGetPuchosAction() {//producción 2019 
     $filter = new InputFilter();
 $op = $filter->process($_POST['op']);
    $detop = new kanban();

  $pucho = $detop->ajaxGetPuchosActivos($op);
    require_once 'view/vistahtml/mostrar-contenido-puchoactivo-form.php';
}

function _ajaxGetTotalAction() {//producción 2019 
     $filter = new InputFilter();
 $op = $filter->process($_POST['op']);
    $detop = new kanban();

  $total = $detop->ajaxGetEnfardadoTotal($op);
    require_once 'view/vistahtml/mostrar-contenido-total-form.php';
}

function _ajaxGetAgruparPuchosAction() {//producción 2019 
     $filter = new InputFilter();
 $op = $filter->process($_POST['op']);
      $tipo = $filter->process($_POST['tipo']);
    $detop = new kanban();

  $pucho = $detop->ajaxGetPuchosActivosXtipo($op,$tipo);
    require_once 'view/vistahtml/mostrar-contenido-agruppuchoactivo-form.php';
}
function _ajaxGetActualizarTablasEnfarAction(){
	   $response = array();
	
    $filter = new InputFilter();
 $suma = round($filter->process($_POST['suma']),2);
    $op = $filter->process($_POST['op']); 
    $tipo = $filter->process($_POST['tipo']);
    $kanban = $filter->process($_POST['kanban']);
    
$usuario_nickname = $filter->process( $_SESSION['usuario']);

   $valorfila =  json_decode($filter->process($_POST['valorfila'])); 
 $idfila =  json_decode ($filter->process($_POST['idfila']));
 




    $kanban = new kanban();
   
 $kanban_agrupados= '';   
 if($suma != '0'){
     
 
  // actualizando  los puchos agrupados  
for ($i = 0; $i <  count($valorfila) ; $i++){//array_search("precio1",array_keys($array));
	for ($j = 0; $j < count($idfila); $j++){
		if (array_search($i,array_keys($valorfila))==array_search($j,array_keys($idfila))){
			$lista_idfila = $kanban->listafila($idfila[$j]);
			foreach	($lista_idfila as $lista){
				$valor_actual = $lista['prefila_cantidad_fin'] - $valorfila[$i];
								if($valorfila[$i] > '0'){
									  $kanban_agrupados= $lista['prefila_kanban'].' / '.$kanban_agrupados;
								}
                              
				if($valor_actual == '0'){
                                    $kanban->UpdatefilasAgruparTotal($idfila[$j],$usuario_nickname,$valor_actual);
                                }  else {
                                    $kanban->UpdatefilasAgruparParcial($idfila[$j],$usuario_nickname,$valor_actual);
                                }
			}
			
		}
	}
	
}

 $status = $kanban->insertarRegistroFardosAgrupados('0',$op,'Manual', $suma,$suma,$tipo,$kanban_agrupados,$usuario_nickname,$usuario_nickname,'Total');
 
 
 }
    
  //   $status = $kanban->InsertPROFECHADISPMAQUINA($maq_id, $nuevaFecha_produccion);codart
    $response["status"] = $status;
    
	
   header('Content-Type: application/json');



    echo json_encode($response);
}

function _ajaxGetActualizarTablasEnfarRegProducAction(){
	   $response = array();
	
    $filter = new InputFilter();
 
    $prefila_id = $filter->process($_POST['prefila_id']); 
    $peso = $filter->process($_POST['peso']);
     $tipo = $filter->process($_POST['tipo']);
      $codart = $filter->process($_POST['codart']);
    $accion = $filter->process($_POST['accion']);
   
$usuario_nickname = $filter->process( $_SESSION['usuario']);

  $cod_claseb='';


    $kanban = new kanban();
    
   $claseB = $kanban-> conultarClaseB($codart,$tipo);
   if($claseB){
	   foreach($claseB as $listaclab){
			$cod_claseb = $listaclab['codigofin'];
	   
	   }
	   
   }else{
	   $cod_claseb =  $codart;
   }
   
   
   
 $kanban_agrupados= ''; 
 
 if($accion == 'agregar'){
      if ($peso != '0') {

            $status = $kanban->UpdatefilasRegisProducc($prefila_id, $peso, $usuario_nickname,$cod_claseb );
        }
    }  else {
         echo "<script type='text/javascript'> 
             
               bootbox.alert('No puede actualizar este registro, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }


    
	
   header('Content-Type: application/json');



    echo json_encode($response);
}

function _ajaxveretiquetaIFrameAction() {//producción 2019
    $id = $_POST['id'];
    //$datos_etiqueta = new kanban();
    //$datos =$datos_etiqueta->consultarDatosEtiqueta($id);
   
   

    require_once 'view/vistahtml/veretiqueta-form.php';
}

function _ajaxveretiquetaAction() {//producción 2019
    $id = $_GET['id'];
    $datos_etiqueta = new kanban();
    $datos =$datos_etiqueta->consultarDatosEtiqueta($id);
    
    $turnos = $datos_etiqueta->consultarTurno();
   
   

   require_once 'view/reportes/reporte-etiqueta.php';
}

function _listKanbManualAction() {//producción 2019
     $kanban = new kanban();
    $kanban_manual =$kanban->consultarKanbanManual();
    
    $listarkanban = $kanban->ConsultarKanban();
   
    require_once 'view/kanbanmanual-registro.php';
}


function _insertarkanbmanualAction() { //producción 2019
    
    $filter = new InputFilter();
 
   
    $prodped_usr = $filter->process($_SESSION['idusuario']);
    $usuario_nickname =$filter->process( $_SESSION['usuario']);

    $opedido = $filter->process($_POST['opedido']); 
     $artsemi_id = $filter->process($_POST['artsemi_id']); 
    
    $cantkanban = $filter->process($_POST['cantkanban']); 
    $mtrslineales = $filter->process($_POST['mtrslineales']); 
       
   

    $kanban = new kanban();
  
    $tipo = $kanban->ConsultarArtsemiTipo($artsemi_id);
    if( $tipo){
		foreach($tipo as $list){
			if($list['tipsem_id'] == '2'){
				$tipo_descr = 'saco';
				$codTipo = '2';
			}elseif($list['tipsem_id'] == '8'){
				$tipo_descr = 'parche';
				$codTipo = '8';
			}
		}
		
		
	}
    
    
    if ($cantkanban >0 && $mtrslineales >0 && $opedido != -1) {
		for ($i = 1; $i <= $cantkanban; $i++){
			 $ultimoKanban = $kanban->ConsultarUltimoKanb($opedido);
			 
				if($ultimoKanban){
				
					foreach ($ultimoKanban  as $lista){
						// insertar kanban detalle
						$nuevo_items = $lista['prokandet_items'] + 1;
						if($codTipo == '2'){
							$kanban->InsertKanbanManual($opedido,$nuevo_items,$mtrslineales,$usuario_nickname,$artsemi_id,$tipo_descr);
						}elseif($codTipo == '8'){
							$kanban->InsertKanbanManual($opedido,$nuevo_items,$mtrslineales,$usuario_nickname,$artsemi_id,$tipo_descr);
							$kanban->InsertKanbanManual($opedido,$nuevo_items,$mtrslineales,$usuario_nickname,$artsemi_id,$tipo_descr);
						}
					//	$kanban->InsertKanbanManual($opedido,$nuevo_items,$mtrslineales,$usuario_nickname,$artsemi_id,$tipo_descr);
						// fin kanban detalle
						
						
						// update kanban 
						$nuevo_prokan_cantkanban = $lista['prokan_cantkanban'] +1;
						$nuevo_prokan_mtrs_totales = $lista['prokan_mtrs_totales'] + $mtrslineales;
						$nuevo_prokan_kanb_manual = $lista['prokan_kanb_manual'] +1;
						$kanban->UpdateTblkanban($opedido,$nuevo_prokan_cantkanban,$nuevo_prokan_mtrs_totales,$nuevo_prokan_kanb_manual);
						// fin kanban 
						
					}
				}
			
			
		}
		
       
    } else {

              
              echo "<script type='text/javascript'> 
             
               alert('... debe ingresar valores validos!!')  ; 
              window.location = 'index.php?page=kanban&accion=listKanbManual';
                </script>";
                
    }


 $kanban_manual =$kanban->consultarKanbanManual();
    
    $listarkanban = $kanban->ConsultarKanban();
    require_once 'view/kanbanmanual-registro.php';
}

function _transfKanbAction() {//producción 2019
     $kanban = new kanban();
    $kanban_transf =$kanban->ConsultarTrandferenciaKanb();
    
     $listarkanban = $kanban->ConsultarKanban();
    //$listarkanbandet = $kanban->ConsultarKanbanDet();
   
    require_once 'view/transfkanban-registro.php';
}

function _ajaxGetKanbanAction() {

    $opedidoorig = $_POST['opedidoorig'];

   $kanban = new kanban();

    $lista_kanban = $kanban->ConsultarKanbanDet($opedidoorig);
    //console.log ("entro");

     if (count($lista_kanban)): ?>
      
        <?php foreach ($lista_kanban as $list): ?>
            <option value="<?php echo $list ['prokandet_id'] ;?>" >
            <?php echo $list ['prokandet_id'].'( '. $list ['prokandet_tipo'].')'; ?>
            </option>
        <?php endforeach; ?>
     <?php else : ?>
        <?php echo '<option value=-1> No existen registros </option>'; ?>
    <?php endif; ?>
        
        <?php
}

function _insertarTransferAction() { //producción 2019
    
    $filter = new InputFilter();
 
   
    $prodped_usr = $filter->process($_SESSION['idusuario']);
    $usuario_nickname =$filter->process( $_SESSION['usuario']);

    $opedidoorig = $filter->process($_POST['opedidoorig']); 
    
    $kanban_id = $filter->process($_POST['kanban_id']); 
    $opedidodest = $filter->process($_POST['opedidodest']);
    $artsemi_id = $filter->process($_POST['artsemi_id']);  
       
   

    $kanban = new kanban();
    

    
    
    if ($opedidoorig != $opedidodest  && $kanban_id != -1) {
		
			$kanban->InsertTransfkanb($opedidoorig,$kanban_id,$opedidodest,$usuario_nickname);
			
			$kanban->UpdateTblkanbanPedido($opedidodest,$kanban_id,$artsemi_id);
		
		
    } else {

              
              echo "<script type='text/javascript'> 
             
               alert('... debe ingresar valores validos!!')  ; 
              window.location = 'index.php?page=kanban&accion=transfKanb';
                </script>";
                
    }


    $kanban_transf =$kanban->ConsultarTrandferenciaKanb();
    
     $listarkanban = $kanban->ConsultarKanban();
    require_once 'view/transfkanban-registro.php';
}

function _ajaxFormRegisProduccMiniRollAction() {
    
    

    $proroll_id =  $_POST['proroll_id'];
    
    $ini = $_POST['ini'];
    $fin = $_POST['fin']; 
    $procesos = $_POST['procesos'];
    $estado = $_POST['estado'];
         $items = $_POST['items'];
    $opedido = $_POST['opedido']; 
     
 $emp = new kanban();
  $listaemp = $emp->consultarEmp();
  $listProductos = $emp->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);

    require_once 'view/vistahtml/mostrarregistroproduccminiroll-form.php';
}

function _cargarlistaminirollAction() {//producción 2019

    $proroll_id = $_GET["cod"];
    
     $procesos= $_GET["procesos"];

    $lista = new kanban();
    $listadet = $lista->listarProduccMiniRoll($proroll_id);
    
     
    

    $html = " ";

          

       
     $html .= "<div class='widget-box transparent'>";
            $html .= "<div class='widget-header widget-header-flat'>";
                $html .= "<h4 class='widget-title lighter'>";
                    $html .= "<i class='ace-icon fa fa-star orange'></i>";
                        $html .= "Lista de diseños";
                $html .= "</h4>";

                        $html .= "<div class='widget-toolbar'>";
                            $html .= "<a href='#' data-action='collapse'> <i class='ace-icon fa fa-chevron-up'></i> </a>";
                        $html .= "</div>";
            $html .= "</div>";

            $html .="<div class='widget-body'>";
                $html .= "<div class='widget-main no-padding'>";
                    $html .= "<table class='table table-bordered table-striped'>";
                        
                        $html .= "<thead class='thin-border-bottom'>";
                        
                            $html .= "<tr>";
                                $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Còdigo</th>";
                                
                                $html .="<th><i class='ace-icon fa fa-caret-right blue'></i>ID Rollo </th>";
                                
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total mtrs</th>";
                                
                                 $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Total mtrs B</th>";
                                 
                                   $html .= "<th><i class='ace-icon fa fa-caret-right blue'></i>Detalle</th>";

                                $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Operario</th>";
                                
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Usuario</th>";
                                 
                                 $html .="<th class='hidden-480'><i class='ace-icon fa fa-caret-right blue'></i>Fec. Creación</th>";
                            $html .= "</tr>";
                        $html .= "</thead>";

                        $html .= "<tbody>";

                    if ($listadet) {
                        foreach ($listadet as $lis){
                            
                       
                            $html .="<tr>";
                                $html .="<td>".$lis['prorollparch_id'];
                                       
                                $html .= "</td>";

                                $html .= "<td><b class='blue'>".$lis['proroll_id'];
                                
                                $html .= "</b></td>";
                                
                               
                                
                                $html .="<td>".$lis['prorollparch_mtrstotal'];
                                       
                                $html .= "</td>";

                                $html .= "<td class='hidden-480'>".$lis['prorollparch_mtrstotalb'];
                                   
                                $html .= "</td>";
                                if($procesos == '171'){
                                     $html .= "<td class='hidden-480'> Clase A(".$lis['prosacodet_sacoa'].") - Clase B Bast. (".$lis['prosacodet_sacobast'].")";
                                 
                                }else{
                                     $html .= "<td class='hidden-480'> Rollo A(".$lis['prorollparch_a'].") - Rollo B (".$lis['prorollparch_b'].") - Mtros. Cort. (".$lis['prorollparch_mtrscort'].")";
                                 
                                }
                                  
                                $html .= "</td>";
                                
                                $html .= "<td class='hidden-480'>".$lis['prorollparch_operario'];
                                   
                                $html .= "</td>";
                                $html .= "<td class='hidden-480'>".$lis['usuario_creacion'];
                                   
                                $html .= "</td>";
                                
                                
                                  $date_fecped = date_create($lis['fecha_creacion']);

                                
                                $html .="<td>".$lis['fecha_creacion'];
                                       
                                $html .= "</td>";
                                
                                   $html .= "<input type='hidden' id = 'proroll_id' value='". $lis ['proroll_id']. "'>";
                            $html .= "</tr>";
                         }
                     } else {
                         $html .="<tr>";
                                $html .="<td colspan = '8'>";
                                       $html .= "no se encontraron registros!!";
                                $html .= "</td>";
                         $html .= "</tr>";
    }        

                        $html .="</tbody>";
                    $html .= "</table>";
                $html .="</div>";
            $html .= "</div>";
	$html .= "</div>";
        
        $html .= "<input type='hidden' id = 'prorollactual' value='". $proroll_id. "'>";
      

    echo $html;
}


function _insertarProduccMiniRollAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $proroll_id = $filter->process($_POST['proroll_id']);
       $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
    
    $emp = $filter->process($_POST['emp']);
    
       $mtrscort = $filter->process($_POST['mtrscort']);
    $cantroll_a = $filter->process($_POST['cantroll_a']);
    $cantroll_b = $filter->process($_POST['cantroll_b']);
     $obs = $filter->process($_POST['obs']);
    
 
   

    $mtrstotal = ($cantroll_a + $cantroll_b)*$mtrscort;
    $mtrstotalb =($cantroll_b)*$mtrscort;
    
    $usuario_nickname = $filter->process($_SESSION['usuario']);


    $kanban = new kanban();
    $totales = '0';
    $totalesb= '0';
    if ( $mtrscort  != "" ) {

        $status=$kanban->insertarProduccMiniRoll(
               $proroll_id,
         $cantroll_a,
        $cantroll_b ,
        $mtrscort,
        $mtrstotal,
		 $mtrstotalb,
		$emp,
		$obs,
		
		$usuario_nickname);
        
        $sumaProduccion= $kanban->sumaacumuladaMtrsRollo($proroll_id);
        if($sumaProduccion){
            foreach ($sumaProduccion as $lista){
               $totales = $totales + $lista ['prorollparch_mtrstotal'];
               $totalesb = $totalesb + $lista ['prorollparch_mtrstotalb'];
            }
        }
        
        $status=$kanban->UpdateTotalAvance($proroll_id,$totales,$totalesb);
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('Ingresar valores validos', function(){}); 
                </script>";
    }


 $kanban= new kanban();
  $listaemp = $kanban->consultarEmp();
  $listProductos = $kanban->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);


  
    require_once 'view/vistahtml/mostrarregistroproduccminiroll-form.php';
}

function _mostrarkanbanAction() {
    $filter = new InputFilter();

$cuerpo =[];
$cabecera=[];  

$cintatrama =[];
$cintaurdimbre =[];

  

   $idkanban = $filter->process($_GET['idkanban']);
   $semi_id = $filter->process($_GET['semi_id']);
   
     $kanban = new kanban();
     
       $cabecerakanban = $kanban->cabecerakanban($idkanban);
       $cuerpokanban = $kanban->cuerpokanban( $semi_id);

       
     
  
  if( $cuerpokanban){
		   foreach( $cuerpokanban as $listacue){
			    $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
		   }
}
	   
$codTrama =  $cuerpo['13'];
$codUrdim =  $cuerpo['14'];   

 $infoTrama = $kanban->caraccintas( $codTrama);
 $infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
  if(  $infoTrama){
		   foreach(  $infoTrama as $listatra){
			    $cintatrama[$listatra['itemcaracsemi_id']] = $listatra['valor'];
		   }
}


 if(  $infoUrdimbre){
		   foreach(  $infoUrdimbre as $listaurd){
			    $cintaurdimbre[$listaurd['itemcaracsemi_id']] = $listaurd['valor'];
		   }
}

 
   
   require_once 'view/reportes/reporte-kamban.php';
}

function _progprocesosTelAction() {//producción 2019
    $proceso_id = '167';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}

function _progprocesosLamAction() {//producción 2019
    $proceso_id = '168';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}

function _progprocesosImpAction() {//producción 2019
    $proceso_id = '169';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}

function _progprocesosConvAction() {//producción 2019
    $proceso_id = '170';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}

function _progprocesosBastAction() {//producción 2019
    $proceso_id = '171';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}

function _progprocesosPrenAction() {//producción 2019
    $proceso_id = '172';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}

function _progprocesosCortAction() {//producción 2019
    $proceso_id = '173';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesos-registro.php';
}

function _progProcSacBastAction() {//producción 2019
     $proceso_id = '171';
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesossacos-registro.php';
}

function _progProcSacPrenAction() {//producción 2019
    $proceso_id = '172';
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    require_once 'view/progprocesossacos-registro.php';
}



function _ajaxGetArtsemiAction() {

    $opedido = $_POST['opedido'];

   $kanban = new kanban();

    $lista_kanban = $kanban->ConsultarArtsemiXop($opedido);
    //console.log ("entro");

     if (count($lista_kanban)): ?>
      
        <?php foreach ($lista_kanban as $list): ?>
            <option value="<?php echo $list ['artsemi_id'] ;?>" >
            <?php echo $list ['artsemi_descripcion']; ?>
            </option>
        <?php endforeach; ?>
     <?php else : ?>
        <?php echo '<option value=-1> No existen registros </option>'; ?>
    <?php endif; ?>
        
        <?php
}



// *********************************************[ inicio de atencion de procesos]*********************************************************************************
//***********************************************[ inicio de atencion de procesos]********************************************************************************
function _inicprocesoTelAction() {//producción 2019  ConsultarMaqXarea
    $proceso_id = '167';
    $area_id = '4';
    
    
   $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  
    $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/inicprocesos-registro.php';
}

function _inicprocesoLamAction() {//producción 2019

    
    $proceso_id = '168';
     $area_id = '5';
    
   $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
   $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/inicprocesos-registro.php';
}

function _inicprocesoImpAction() {//producción 2019
    $proceso_id = '169';
     $area_id = '6';
    
 $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
   $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/inicprocesos-registro.php';
}

function _inicprocesoConvAction() {//producción 2019
    $proceso_id = '170';
     $area_id = '7';
    
 $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
   $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/inicprocesos-registro.php';
}

function _inicprocesoBastAction() {//producción 2019
    $proceso_id = '171';
    
    
 $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/inicprocesos-registro.php';
}

function _inicprocesoPrenAction() {//producción 2019
    $proceso_id = '172';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/inicprocesos-registro.php';
}

function _inicprocesoCortAction() {//producción 2019
    $proceso_id = '173';
    
    
 $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/inicprocesos-registro.php';
}

// *********************************************[ fin  de atencion de procesos]*********************************************************************************
//***********************************************[ fin de inicio de atencion de procesos]********************************************************************************




// *********************************************[ Produccion de procesos]*********************************************************************************
//***********************************************[ Produccion de procesos]********************************************************************************
function _producrolloTelAction() {//producción 2019
    $proceso_id = '167';
     $area_id = '4';
    
    
   $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/listaregistroproduc-registro.php';
}

function _producrolloLamAction() {//producción 2019

    
    $proceso_id = '168';
    $area_id = '5';
    $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/listaregistroproduc-registro.php';
}

function _producrolloImpAction() {//producción 2019
    $proceso_id = '169';
     $area_id = '6';
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/listaregistroproduc-registro.php';
}

function _producrolloConvAction() {//producción 2019
    $proceso_id = '170';
     $area_id = '7';
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/listaregistroproduc-registro.php';
}

function _producrolloConv2Action() {//producción 2019
    $proceso_id = '170';
     $area_id = '7';
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
    $listamaquinas = $procesos->ConsultarMaqXarea( $area_id);
  require_once 'view/listaregistroproducconver-registro.php';
}

function _producrolloBastAction() {//producción 2019
    $proceso_id = '171';
     $area_id = '8';
    
   $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/listaregistroproduc-registro.php';
}

function _producrolloPrenAction() {//producción 2019
    $proceso_id = '172';
    
    
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/listaregistroproduc-registro.php';
}

function _producrolloCortAction() {//producción 2019
    $proceso_id = '173';
  $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
  require_once 'view/listaregistroproduc-registro.php';
}

// *********************************************[ fin  de Produccion procesos]*********************************************************************************
//***********************************************[ fin de Produccion de procesos]********************************************************************************

function _mostrarkanbanXopAction() {
    $filter = new InputFilter();

$cuerpo =[];
$cabecera=[];  

$cintatrama =[];
$cintaurdimbre =[];
  

   $opedido = $filter->process($_GET['opedido']);
   $semi_id = $filter->process($_GET['semi_id']);
   
     $kanban = new kanban();
     
       $cabecerakanban = $kanban->cabecerakanbanTotal($opedido);
       $cuerpokanban = $kanban->cuerpokanban( $semi_id);
       
     
  
  if( $cuerpokanban){
		   foreach( $cuerpokanban as $listacue){
			    $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
		   }
}
	   
$codTrama =  $cuerpo['13'];
$codUrdim =  $cuerpo['14'];   

 $infoTrama = $kanban->caraccintas( $codTrama);
 $infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
  if(  $infoTrama){
		   foreach(  $infoTrama as $listatra){
			    $cintatrama[$listatra['itemcaracsemi_id']] = $listatra['valor'];
		   }
}


 if(  $infoUrdimbre){
		   foreach(  $infoUrdimbre as $listaurd){
			    $cintaurdimbre[$listaurd['itemcaracsemi_id']] = $listaurd['valor'];
		   }
}
   
   require_once 'view/reportes/reporte-kamban.php';
}


function _mostrarkanbanparcAction() {
    $filter = new InputFilter();

$cuerpo =[];
$cabecera=[];  

$cintatrama =[];
$cintaurdimbre =[];

  

   $idkanban = $filter->process($_GET['idkanban']);
   $semi_id = $filter->process($_GET['semi_id']);
   
     $kanban = new kanban();
     
       $cabecerakanban = $kanban->cabecerakanban($idkanban);
       $cuerpokanban = $kanban->cuerpokanban( $semi_id);

       
     
  
  if( $cuerpokanban){
		   foreach( $cuerpokanban as $listacue){
			    $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
		   }
}
	   
$codTrama =  $cuerpo['85'];
$codUrdim =  $cuerpo['86'];   

 $infoTrama = $kanban->caraccintas( $codTrama);
 $infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
  if(  $infoTrama){
		   foreach(  $infoTrama as $listatra){
			    $cintatrama[$listatra['itemcaracsemi_id']] = $listatra['valor'];
		   }
}


 if(  $infoUrdimbre){
		   foreach(  $infoUrdimbre as $listaurd){
			    $cintaurdimbre[$listaurd['itemcaracsemi_id']] = $listaurd['valor'];
		   }
}

 
   
   require_once 'view/reportes/reporte-kambanparc.php';
}

function _mostrarRotulAction() {
    $filter = new InputFilter();

$cuerpo =[];
$cabecera=[];  

//$cintatrama =[];
//$cintaurdimbre =[];
  

   $opedido = $filter->process($_GET['opedido']);
   $semi_id = $filter->process($_GET['semi_id']);
   
     $kanban = new kanban();
     
       $cabecerakanban = $kanban->cabecerakanbanXmaq($opedido);
      // $cuerpokanban = $kanban->cuerpokanban( $semi_id);
       
     
  
  //if( $cuerpokanban){
		  // foreach( $cuerpokanban as $listacue){
			//    $cuerpo[$listacue['itemcaracsemi_id']] = $listacue['valor'];
		 //  }
//}
	   
//$codTrama =  $cuerpo['13'];
//$codUrdim =  $cuerpo['14'];   

 //$infoTrama = $kanban->caraccintas( $codTrama);
 //$infoUrdimbre = $kanban->caraccintas( $codUrdim );
 
  //if(  $infoTrama){
		 //  foreach(  $infoTrama as $listatra){
			   // $cintatrama[$listatra['itemcaracsemi_id']] = $listatra['valor'];
		 //  }
//}


 //if(  $infoUrdimbre){
		  // foreach(  $infoUrdimbre as $listaurd){
			   // $cintaurdimbre[$listaurd['itemcaracsemi_id']] = $listaurd['valor'];
		  // }
//}
   
   require_once 'view/reportes/reporte-rotulokamban.php';
}

function _enviarprensaAction() { //producción 2019
     $response = array();

    $filter = new InputFilter();

    $proroll_id = $filter->process($_POST['proroll_id']);
    
       $prosacodet_id = $filter->process($_POST['prosacodet_id']);
     $accion = $filter->process($_POST['accion']);
    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
    
      $claseb_ant = $filter->process($_POST['clasebant']);
    
 
       // $disenodatos->obtenerxId($codartactual);
        
    if ($accion == "agregar") {
        $estado = 1;

             
         $updateprensa = new kanban();
        $status = $updateprensa->UpdateEnviarPrensa($prosacodet_id);
         //$status = $disenodatoslista->updateversion($iddetallle,$estado);
    } else {
         echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede retornar una producción ya enviada, comuniquese con el administrador del sistema', function(){}); 
                </script>";
         
       // $status=  "  <script> bootbox.alert('Para poder agregar una observaciòn, debe escribir un mensaje valido', function(){}); </script>";
    }


     $kanban= new kanban();
  $listaemp = $kanban->consultarEmp();
  $listProductos = $kanban->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);


if($procesos == '171'){
	  require_once 'view/vistahtml/mostrarregistroproduccsacosbas-form.php';
}else{
	  require_once 'view/vistahtml/mostrarregistroproduccsacosconvfin-form.php';
}
  
  
}

function _ajaxGetActualizarListRolloConvAction(){
    $filter = new InputFilter();
 $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
      $maquina = $filter->process($_POST['maquina']);
    
    $proroll_id = $filter->process($_POST['proroll_id']);
    

$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarAvanceProduccRollo($ini,$fin,$procesos,$estado,$maquina);
    require_once "view/tablas/ajax-avanceproduccrollosconver.php";
}

function _ajaxGetActualizarListRolloConv2Action(){
    $filter = new InputFilter();
 $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
      $maquina = $filter->process($_POST['maquina']);
    
    $proroll_id = $filter->process($_POST['proroll_id']);
    

$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarAvanceProduccRolloConv2($ini,$fin,$procesos,$estado,$maquina);
    require_once "view/tablas/ajax-avanceproduccrollosconver.php";
}

function _insertarProduccSacoConvfinAction() { //producción 2019
    $response = array();

    $filter = new InputFilter();

    $proroll_id = $filter->process($_POST['proroll_id']);
    $emp = $filter->process($_POST['emp']);
     $obs = $filter->process($_POST['obs']);
    
    $clasea = $filter->process($_POST['clasea']);
    $telares = $filter->process($_POST['telares']);
    $laminado = $filter->process($_POST['laminado']);
    $impresion = $filter->process($_POST['impresion']);
    $conversion = $filter->process($_POST['conversion']);
    

    $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);

    $sacos_total = $clasea +$telares+$laminado+$impresion+$conversion;
    $sacos_totalb =$telares+$laminado+$impresion+$conversion;
    
    $usuario_nickname = $filter->process($_SESSION['usuario']);

    $kanban = new kanban();
    $totales = '0';
    $totalesb= '0';
    if ($clasea != "" ) {

        $status=$kanban->insertarProduccSacoParcial(
                $proroll_id,$clasea,$telares,$laminado,$impresion,$conversion,$sacos_total,$sacos_totalb,$emp,$obs, $usuario_nickname);
        
        $sumaProduccion= $kanban->sumaacumuladaSacos($proroll_id);
        if($sumaProduccion){
            foreach ($sumaProduccion as $lista){
               $totales = $totales + $lista ['prosacodet_total'];
               $totalesb = $totalesb + $lista ['prosacodet_totalb'];
            }
        }
        
        $status=$kanban->UpdateTotalAvance($proroll_id,$totales,$totalesb);
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('Ingresar valores validos', function(){}); 
                </script>";
    }


 $kanban= new kanban();
  $listaemp = $kanban->consultarEmp();
  $listProductos = $kanban->ListAvanceproduccTelaresIDrollo($ini,$fin,$proroll_id);


  
    require_once 'view/vistahtml/mostrarregistroproduccsacosconvfin-form.php';
}
function _cerrarProduccRolloConvAction() { //producción 2019
    $response = array();
    $filter = new InputFilter();
 $ini = $filter->process($_POST['ini']);
    $fin = $filter->process($_POST['fin']); 
    $procesos = $filter->process($_POST['procesos']);
    $estado = $filter->process($_POST['estado']);
    $progprodet_id = $filter->process($_POST['progprodet_id']);
    
    $kandet_id = $filter->process($_POST['kandet_id']);
     $maquina = $filter->process($_POST['maquina']);

    $usuario_nickname = $filter->process( $_SESSION['usuario']);

    $proroll_id = $filter->process($_POST['proroll_id']);
    $accion = $filter->process($_POST['accion']);
    
        $items = $filter->process($_POST['items']);
    $opedido = $filter->process($_POST['opedido']); 

ini_set('date.timezone','America/Lima'); 
    $hora_actual = date("H:i:s");                         // 17:16:18
 $fecha_actual= date("Y-m-d");  
    
    $kanban = new kanban();
    if ($accion == "agregar") {
		
		if(  $procesos == '167'){
			
				  $listaproducc=$kanban->ConsultarProgRollXopXitem($procesos,$opedido,$items);
	    if($listaproducc){
			foreach($listaproducc as $list){
				//****************** registro doble***************** $list['proroll_id']
						   $status=$kanban->CerraProduccRollo($list['proroll_id'], $usuario_nickname); //UPDATE
        
							$status=$kanban->UpdateProgDetProceso($list['progprodet_id'], $fecha_actual,$hora_actual,$usuario_nickname);

							$status=$kanban->UpdateCerraDisponibilidadTelar($list['prokandet_id']);
							$status=$kanban->UpdateProgProcesosAtendido($list['prokandet_id']);		 
				
				//****************** registro doble*****************
			}
		}
			
		}elseif ($procesos == '170'){	
						//consultar si todos estan en uno en el detalle del saco
						 $lista=$kanban->ConsultarpendientesaPrensa($proroll_id);
									if(count ($lista)==0){
											 $status=$kanban->CerraProduccRollo($proroll_id, $usuario_nickname); 
								
											$status=$kanban->UpdateProgDetProceso($progprodet_id, $fecha_actual,$hora_actual,$usuario_nickname);

											$status=$kanban->UpdateCerraDisponibilidadTelar($kandet_id);
											$status=$kanban->UpdateProgProcesosAtendido($kandet_id);
									}else{
										echo "<script type='text/javascript'> 
									 
									   bootbox.alert('No se puede cerrar la atencion, aun se tiene pendiente de envios a prensa', function(){}); 
										</script>";
										$status = false;
										
									}
						
					}else{
						 $status=$kanban->CerraProduccRollo($proroll_id, $usuario_nickname); 
					
					$status=$kanban->UpdateProgDetProceso($progprodet_id, $fecha_actual,$hora_actual,$usuario_nickname);

					$status=$kanban->UpdateCerraDisponibilidadTelar($kandet_id);
					$status=$kanban->UpdateProgProcesosAtendido($kandet_id);
					}

       

        $response["status"] = $status;
    } else {
        echo "<script type='text/javascript'> 
             
               bootbox.alert('No se puede modificar una aprobación, comunicase con el administrador del sistema', function(){}); 
                </script>";
    }


$progprocesos = new kanban();
    $listaprocesos =$progprocesos->consultarAvanceProduccRolloConv2($ini,$fin,$procesos,$estado,$maquina);

    require_once 'view/tablas/ajax-avanceproduccrollosconver.php';
}



?>
