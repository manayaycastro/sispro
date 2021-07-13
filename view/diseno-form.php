<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;
$cod =$disenodatos->getProdi_codart();
//echo $cod;
?>
    <script type="text/javascript">

        // funcion que se ejecuta cada vez que se selecciona una opción

         	$('#articulos').on('change', function(e){
		e.preventDefault();

		var articulos = $(this).val();

		if(articulos != -1){
			//getDependencias(departamento);	
                          //var botonagregardet = document.getElementById('agregdet');
//                       var nomdise = document.getElementById('nomactual').value
//                       var opc  =  document.getElementById("articulos").value;
//            document.getElementById('nomdiseno').value= nomdise    
		}
	});
          
         
   
            </script>

<?php ?>
  <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<div class="col-sm-12" id="actualizarlista">
    
    <div class="col-sm-12" id="cargando"></div>
    <form  class="form-horizontal" role="form"  enctype="multipart/form-data" id="datosdiseno"
           action="" method="post">

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

                                    <select name="articulos" class="chosen-select form-control" onchange="cargardisenos();" id="articulos" data-placeholder="Choose a State...">
                                        <option value="-1">Ingrese una artìculo..</option>
                                        <?php if (count($articulos)): ?>
                                            <?php foreach ($articulos as $articulo): ?>
                                                <option value="<?php echo $articulo ['codart'] ?>" 
                                                  
                                                    
                                                    
                                                        <?php if (!empty($id)):?>
                                                                
																		<?php     if ($articulo ['codart'] == $disenodatos->getProdi_codart()): ?> selected 


																			<?php else: ?> 
																		
																		
																				disabled="disabled"
																			<?php endif; ?>
                                                             <?php else: ?>
																			  <?php if($articulo ['prodi_codart'] != null): ?>
																				disabled="disabled"
																				  <?php else: ?>
																				
																					<?php endif; ?>
                                                                    
                                                            <?php endif; ?>
                                                    
                                                    
                                                >
                                                <?php echo $articulo ['codalt'] . " - " . $articulo['descripcion']; ?>
                                                </option>
                                            <?php endforeach; ?>

<?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">


                                <div class="col-sm-12">

                                    <select name="cliente" class="chosen-select form-control"  id="cliente" data-placeholder="Choose a State...">
                                        <option value="-1">Ingrese una cliente</option>
                                        <?php if (count($clientes)): ?>
                                                    <?php foreach ($clientes as $cliente): ?>
                                                <option value="<?php echo $cliente ['codcli'] ?>" 
                                                    <?php if ($cliente ['codcli'] == $disenodatos->getProdi_cliente()): ?> selected  
                                                        
                                                        <?php else:?>
                                                        <?php echo $permiso."="."'$permiso'"; ?> 
                                                        <?php endif;?>
                                                    
                                                    >
                                                <?php echo $cliente['razonsocial']; ?>
                                                </option>
                                            <?php endforeach; ?>

<?php endif; ?>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required" placeholder="Nombre del diseño" class="form-control" 
                                           name="nomdiseno" id="nomdiseno"
value="<?php echo $disenodatos->getProdi_nombre(); ?>" <?php echo $permiso2; ?>

                                           />
                                    <input type="hidden" id="permiso" name="permiso" value="<?php echo $permiso; ?>"/>
                                </div>
                            </div>
                            
                             <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required" placeholder="comentarios.." class="form-control" 
                                           name="comentario" id="comentario"
 value="<?php echo $disenodatos->getProdi_comentario(); ?>" <?php echo $permiso2; ?>

                                           />
                                </div>
                            </div>

                        
                            <div class="hr hr32 hr-dotted" style="margin-top: 15px; margin-bottom: 7px;"></div>
                            <div class="hr hr32 hr-dotted" style="margin-top: 7px; margin-bottom: 15px;"></div>
                            


                            <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required" placeholder="comentarios de la versión" class="form-control" 
                                           name="comentariodet" id="comentariodet"
 value="" 

                                           />
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input multiple="" type="file" name="archivo" id="archivo" required="required" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                   Versiòn
                                </div>
                                <div class="col-xs-4">
                                     <input id="spinner" name="spinner" type="text"  value="" readonly="readonly">
                                    </div>
                                <div class="col-xs-2">
                                   
                                </div>
                                <div class="col-xs-4">
<!--                                    <button class="btn btn-success btn-next" data-last="Finish" id="guardardiseno">
                                        Guardar
                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                    </button>-->
<button type="submit" class="btn btn-success btn-next" data-last="Finish" >
                                        Guardar
                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8" id="listadisenos">

                           
                        </div>
                    
                    
                    </div>


                </div>
            </div>
        </div>


    </div>

    <div class="space-18"></div>

    <div class="modal-footer">
        <button class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
            Cancelar
        </button>


    </div>


</form>

</div>

<script src="view/js/disenolista.js"></script>     
<!--<script  src="view/js/diseno.js"></script>-->  
 <script src="assets/js/jquery-ui.min.js"></script>
            <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
            
            <script>
  
  $('#datosdiseno').on('submit',(function(e) {
        e.preventDefault();
         $('#actualizarlista').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: 'index.php?page=diseno&accion=ajaxregistrardiseno',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
                $("#archivo").val("");
           
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        })
        
         .done(function (res) {
            $('#actualizarlista').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    }));




            
            
            </script>

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

                                    $('#modal-diseno').on('shown.bs.modal', function () {
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


