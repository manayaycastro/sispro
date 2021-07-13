<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;

//echo $cod;
?>




<?php ?>
<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<div class="col-sm-12" id="actualizarlista">

    <div class="col-sm-12" id="cargando"></div>
    <form  class="form-horizontal" role="form"  id="datosdiseno"  action="index.php?page=articulocaractecnicas&accion=insertar<?php if (!empty($idsemiterminado)) : ?>&id=<?php
        echo $idsemiterminado;
    endif;
    ?>" method="POST">

        <div class="modal-body">
            <div class="widget-box">
                <div class="widget-header widget-header-small">
                    <h5 class="widget-title lighter">Ingresar Datos</h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <div class="row">

                            <div class="col-sm-12">


                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <!--onchange="ShowSelected();"--> 
                                        <select name="articulos" class="chosen-select form-control" 

                                                onchange="ShowSelected();"



                                                id="articulos" data-placeholder="Choose a State...">
                                            <?php if (empty($idsemiterminado)): ?>   <option value="-1">Ingrese una artìculo..</option>   <?php endif; ?>

                                            <?php if (count($articulos)): ?>
                                                <?php foreach ($articulos as $articulo): ?>
                                                    <option value="<?php echo $articulo ['codart'] ?>" 

                                                            <?php if (!empty($idsemiterminado)):
                                                                
                                                                if ($articulo ['codart'] == $artsemiter->getForm_id()): ?> selected 


                                                                <?php else: ?> 
                                                            
                                                            
                                                                    disabled="disabled"
                                                                <?php endif; ?>
                                                             <?php else: ?>
                                                                      <?php if($articulo ['artsemi_id'] != null): ?>
                                                                        disabled="disabled"
                                                                          <?php else: ?>
                                                                          
                                                                            <?php endif; ?>
                                                                    
                                                            <?php endif; ?>

                                                            >


                                                        <?php echo $articulo ['codart'] . " - " . $articulo['descripcion']; ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            <?php endif; ?>
                                        </select>

										   <input type="hidden" name="tipsemi" id="tipsemi" value= "<?php echo  $tipsemi; ?>" >
                                        <input type="hidden" name="nombreart" id="nombreart" >
                                        <input type="hidden" name="idsemiterminado" id="idsemiterminado" <?php if (!empty($idsemiterminado)) : ?> value="<?php echo $idsemiterminado; ?>" <?php else: ?>value="0"<?php endif; ?> >

                                        <div class="hr hr32 hr-dotted" style="margin-top: 15px; margin-bottom: 7px;"></div>
                                        <div class="hr hr32 hr-dotted" style="margin-top: 7px; margin-bottom: 15px;"></div>

                                        <div class="col-xs-12 col-sm-12"  >
                                            <?php $a = 0;
                                            $b = 0;
                                            $c = 0; ?>     

                                            <div class="tabbable">
                                                <ul class="nav nav-tabs padding-16">
                                                    <?php if ($clasif): ?>

                                                            <?php foreach ($clasif as $clasi): ?>
                                                                    <?php $a = $a + 1; ?>     
                                                            <li  <?php if ($a == 1): ?>   class="active"<?php endif; ?> >    
                                                                <a data-toggle="tab" href="#edit-<?php echo $clasi['clasem_id']; ?>">
                                                            <?php echo $clasi['clasem_titulo']; ?>
                                                                </a>
                                                            </li>


                                                            <?php endforeach; ?>

                                                    <?php endif; ?>

                                                </ul>
                                                <!-- ----------------------------aqui comienza a listar los submenus  --------------------------------- -->
                                                <div class="tab-content profile-edit-tab-content" style="padding: 8px 32px 350px; ">
                                                    <?php if ($clasif1): ?>

    <?php foreach ($clasif1 as $clas): ?>
        <?php $b = $b + 1; ?>
                                                            <div id="edit-<?php echo $clas['clasem_id']; ?>" class="tab-pane <?php if ($b == 1): ?> in active  <?php endif; ?>">



                                                                <h4 class="header blue bolder smaller"><?php echo $clas['clasem_titulo']; ?></h4>


                                                                <?php if ($items): ?>
                                                                    <?php foreach ($items as $item): ?>

                <?php if ($item['clasem_id'] == $clas['clasem_id']): ?>
                    <?php $c = $c + 1 ?>



                                                                            <?php ?>

                    <?php if ($c % 2 != 0): ?>
<!--                                                                                                                 <div class="space-20"></div>-->

                                                                                <div class="col-sm-6">

                                                                                    <div class="form-group">
                                                                                        <label class="col-sm-5 control-label no-padding-right" for="form-field-1-1">  <?php echo $item["itemcaracsemi_descripcion"]; ?>  </label>
                                                                                        <div class="col-sm-7">
                                                                                            <?php if ($item['itemcaracsemi_tipodato'] == '_caja'): ?>
                                                                                                <input  type="text" name="<?php echo $item["itemcaracsemi_id"]; ?>"  value="<?php echo $item["valitemcarac_valor"]; ?>"  placeholder="Ingrese un valor" class="form-control" />

                        <?php elseif ($item['itemcaracsemi_tipodato'] == '_combo'): ?>
                            <?php $listar = $artcaractecnicas->listacombo($item['itemcaracsemi_tabla'], $idsemiterminado); ?> 

                                                                                                <select name='<?php echo $item["itemcaracsemi_id"]; ?>' class='chosen-select form-control'  id='<?php echo $item["itemcaracsemi_id"]; ?>' data-placeholder='Choose a State...'> 
                                                                                                    <option value='-1'>    Seleccione una opción  </option>
                                                                                                    <?php if (count($listar)): ?>
                                                                                                        <?php foreach ($listar as $lista): ?>
                                                                                                            <option value="<?php echo $lista [$item['itemcaracsemi_tabla_id']]; ?>"
                                                                                                                    <?php if (!empty($item["valitemcarac_valor"])): ?>
                                                                                                                        <?php if ($lista [$item['itemcaracsemi_tabla_id']] == (int) $item["valitemcarac_valor"]): ?> 
                                                                                                                            selected  
                                        <?php endif; ?>
                                                                                                                <?php endif; ?>
                                                                                                                    >

                                                                                                            <?php echo $lista[$item['itemcaracsemi_tabla_descripcion']]; ?>  
                                                                                                            </option>

                                                                                                        <?php endforeach; ?>

                            <?php endif; ?>
                                                                                                </select>


                        <?php endif; ?>


                                                                                        </div>

                                                                                    </div>


                                                                                </div>

                                                                                <!--<div class="space-8"></div>-->

                    <?php else: ?> 

                                                                                <div class="col-sm-6">

                                                                                    <div class="form-group">
                                                                                        <label class="col-sm-5 control-label no-padding-right" for="form-field-1-1">  <?php echo $item["itemcaracsemi_descripcion"]; ?>  </label>
                                                                                        <div class="col-sm-7">
                                                                                            <?php if ($item['itemcaracsemi_tipodato'] == '_caja'): ?>
                                                                                                <input  type="text" name="<?php echo $item["itemcaracsemi_id"]; ?>"  value="<?php echo $item["valitemcarac_valor"]; ?>"  placeholder="Ingrese un valor" class="form-control" />

                        <?php elseif ($item['itemcaracsemi_tipodato'] == '_combo'): ?>
                            <?php $listar = $artcaractecnicas->listacombo($item['itemcaracsemi_tabla'], $idsemiterminado); ?> 

                                                                                                <select name='<?php echo $item["itemcaracsemi_id"]; ?>' class='chosen-select form-control'  id='<?php echo $item["itemcaracsemi_id"]; ?>' data-placeholder='Choose a State...'> 
                                                                                                    <option value='-1'>    Seleccione una opción  </option>
                                                                                                    <?php if (count($listar)): ?>
                                                                                                        <?php foreach ($listar as $lista): ?>
                                                                                                            <option value="<?php echo $lista [$item['itemcaracsemi_tabla_id']]; ?>"
                                                                                                                    <?php if (!empty($item["valitemcarac_valor"])): ?>
                                                                                                                        <?php if ($lista [$item['itemcaracsemi_tabla_id']] == (int) $item["valitemcarac_valor"]): ?> 
                                                                                                                            selected  
                                        <?php endif; ?>
                                                                                                                <?php endif; ?>
                                                                                                                    >

                                                                                                            <?php echo $lista[$item['itemcaracsemi_tabla_descripcion']]; ?>  
                                                                                                            </option>

                                                                                                        <?php endforeach; ?>

                            <?php endif; ?>
                                                                                                </select>


                        <?php endif; ?>


                                                                                        </div>

                                                                                    </div>

                                                                                </div>      

                                                                              
                    <?php endif; ?>        

                                                                   



                                                                        <?php endif; ?>
                                                                                 
            <?php endforeach; ?>
                  <!--<div class="space-8"></div>-->                                                               
        <?php endif; ?>



                                                            </div>
 
                                                        <?php endforeach; ?>

<?php endif; ?>
                                                    
                                                    <!--<div class="space-80"></div>-->
                                                </div>

                                            </div>
                                        </div>





                                    </div>

                                </div>
                            </div>








                        </div>


                    </div>
                </div>
            </div>


        </div>



        <div class="modal-footer">
            <a class="btn btn-sm" data-dismiss="modal">
                <i class="ace-icon fa fa-times"></i>
                Cancel
            </a>

            <button class="btn btn-sm btn-primary">
                <i class="ace-icon fa fa-check"></i>
                Save
            </button>
        </div>


    </form>

</div>


<!--<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>-->

<script type="text/javascript">
    function ShowSelected()
    {

        /* Para obtener el texto */
        var combo = document.getElementById("articulos");
//var selected = combo.options[combo.selectedIndex].text;
        var selected = combo.options[combo.selectedIndex].text;
        document.getElementById("nombreart").value = selected;

    }
</script>

      <!--<script src="assets/js/ace.min.js"></script>-->



<script src="view/js/articulocaractecnicas.js"></script>

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





        $('#modal-caractart').on('shown.bs.modal', function () {
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


