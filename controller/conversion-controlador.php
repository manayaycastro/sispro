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

function _formreportProdConAction() {   //PRODUCCION 2021 
    $procesos = new kanban();
  $listaprocesos = $procesos->ListaProcesos();
	$proceso_id = '170';
    require 'view/reportproces-form.php';
}


?>
