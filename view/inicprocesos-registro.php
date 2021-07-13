<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Panel Principal</title>

        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        
                <link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
      
        
        
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <script src="assets/js/ace-extra.min.js"></script>

        <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
        <style type="text/css">
            #img_logo{
                max-width: 330px;
                margin-left:  -70px;

            }
        </style>
    </head>

    <body class="no-skin">

        <?php
        include 'barrasesion.php';
        ?>

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.loadState('main-container')
                } catch (e) {
                }
            </script>

            <?php
            include 'nav-bar.php'
            ?>

            <div class="main-content">
                <div class="main-content-inner">
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <ul class="breadcrumb">
                            <li>
                                <i class="ace-icon fa fa-home home-icon"></i>
                                <a href="#">Home</a>
                            </li>

                            <li>
                                <a href="#">Administración</a>
                            </li>
                            <li class="active">Iniciar Procesos</li>
                        </ul><!-- /.breadcrumb -->

                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div><!-- /.nav-search -->
                    </div>

                    <div class="page-content">

                        <div class="row-fluid">

                            <div class="widget-box">
                                <div class="widget-header widget-header-blue widget-header-flat">
                                    <h4 class="widget-title lighter">Iniciar Proceso</h4>


                                </div>
         
                                                                          

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div id="fuelux-wizard-container">
                                               
                                                    <div class="row">

                                                        <div class="col-xs-12">

                                                            <label for="id-date-range-picker-1">Rango de Fecha</label>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-calendar bigger-110"></i>
                                                                        </span>
                                                                        <input class="form-control" type="text" name="rango" id="rango" />
                                                                        <input type ="hidden" id="area" value="<?php   echo  $area_id ; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>





                                                        </div>
                                                        
                                                        <div class="col-xs-6">

                                                            <label for="id-date-range-picker-1">Proceso</label>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                  
                                                                      <select name="procesos" id="procesos" class="chosen-select form-control"     >
                                                                   
                                                                      <?php if (count($listaprocesos)): ?>
                                                                            <?php foreach ($listaprocesos as $list): ?>

                                                                                <option value="<?php echo $list ['tabgendet_id'] ;?>" 
                                                                                         
                                                                                    <?php if($list ['tabgendet_id']== $proceso_id ): ?>
                                                                                       enabled ='enabled'
                                                                                       
                                                                                        <?php else: ?>
                                                                                          disabled="disabled"
                                                                                          <?php endif; ?>
                                                                                        
                                                                                        
                                                                                        
                                                                                        
                                                                                        
                                                                                        >
                                                                                            <?php echo $list['tabgendet_nombre']; ?> 

                                                                                </option>

                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                
                                                                    </div>
                                                            </div>





                                                        </div>
                                                        
                                                        <div class="col-xs-6">

                                                            <label for="id-date-range-picker-1">Estado</label>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                  
                                                                      <select name="estado" id="estado" class="chosen-select form-control"     >
                                                                   
                                     
                                                                          <option value="0" >
                                                                                         Iniciado
                                                                                </option>
                                                                                <option value="1" >
                                                                                         Cerrado
                                                                                </option>
                                                                                <option value="2" selected="selected" >
                                                                                         Pendientes
                                                                                </option>
                                                                                
                                                                                <option value="3" >
                                                                                         Todos
                                                                                </option>
                                                                         
                                                                    </select>
                                                                
                                                                    </div>
                                                            </div>





                                                        </div>
                                                     
														  <div class="col-xs-12">

                                                            <label for="id-date-range-picker-1">Máquina</label>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                  
                                                                      <select name="maquina" id="maquina" class="chosen-select form-control"     >
																		<option value="-1">Todos</option>
                                                                      <?php if (count($listamaquinas)): ?>
                                                                            <?php foreach ($listamaquinas as $list): ?>

                                                                                <option value="<?php echo $list ['maq_id'] ;?>" 
  
                                                                                        >
                                                                                            <?php echo $list['maq_nombre']; ?> 

                                                                                </option>

                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                
                                                                    </div>
                                                            </div>





                                                        </div>
                                                        
                                                             <div class="row-fluid">
                            <div id="cargarinicioproceso"></div>
                        </div>




                                                   

                                                </div>

                                            </div>



                                        </div><!-- /.widget-main -->


                                    </div><!-- /.widget-body -->

                              


                            </div>

                        </div><!-- /.page-content -->




                    </div>  
                    <br>   <br>  <br>  <br>  <br>  <br>   <br>  <br>  <br>  <br>
                </div><!-- /.main-content -->


                <!-- <div id="ajax_paradas">    
                                            </div> -->

                <?php
                include 'footer.php'
                ?>

                <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                </a>
            </div><!-- /.main-container -->

            <!-- basic scripts -->

            <!--[if !IE]> -->
            <script src="assets/js/jquery-2.1.4.min.js"></script>

            <!-- <![endif]-->

            <!--[if IE]>
    <script src="assets/js/jquery-1.11.3.min.js"></script>
    <![endif]-->
            <script type="text/javascript">
                if ('ontouchstart' in document.documentElement)
                    document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
            </script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/chosen.jquery.min.js"></script>
            <!-- page specific plugin scripts -->

            <!-- ace scripts -->
            <script src="assets/js/ace-elements.min.js"></script>
            <script src="assets/js/ace.min.js"></script>


            <script src="assets/js/jquery.dataTables.min.js"></script>
            <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
            <script src="assets/js/dataTables.buttons.min.js"></script>
            <script src="assets/js/buttons.flash.min.js"></script>
            <script src="assets/js/buttons.html5.min.js"></script>
            <script src="assets/js/buttons.print.min.js"></script>
            <script src="assets/js/buttons.colVis.min.js"></script>
            <script src="assets/js/dataTables.select.min.js"></script>
            <script src="assets/js/bootbox.js"></script>

            <script src="assets/js/bootstrap-datepicker.min.js"></script>
            <script src="assets/js/bootstrap-timepicker.min.js"></script>
            <script src="assets/js/moment.min.js"></script>
            <script src="assets/js/daterangepicker.min.js"></script>
            <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
            <script src="assets/js/bootstrap-colorpicker.min.js"></script>


            
            
        <script type="text/javascript">  
//maquina
                $(document).ready(function(){
                   $("#rango").change(function () {
                           $("#rango").each(function () {
                            $('#cargarinicioproceso').html('<center><img src="view/img/loadingV02.gif"/></center>');   
                            $.post("view/tablas/ajax-proginicioprocesos.php", {rango:$( "#rango").val(),procesos:$( "#procesos").val(),estado:$( "#estado").val(),maquina:$( "#maquina").val(),area:$( "#area").val()}, function(data){
                            $("#cargarinicioproceso").html(data);
                            
                            });            
                        });
                   });
                });  
        </script>
        
        
           <script type="text/javascript">  

                $(document).ready(function(){
                   $("#procesos").change(function () {
                           $("#procesos").each(function () {
                            $('#cargarinicioproceso').html('<center><img src="view/img/loadingV02.gif"/></center>');   
                            $.post("view/tablas/ajax-proginicioprocesos.php", {rango:$( "#rango").val(),procesos:$( "#procesos").val(),estado:$( "#estado").val(),maquina:$( "#maquina").val(),area:$( "#area").val()}, function(data){
                            $("#cargarinicioproceso").html(data);
                            
                            });            
                        });
                   });
                });  
        </script>
        
           <script type="text/javascript">  

                $(document).ready(function(){
                   $("#estado").change(function () {
                           $("#estado").each(function () {
                            $('#cargarinicioproceso').html('<center><img src="view/img/loadingV02.gif"/></center>');   
                            $.post("view/tablas/ajax-proginicioprocesos.php", {rango:$( "#rango").val(),procesos:$( "#procesos").val(),estado:$( "#estado").val(),maquina:$( "#maquina").val(),area:$( "#area").val()}, function(data){
                            $("#cargarinicioproceso").html(data);
                            
                            });            
                        });
                   });
                });  
        </script>
        
         <script type="text/javascript">  

                $(document).ready(function(){
                   $("#maquina").change(function () {
                           $("#maquina").each(function () {
                            $('#cargarinicioproceso').html('<center><img src="view/img/loadingV02.gif"/></center>');   
                            $.post("view/tablas/ajax-proginicioprocesos.php", {rango:$( "#rango").val(),procesos:$( "#procesos").val(),estado:$( "#estado").val(),maquina:$( "#maquina").val(),area:$( "#area").val()}, function(data){
                            $("#cargarinicioproceso").html(data);
                            
                            });            
                        });
                   });
                });  
        </script>
        
<script src="view/js/adicionales.js"></script>
<script src="view/js/kanban.js"></script>

            <script type="text/javascript">
                //"startDate": "01-10-2019",
                //"endDate": "07-10-2019",
                jQuery(function ($) {
                    $('#rango').daterangepicker({
                        "locale": {
                            "format": "DD-MM-YYYY",
                            "separator": " - ",
                            "applyLabel": "Guardar",
                            "cancelLabel": "Cancelar",
                            "fromLabel": "Desde",
                            "toLabel": "Hasta",
                            "customRangeLabel": "Personalizar",
                            "daysOfWeek": [
                                "Do",
                                "Lu",
                                "Ma",
                                "Mi",
                                "Ju",
                                "Vi",
                                "Sa"
                            ],
                            "monthNames": [
                                "Enero",
                                "Febrero",
                                "Marzo",
                                "Abril",
                                "Mayo",
                                "Junio",
                                "Julio",
                                "Agosto",
                                "Setiembre",
                                "Octubre",
                                "Noviembre",
                                "Diciembre"
                            ],
                            "firstDay": 1
                        },
                        "opens": "center",
                        'autoApply': true
                    });

  
                });
            </script>

    </body>
</html>

