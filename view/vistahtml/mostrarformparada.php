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
  <link rel="stylesheet" href="view/css/personalizado.css" />



<style> 
 
    .datepicker { 
 
     z-index: 1600 !important; /* has to be larger than 1050 */ 
 
    } 
 
</style> 





                           
   <form  class="form-horizontal" role="form" action="index.php?page=parada&accion=insertarreg2" method="POST"
                                       action="" method="POST">

                <div class="widget-box">
                        <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                        <i class="ace-icon fa fa-comment blue"></i>
                                       Formulario Paradas
                                </h4>
                         
<!--                            <div class="widget-toolbar hidden-480">
                           Click para  Imprimir toda la orden <?php // echo $op; ?>
                           <a class="btn btn-app btn-light btn-xs">
                               <i class="ace-icon fa fa-print bigger-160"></i>
                               Print
                           </a>-->
                           
<!--                           <a href="#"> glyphicon-signal
                                    <i class="ace-icon fa fa-print"></i>
                                </a>-->
                            </div>

                      
             
                        <div class="widget-body">
                                <div class="widget-main no-padding">
                                       

								    <div class="widget-body">
                                                <div class="widget-main">
													
							
													

                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8">

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

                                                                    <select name="tippar_id" id="tippar_id" class="chosen-select form-control" data-placeholder="Choose a State..." >
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
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Detalle  </label>

                                                                <div class="col-sm-9">
<!--                                                                    <input type="text" name="observacion" id="form-field-1-1"  placeholder="Observación" class="form-control"
                                                                           
                                                                           name="parreg_obs"

                                                                           />-->
                                                                    
                                                                    <textarea id="observacion" name="observacion" class="autosize-transition form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                              <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Fecha Inicio  </label>

                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                    <input class="form-control date-picker" name="id-date-picker-1" 
                                                                           id="id-date-picker-1" value="<?php echo   date("Y-m-d") ?>" 
                                                                           min="<?php echo   date("Y-m-d") ?>" type="date" data-date-format="dd-mm-yyyy" />
                                                                  
                                                                    
                                                                    
                                                                </div>
                                                                </div>
                                                                
                                                                
                                                             <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Hora Inicio  </label>

                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                   <div class="input-group bootstrap-timepicker">
                                                            <input id="timepicker1" name="timepicker1" type="text" class="form-control" />
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-clock-o bigger-110"></i>
                                                            </span>
                                                        </div>
                                                                    </span>
                                                                </div>
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                            
                                                            
                                                              <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Fecha fin  </label>

                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                    <input class="form-control date-picker" name="id-date-picker-2" 
                                                                           id="id-date-picker-2" value="<?php echo   date("Y-m-d") ?>" 
                                                                           min="<?php echo   date("Y-m-d") ?>" type="date" data-date-format="dd-mm-yyyy" />
                                                                  
                                                                     
                                                                    
                                                                </div>
                                                                    
                                                                
                                                                </div>
                                                                
                                                                
                                                             <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Hora fin  </label>

                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                   <div class="input-group bootstrap-timepicker">
                                                            <input id="timepicker2" name="timepicker2" type="text" class="form-control" />
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-clock-o bigger-110"></i>
                                                            </span>
                                                        </div>
                                                                    </span>
                                                                </div>
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                            
                                                            
                                                            
                                                            
                                   


                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                       
                                   
                                </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
               
               
                  <div class="space-18"></div>

       <div class="modal-footer">
        
          
                                                            
     
                                        <a class="btn btn-sm" href="index.php?page=parada&accion=listparada">
                                            <i class="ace-icon fa fa-times"></i>
                                            Cancelar
                                        </a>

                                        <button class="btn btn-sm btn-primary"  >
                                            <i class="ace-icon fa fa-check"></i>
                                            Guardar
                                        </button>
                                   
    </div>
       
 


               
               
                </div><!-- /.widget-box -->


     </form>
           
           
                 <script src="view/js/adicionales.js"></script>  
   
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
        <script src="assets/js/autosize.min.js"></script>
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
			
			
				 
				     jQuery(function ($) {
                           /////////
                                $('#modal-regisparada input[type=file]').ace_file_input({
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
                           $('#modal-regisparada').on('shown.bs.modal', function () {
                               if (!ace.vars['touch']) {
                                   $(this).find('.chosen-container').each(function () {
                                       $(this).find('a:first-child').css('width', '210px');
                                       $(this).find('.chosen-drop').css('width', '210px');
                                       $(this).find('.chosen-search input').css('width', '200px');
                                   });
                               }
        
                           })
 

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
                                
                                
                                
   $('#timepicker2').timepicker({
                                    minuteStep: 1,
                                    showSeconds: true,
                                    showMeridian: false,
                                    disableFocus: true,
                                    icons: {
                                        up: 'fa fa-chevron-up',
                                        down: 'fa fa-chevron-down'
                                    }
                                }).on('focus', function () {
                                    $('#timepicker2').timepicker('showWidget');
                                }).next().on(ace.click_event, function () {
                                    $(this).prev().focus();
                                });
     var tag_input = $('#form-field-tags');
                                try {
                                    tag_input.tag(
                                            {
                                                placeholder: tag_input.attr('placeholder'),
                                                //enable typeahead by specifying the source array
                                                source: ace.vars['US_STATES'], //defined in ace.js >> ace.enable_search_ahead
                                                /**
                                                 //or fetch data from database, fetch those that match "query"
                                                 source: function(query, process) {
                                                 $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
                                                 .done(function(result_items){
                                                 process(result_items);
                                                 });
                                                 }
                                                 */
                                            }
                                    )

                                    //programmatically add/remove a tag
                                    var $tag_obj = $('#form-field-tags').data('tag');
                                    $tag_obj.add('Programmatically Added');

                                    var index = $tag_obj.inValues('some tag');
                                    $tag_obj.remove(index);
                                }
                                catch (e) {
                                    //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
                                    tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
                                    //autosize($('#form-field-tags'));
                                }


$(document).one('ajaxloadstart.page', function (e) {
                                    autosize.destroy('textarea[class*=autosize]')

                                    $('.limiterBox,.autosizejs').remove();
                                    $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
                                });
                          
 autosize($('textarea[class*=autosize]'));
                                });
            </script>

         