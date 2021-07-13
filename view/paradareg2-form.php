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
          
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <script src="assets/js/ace-extra.min.js"></script>


        <link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
        <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />
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
                                <a href="#">Producción</a>
                            </li>
                            <li class="active">Lista de Máquinas Paradas</li>
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
                                    <h4 class="widget-title lighter">Lista de Máquinas Paradas</h4>


                                </div>
                                <form  class="form-horizontal" role="form" 
                                       action="index.php?page=parada&accion=insertarreg" method="POST">

                                    <div class="modal-body">
                                        <div class="widget-box">
                                            <div class="widget-header widget-header-small">
                                                <h5 class="widget-title lighter">Ingresar DDatos</h5>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">

                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8">

                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Área </label>

                                                                <div class="col-sm-9">

                                                                    <select name="are_id"   id="are_id" class="chosen-select form-control">
                                                                        
                                                                          <option value=-1>Selecione un Área</option><?php if (count($areas)): ?>
                                                                            <?php foreach ($areas as $area): ?>
                                                                                <option value="<?php echo $area ['are_id'] ?>" >
                                                                                    <?php echo $area ['are_titulo']; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Máquina </label>

                                                                <div class="col-sm-9">

                                                                    <select name="maq_id"   id="maq_id" disabled="disabled"  class="form-control">
                                                                      <option value=-1>Selecione un área</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            
                                                                                        <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Área </label>

                                                                <div class="col-sm-9">

                                                                    <select name="area_id"   id="area_id" class="chosen-select form-control">
                                                                        
                                                                          <option value=-1 >Selecione un Área</option>
                                                                          <?php if (count($areas)): ?>
                                                                            <?php foreach ($areas as $area): ?>
                                                                                <option value="<?php echo $area ['are_id'] ?>" >
                                                                                    <?php echo $area ['are_titulo']; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Máquina </label>

                                                                <div class="col-sm-9">

                                                                    <select name="maquina_id"   id="maquina_id" disabled="disabled"  class="form-control">
                                                                      <option value=-1>Selecione un área</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            
                                                            
                                                            
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Parada </label>

                                                                <div class="col-sm-9">

                                                                    <select name="tippar_id" id="tippar_id" class="chosen-select form-control"  >
                                                                           <option value=-1>Selecione un tipo de parada</option>
                                                                        <?php if (count($paradatipos)): ?>

                                                                            <?php foreach ($paradatipos as $paradatipo): ?>
                                                                                <option value="<?php echo $paradatipo ['tippar_id'] ?>" >
                                                                                    <?php echo $paradatipo ['tippar_titulo']; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">  Parada </label>

                                                                <div class="col-sm-9">

                                                                    <select name="par_id" id="par_id" class="form-control" disabled="disabled">
                                                                       <option value=-1>Selecione un tipo</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            

                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Observación  </label>

                                                                <div class="col-sm-9">
                                                                    <input type="text" name="observacion" id="form-field-1-1"  placeholder="Observación" class="form-control"
                                                                           name="parreg_obs"

                                                                           />
                                                                </div>
                                                            </div>


                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Inicio  </label>

                                                                <div class="col-sm-9">

                                                                    <div class="input-group">
                                                                        <input id="date-timepicker1" name ="inicio" type="text" class="form-control" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-clock-o bigger-110"></i>
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Fin  </label>

                                                                <div class="col-sm-9">

                                                                    <div class="input-group">
                                                                        <input id="date-timepicker2"  name ="fin" type="text" class="form-control" />
                                                                        <span class="input-group-addon">
                                                                            <i class="fa fa-clock-o bigger-110"></i>
                                                                        </span>
                                                                    </div>

                                                                </div>
                                                            </div>







                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="space-18"></div>

                                    <div class="modal-footer" >
                                        <a class="btn btn-sm" data-dismiss="modal" href="index.php?page=parada&accion=reglistar">
                                            <i class="ace-icon fa fa-times"></i>
                                            Cancelar
                                        </a>

                                        <button class="btn btn-sm btn-primary"  >
                                            <i class="ace-icon fa fa-check"></i>
                                            Guardar
                                        </button>
                                    </div>


                                </form>

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
            <!--<script src="view/js/produccion.js"></script>-->
             <script src="view/js/parada.js"></script>
<!--            <script src="view/js/adicionales.js"></script>
            <script src="view/js/selectarticulo.js"></script>-->

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


   
 <script src="assets/js/jquery-ui.min.js"></script>
            <script src="assets/js/jquery.ui.touch-punch.min.js"></script>





            <script type="text/javascript">
                           /////////
                           $('#modal-form-submenu input[type=file]').ace_file_input({
                               style: 'well',
                               btn_choose: 'Drop files here or click to choose',
                               btn_change: null,
                               no_icon: 'ace-icon fa fa-cloud-upload',
                               droppable: true,
                               thumbnail: 'large'
                           })

                           //chosen plugin inside a modal will have a zero width because the select element is originally hidden
                           //and its width cannot be determined.
                           //so we set the width after modal is show
                           $('#modal-form-submenu').on('shown.bs.modal', function () {
                               if (!ace.vars['touch']) {
                                   $(this).find('.chosen-container').each(function () {
                                       $(this).find('a:first-child').css('width', '210px');
                                       $(this).find('.chosen-drop').css('width', '210px');
                                       $(this).find('.chosen-search input').css('width', '200px');
                                   });
                               }
                           })




                           if (!ace.vars['touch']) {
                               $('.chosen-select').chosen({allow_single_deselect: true});
                               //resize the chosen on window resize

                               $(window)
                                       .off('resize.chosen')
                                       .on('resize.chosen', function () {
                                           $('.chosen-select').each(function () {
                                               var $this = $(this);
                                               $this.next().css({'width': $this.parent().width()});
                                               
                                           })
                                       }).trigger('resize.chosen');
                               //resize chosen on sidebar collapse/expand
                               $(document).on('settings.ace.chosen', function (e, event_name, event_val) {
                                   if (event_name != 'sidebar_collapsed')
                                       return;
                                   $('.chosen-select').each(function () {
                                       var $this = $(this);
                                       $this.next().css({'width': $this.parent().width()});
                                   })
                               });


                               $('#chosen-multiple-style .btn').on('click', function (e) {
                                   var target = $(this).find('input[type=radio]');
                                   var which = parseInt(target.val());
                                   if (which == 2)
                                       $('#form-field-select-4').addClass('tag-input-style');
                                   else
                                       $('#form-field-select-4').removeClass('tag-input-style');
                               });
                           }



                           $('.date-picker').datepicker({
                               autoclose: true,
                               todayHighlight: true
                           })
                                   //show datepicker when clicking on the icon
                                   .next().on(ace.click_event, function () {
                               $(this).prev().focus();
                           });

                           //or change it into a date range picker
                           $('.input-daterange').datepicker({autoclose: true});


                           //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
                           $('input[name=date-range-picker]').daterangepicker({
                               'applyClass': 'btn-sm btn-success',
                               'cancelClass': 'btn-sm btn-default',
                               locale: {
                                   applyLabel: 'Apply',
                                   cancelLabel: 'Cancel',
                               }
                           })
                                   .prev().on(ace.click_event, function () {
                               $(this).next().focus();
                           });


                           $('#timepicker1').timepicker({
                               minuteStep: 1,
                               showSeconds: true,
                               showMeridian: false,
                               disableFocus: true,
                               icons: {
                                   up: 'fa fa-chevron-up',
                                   down: 'fa fa-chevron-down'
                               }
                           }).on('focus', function () {
                               $('#timepicker1').timepicker('showWidget');
                           }).next().on(ace.click_event, function () {
                               $(this).prev().focus();
                           });




                           if (!ace.vars['old_ie'])
                               $('#date-timepicker1').datetimepicker({
                                   //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
                                   icons: {
                                       time: 'fa fa-clock-o',
                                       date: 'fa fa-calendar',
                                       up: 'fa fa-chevron-up',
                                       down: 'fa fa-chevron-down',
                                       previous: 'fa fa-chevron-left',
                                       next: 'fa fa-chevron-right',
                                       today: 'fa fa-arrows ',
                                       clear: 'fa fa-trash',
                                       close: 'fa fa-times',
                                       format: 'MM/DD/YYYY h:mm:ss'
                                   }
                               }).next().on(ace.click_event, function () {
                                   $(this).prev().focus();
                               });


                           if (!ace.vars['old_ie'])
                               $('#date-timepicker2').datetimepicker({
                                   //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
                                   icons: {
                                       time: 'fa fa-clock-o',
                                       date: 'fa fa-calendar',
                                       up: 'fa fa-chevron-up',
                                       down: 'fa fa-chevron-down',
                                       previous: 'fa fa-chevron-left',
                                       next: 'fa fa-chevron-right',
                                       today: 'fa fa-arrows ',
                                       clear: 'fa fa-trash',
                                       close: 'fa fa-times'
                                   }
                               }).next().on(ace.click_event, function () {
                                   $(this).prev().focus();
                               });


                           $('#colorpicker1').colorpicker();
                           //$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe

                           $('#simple-colorpicker-1').ace_colorpicker();
                           //$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
                           //$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
                           //var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
                           //picker.pick('red', true);//insert the color if it doesn't exist


                          

            </script>



         

    </body>
</html>

