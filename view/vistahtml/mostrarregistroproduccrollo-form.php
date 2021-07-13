

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 ?>
  <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<div class="col-sm-12" id="actualizarListRollo">
    
    <div class="col-sm-12" id="cargando"></div>
    <form  class="form-horizontal" role="form"  
           method="post">

    <div class="modal-body">
        <div class="widget-box">
            <div class="widget-header widget-header-small">
                <h5 class="widget-title lighter">Ingresar Datos</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <div class="row">

                        <div class="col-xs-12 col-sm-4">

   
                                  <div class="form-group">

                                <div class="col-sm-12">

                                    <select name="proroll_id" class="chosen-select form-control" onchange="cargarregistros();" id="proroll_id" data-placeholder="Choose a State...">
                                       
                                        <?php if (count($listProductos)): ?>
                                            <?php foreach ($listProductos as $lista): ?>
                                                <option value="<?php echo $lista ['proroll_id'] ?>" 
                                                   
                                                >
                                                <?php echo $lista ['codart'] . " - " . $lista['desart']; ?>
                                                </option>
                                            <?php endforeach; ?>

<?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">


                                <div class="col-sm-12">

                                    <select name="emp" class="chosen-select form-control"  id="emp" data-placeholder="Choose a State...">
                                        <option value="-1">Ingrese una colaborador</option>
                                        <?php if (count($listaemp)): ?>
                                                    <?php foreach ($listaemp as $lista): ?>
                                                <option value="<?php echo $lista ['codempl'] ?>" 
                                                   
                                                    
                                                    >
                                                <?php echo $lista['nroid']." ".$lista['apellidopaterno']." ".$lista['apellidomaterno']." ".$lista['primernombre']." ".$lista['segundonombre']; ?>
                                                </option>
                                            <?php endforeach; ?>

<?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <?php if($procesos == '167'):?>
                            
                            <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required" readonly placeholder="Metros Lineales del rollo"  class="form-control" 
                                           name="mtrslineales" id="mtrslineales"
								value=""  />
                                    
                                </div>
                            </div>
                            
                             <div class="form-group">
                            <div class="col-sm-6">
                                    <input type="text"  readonly placeholder="Metros Lineales del rollo"  class=" valorform"    onkeyup="sumaform();" 
                                           name="mtrsavance" id="mtrsavance"
								value="<?php echo  $mtrstotales*(-1) ;?>"  />
                                    
                                </div>
                            </div>
                            
                            
                             <div class="form-group">
                            <div class="col-sm-6">
                                    <input type="text"   placeholder="Metros que indica la máquina" autocomplete="off"    class=" valorform" onkeyup="sumaform();" 
                                           name="avancmaq" id="avancmaq"
								value=""  />
                                    
                                </div>
                            </div>
							
                               <?php else:?>
                               
                            <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required"  placeholder="Metros Lineales del rollo" class="form-control" 
                                           name="mtrslineales" id="mtrslineales"
								value=""  />
                                    
                                </div>
                            </div>
                            
                               <?php endif;?>
                            
                   
                        
                            <div class="hr hr32 hr-dotted" style="margin-top: 15px; margin-bottom: 7px;"></div>
                            <div class="hr hr32 hr-dotted" style="margin-top: 7px; margin-bottom: 15px;"></div>
                            


                            <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required" placeholder="Peso del rollo (*)" class="form-control" 
                                           name="peso" id="peso" value="0"
 value="" 

                                           />
                                </div>
                            </div>

                                      <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required" placeholder="comentarios.." class="form-control" 
                                           name="comentario" id="comentario"
 value="" 

                                           />
                                </div>
                            </div>

                            

                            <div class="form-group">
                                
                                <div class="col-xs-8">
                                   
                                </div>
                                <div class="col-xs-4">
<!--                                    <button class="btn btn-success btn-next" data-last="Finish" id="guardardiseno">
                                        Guardar
                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                    </button>-->
<button type="button" class="btn btn-success btn-next" <?php echo $acceso; ?> data-last="Finish" id="btnguardardatosProdRollos">
                                        Guardar
                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8" id="listaavanceproduccion">

                           
                        </div>
                    
                    
                    </div>


                </div>
            </div>
        </div>


    </div>

    <div class="space-18"></div>

       <div class="modal-footer">
          <input type="hidden" name="proroll_id" id="proroll_id" value="<?php echo $proroll_id;?>">
          <input id ="ini" name="ini" type="hidden" value="<?php echo $ini; ?>">
          <input id ="fin" name="fin" type="hidden" value="<?php echo $fin; ?>">
          <input id ="procesos" name="procesos" type="hidden" value="<?php echo $procesos; ?>">
          <input id ="estado"  name="estado" type="hidden" value="<?php echo $estado; ?>">
             <input id ="maquina"  name="maquina" type="hidden" value="<?php echo $maquina; ?>">
               <input id ="items" type="hidden" value="<?php  echo $items; ?>">
            <input id ="opedido" type="hidden" value="<?php  echo  $opedido; ?>">
             <input id ="acceso" type="hidden" value="<?php  echo  $acceso; ?>">
                                                            
<!--        <button type="button" class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
            Cancelar
        </button>-->

          <button type="button" class="btn btn-sm btn-primary" id="btnActualizarRegistros">
            <i class="ace-icon fa fa-check"></i>
            Salir
        </button>
    </div>
       



</form>

</div>

  
                 <script type="text/javascript">


            function sumaform() {

                var total = 0;

                $(".valorform").each(function () {

                    if (isNaN(parseFloat($(this).val()))) {

                        total += 0;

                    } else {

                        total += parseFloat($(this).val());

                    }

                });

//alert(total);
//                document.getElementById('spTotal').innerHTML = total;
                document.getElementById("mtrslineales").value = total.toFixed(2);
                
                

            }

        </script>
         
  
  
  
  
  
  
  
  
  
  
<script src="view/js/kanbanlista.js"></script>     
<!--<script  src="view/js/diseno.js"></script>-->  
 <script src="assets/js/jquery-ui.min.js"></script>
            <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
            


<script type="text/javascript">
                                jQuery(function ($) {




                                    $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                                        no_file: 'No File ...',
                                        btn_choose: 'Choose',
                                        btn_change: 'Change',
                                        droppable: false,
                                        onchange: null,
                                        thumbnail: false //| true | large

                                    });


                                    $('#id-input-file-3').ace_file_input({
                                        style: 'well',
                                        btn_choose: 'Drop files here or click to choose',
                                        btn_change: null,
                                        no_icon: 'ace-icon fa fa-cloud-upload',
                                        droppable: true,
                                        thumbnail: 'small'//large | fit

                                        ,
                                        preview_error: function (filename, error_code) {

                                        }

                                    }).on('change', function () {

                                    });


                                    $('#id-file-format').removeAttr('checked').on('change', function () {
                                        var whitelist_ext, whitelist_mime;
                                        var btn_choose
                                        var no_icon
                                        if (this.checked) {
                                            btn_choose = "Drop images here or click to choose";
                                            no_icon = "ace-icon fa fa-picture-o";

                                            whitelist_ext = ["jpeg", "jpg", "png", "gif", "bmp"];
                                            whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
                                        }
                                        else {
                                            btn_choose = "Drop files here or click to choose";
                                            no_icon = "ace-icon fa fa-cloud-upload";

                                            whitelist_ext = null;//all extensions are acceptable
                                            whitelist_mime = null;//all mimes are acceptable
                                        }
                                        var file_input = $('#id-input-file-3');
                                        file_input
                                                .ace_file_input('update_settings',
                                                        {
                                                            'btn_choose': btn_choose,
                                                            'no_icon': no_icon,
                                                            'allowExt': whitelist_ext,
                                                            'allowMime': whitelist_mime
                                                        })
                                        file_input.ace_file_input('reset_input');

                                        file_input
                                                .off('file.error.ace')
                                                .on('file.error.ace', function (e, info) {
                                                    //because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
                                                });




                                    });



                                    $('#modal-diseno input[type=file]').ace_file_input({
                                        style: 'well',
                                        btn_choose: 'Drop files here or click to choose',
                                        btn_change: null,
                                        no_icon: 'ace-icon fa fa-cloud-upload',
                                        droppable: true,
                                        thumbnail: 'large'
                                    })

                                    $('#modal-asignaravance').on('shown.bs.modal', function () {
                                        if (!ace.vars['touch']) {
                                            $(this).find('.chosen-container').each(function () {
                                                $(this).find('a:first-child').css('width', '350px');
                                                $(this).find('.chosen-drop').css('width', '350px');
                                                $(this).find('.chosen-search input').css('width', '340px');
                                            });
                                        }
                                    })


                                    $(document).one('ajaxloadstart.page', function (e) {
                                        autosize.destroy('textarea[class*=autosize]')

                                        $('.limiterBox,.autosizejs').remove();
                                        $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
                                    });


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



     //spinner
                                                                            var spinner = $("#spinner").spinner({
                                                                                create: function (event, ui) {
                                                                                    //add custom classes and icons
                                                                                    $(this)
                                                                                            .next().addClass('btn btn-success').html('<i class="ace-icon fa fa-plus"></i>')
                                                                                           // .next().addClass('btn btn-danger').html('<i class="ace-icon fa fa-minus"></i>')

                                                                                    //larger buttons on touch devices
                                                                                    if ('touchstart' in document.documentElement)
                                                                                        $(this).closest('.ui-spinner').addClass('ui-spinner-touch');
                                                                                }
                                                                            });

                                                                            //slider example
                                                                            $("#slider").slider({
                                                                                range: true,
                                                                                min: 0,
                                                                                max: 500,
                                                                                values: [75, 300]
                                                                            });

                                                                        


                                });
</script>











