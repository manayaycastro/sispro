<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Tables - Ace Admin</title>

        <meta name="description" content="Static &amp; Dynamic Tables" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <![endif]-->
        <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="assets/js/ace-extra.min.js"></script>
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
          <link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
        <link rel="stylesheet" href="assets/css/chosen.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
        <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />

    
        
        
        
        
        
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
                                <a href="#">Inicio</a>
                            </li>

                            <li>
                                <a href="#">Mantenimiento</a>
                            </li>
                            <li class="active">Registro de Paradas</li>
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




                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->



                                <div class="row">
                                    <div class="col-xs-12">


                                        <div class="col-xs-12"> 
                                            <div class="col-xs-9">
                                                <h4 class="header smaller lighter blue">Cantidad de registros <span class="badge"><?php echo count($paradas); ?></span></h4>
                                            </div>
                                            <div class="col-xs-3">
<!--                                                <a class="btn btn-primary" id ="parada_registro" 
                                                   
                                                   
                                                   >
                                                    <i class="ace-icon fa fa-plus align-top bigger-125"></i>
                                                    Nuevo
                                                </a>-->
                                                <a class="btn btn-primary" href="index.php?page=parada&accion=paradareg">Nuevo
                                                 <i class="ace-icon fa fa-plus align-top bigger-125"></i>
                                                </a>
                                                
                                            </div>
                                        </div>
                                        <br>

                                        <div class="clearfix">
                                            <div class="pull-right tableTools-container"></div>
                                        </div>
                                        <div class="table-header">
                                            Results for "Latest Registered Domains"
                                        </div>

                                        <!-- div.table-responsive -->

                                        <!-- div.dataTables_borderWrap -->
                                        <div>
                                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="center">
                                                            <label class="pos-rel">
                                                                <input type="checkbox" class="ace" />
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </th>
                                                        <th>Id</th>
                                                        <th>Nombre</th>
                                                        <th class="hidden-480">Tipo</th>
                                                             <th class="hidden-480">??rea</th>
                                                        <th class="hidden-480">Observaci??n</th>
                                                       
                                                           <th class="hidden-480">Incio</th>
                                                             <th class="hidden-480">Fin</th>
                                                           
                                                        
                                                       

                                                        <th>Acci??n</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php if (count($paradas)): ?>
                                                        <?php foreach ($paradas as $parada): ?>
                                                            <tr>
                                                                <td class="center">
                                                                    <label class="pos-rel">
                                                                        <input type="checkbox" class="ace" />
                                                                        <span class="lbl"></span>
                                                                    </label>
                                                                </td>
                                                                <td><?php echo $parada ['parreg_id']; ?></td>
                                                                <td><?php echo $parada ['par_nombre']; ?></td>
                                                                 <td><?php echo $parada ['tippar_titulo']; ?></td>
                                                                   <td><?php echo $parada ['are_titulo']; ?></td>
                                                                   <td><?php echo $parada ['parreg_obs']; ?></td>
                                                                   <td><?php echo $parada ['parreg_inicio']; ?></td>
                                                                   <td><?php echo $parada ['parreg_fin']; ?></td>

                                                               
                                                                <td>
                                                                    <div class="hidden-sm hidden-xs action-buttons">
<!--                                                                        <a class="blue"
                                                                           onclick=" false" href="#" data-estado ="<?php echo $parada ['par_id']; ?>" id="mostrar_form_parada"
                                                                           
                                                                           >
                                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                                        </a>-->

                                                                        <a class="blue" 
                                                                          
                                                                           onclick=" false" href="index.php?page=parada&accion=ajaxverdetalleparada&id=<?php echo $parada ['par_id']; ?>"
                                                                           >
                                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                                        </a>

                                                                        <a class="green" 
                                                                           onclick=" false" href="#" data-estado ="<?php echo $parada ['par_id']; ?>" id="editar_form_parada"
                                                                           >
                                                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                                        </a>
                                                                       

                                                                        <a class="red" 
                                                                           id="bootbox-confirm"
                                                                           onclick=" false" href="index.php?page=parada&accion=eliminar&id=<?php echo $parada ['par_id']; ?>"
                                                                           >
                                                                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                        </a>
                                                                    </div>

                                                                    <div class="hidden-md hidden-lg">
                                                                        <div class="inline pos-rel">
                                                                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                                            </button>

                                                                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                                <li>
                                                                                    <a  class="tooltip-info" data-rel="tooltip" title="Ver detalle"

                                                                                        onclick=" false" href="#" data-estado ="<?php echo $parada ['par_id']; ?>" id="mostrar_form_parada"

                                                                                        >

                                                                                        <span class="blue">
                                                                                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                                        </span>
                                                                                    </a>
                                                                                </li>

                                                                                <li>
                                                                                    <a class="tooltip-info" data-rel="tooltip" title="Editar"

                                                                                       onclick=" false" href="#" data-estado ="<?php echo $parada ['par_id']; ?>" id="editar_form_parada"

                                                                                       >
                                                                                        <span class="green">
                                                                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                                        </span>
                                                                                    </a>
                                                                                </li>
                                                                                
                                                     

                                                                                <li>
                                                                                    <a class="tooltip-error" id="bootbox-confirm"
                                                                                       href="index.php?page=parada&accion=eliminar&id=<?php echo $parada ['par_id']; ?>"  data-rel="tooltip" title="Eliminar">
                                                                                        <span class="red">
                                                                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                                        </span>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="id_<?php echo $parada ['par_id']; ?>" name="id_<?php echo $parada ['par_id']; ?>" value="<?php echo $parada ['par_id']; ?>" />  
                                                                </td>



                                                                




                                                            </tr>
                                                       
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <?php echo '<div class="alert alert-warning">No se encontraron registros.</div>'; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->


            <!-- /.Inicio del modal menu -->
            <div id="modal-form-paradareg" class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="blue bigger">Descripcion de la Parada</h4>
                        </div>


                        <div id = "formparada_reg">


                        </div>

                    </div>
                </div>
            </div>
            
     
            
  
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

 <script src="view/js/parada.js"></script>

        <script type="text/javascript">
                            if ('ontouchstart' in document.documentElement)
                                document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="assets/js/jquery-ui.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="assets/js/chosen.jquery.min.js"></script>
        <script src="assets/js/spinbox.min.js"></script>
        <script src="assets/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/js/bootstrap-timepicker.min.js"></script>
         <script src="assets/js/bootstrap-tag.min.js"></script>
          <script src="assets/js/jquery.maskedinput.min.js"></script>
        
        
          <script type="text/javascript">
           $.mask.definitions['~'] = '[+-]';
                                $('.input-mask-date').mask('99/99/9999');
                                $('.input-mask-phone').mask('(999) 999-9999');
                                $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
                                $(".input-mask-product").mask("a*-999-a999", {placeholder: " ", completed: function () {
                                        alert("You typed the following: " + this.val());
                                    }});
          
          </script>
        
        
       


        <script type="text/javascript">
                                                                                   if ('ontouchstart' in document.documentElement)
                                                                                       document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- page specific plugin scripts -->
        <script src="assets/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
        <script src="assets/js/dataTables.buttons.min.js"></script>
        <script src="assets/js/buttons.flash.min.js"></script>
        <script src="assets/js/buttons.html5.min.js"></script>
        <script src="assets/js/buttons.print.min.js"></script>
        <script src="assets/js/buttons.colVis.min.js"></script>
        <script src="assets/js/dataTables.select.min.js"></script>

        <script src="assets/js/bootbox.js"></script>

        <!-- ace scripts -->
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>
        
    <script src="assets/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/js/bootstrap-timepicker.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/daterangepicker.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/bootstrap-colorpicker.min.js"></script>

        
        
        
        
        
        
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


                                $(".knob").knob();

        </script>



        <!-- inline scripts related to this page -->
        <script type="text/javascript">
                                                                                   jQuery(function ($) {
                                                                                       //initiate dataTables plugin
                                                                                       var myTable =
                                                                                               $('#dynamic-table')
                                                                                               //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                                                                                               .DataTable({
                                                                                                   bAutoWidth: false,
                                                                                                   "aoColumns": [
                                                                                                       {"bSortable": false},
                                                                                                       null, null, null, null,null,null,null,
                                                                                                       {"bSortable": false}
                                                                                                   ],
                                                                                                   "aaSorting": [],
                                                                                                   select: {
                                                                                                       style: 'multi'
                                                                                                   }
                                                                                               });



                                                                                       $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

                                                                                       new $.fn.dataTable.Buttons(myTable, {
                                                                                           buttons: [
                                                                                               {
                                                                                                   "extend": "colvis",
                                                                                                   "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
                                                                                                   "className": "btn btn-white btn-primary btn-bold",
                                                                                                   columns: ':not(:first):not(:last)'
                                                                                               },
                                                                                               {
                                                                                                   "extend": "copy",
                                                                                                   "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
                                                                                                   "className": "btn btn-white btn-primary btn-bold"
                                                                                               },
                                                                                               {
                                                                                                   "extend": "csv",
                                                                                                   "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
                                                                                                   "className": "btn btn-white btn-primary btn-bold"
                                                                                               },
                                                                                               {
                                                                                                   "extend": "excel",
                                                                                                   "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                                                                                                   "className": "btn btn-white btn-primary btn-bold"
                                                                                               },
                                                                                               {
                                                                                                   "extend": "pdf",
                                                                                                   "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                                                                                                   "className": "btn btn-white btn-primary btn-bold"
                                                                                               },
                                                                                               {
                                                                                                   "extend": "print",
                                                                                                   "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
                                                                                                   "className": "btn btn-white btn-primary btn-bold",
                                                                                                   autoPrint: false,
                                                                                                   message: 'This print was produced using the Print button for DataTables'
                                                                                               }
                                                                                           ]
                                                                                       });
                                                                                       myTable.buttons().container().appendTo($('.tableTools-container'));

                                                                                       //style the message box
                                                                                       var defaultCopyAction = myTable.button(1).action();
                                                                                       myTable.button(1).action(function (e, dt, button, config) {
                                                                                           defaultCopyAction(e, dt, button, config);
                                                                                           $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
                                                                                       });


                                                                                       var defaultColvisAction = myTable.button(0).action();
                                                                                       myTable.button(0).action(function (e, dt, button, config) {

                                                                                           defaultColvisAction(e, dt, button, config);


                                                                                           if ($('.dt-button-collection > .dropdown-menu').length == 0) {
                                                                                               $('.dt-button-collection')
                                                                                                       .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                                                                                                       .find('a').attr('href', '#').wrap("<li />")
                                                                                           }
                                                                                           $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
                                                                                       });

                                                                                       ////

                                                                                       setTimeout(function () {
                                                                                           $($('.tableTools-container')).find('a.dt-button').each(function () {
                                                                                               var div = $(this).find(' > div').first();
                                                                                               if (div.length == 1)
                                                                                                   div.tooltip({container: 'body', title: div.parent().text()});
                                                                                               else
                                                                                                   $(this).tooltip({container: 'body', title: $(this).text()});
                                                                                           });
                                                                                       }, 500);





                                                                                       myTable.on('select', function (e, dt, type, index) {
                                                                                           if (type === 'row') {
                                                                                               $(myTable.row(index).node()).find('input:checkbox').prop('checked', true);
                                                                                           }
                                                                                       });
                                                                                       myTable.on('deselect', function (e, dt, type, index) {
                                                                                           if (type === 'row') {
                                                                                               $(myTable.row(index).node()).find('input:checkbox').prop('checked', false);
                                                                                           }
                                                                                       });




                                                                                       /////////////////////////////////
                                                                                       //table checkboxes
                                                                                       $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

                                                                                       //select/deselect all rows according to table header checkbox
                                                                                       $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function () {
                                                                                           var th_checked = this.checked;//checkbox inside "TH" table header

                                                                                           $('#dynamic-table').find('tbody > tr').each(function () {
                                                                                               var row = this;
                                                                                               if (th_checked)
                                                                                                   myTable.row(row).select();
                                                                                               else
                                                                                                   myTable.row(row).deselect();
                                                                                           });
                                                                                       });

                                                                                       //select/deselect a row when the checkbox is checked/unchecked
                                                                                       $('#dynamic-table').on('click', 'td input[type=checkbox]', function () {
                                                                                           var row = $(this).closest('tr').get(0);
                                                                                           if (this.checked)
                                                                                               myTable.row(row).deselect();
                                                                                           else
                                                                                               myTable.row(row).select();
                                                                                       });



                                                                                       $(document).on('click', '#dynamic-table .dropdown-toggle', function (e) {
                                                                                           e.stopImmediatePropagation();
                                                                                           e.stopPropagation();
                                                                                           e.preventDefault();
                                                                                       });



                                                                                       //And for the first simple table, which doesn't have TableTools or dataTables
                                                                                       //select/deselect all rows according to table header checkbox
                                                                                       var active_class = 'active';
                                                                                       $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function () {
                                                                                           var th_checked = this.checked;//checkbox inside "TH" table header

                                                                                           $(this).closest('table').find('tbody > tr').each(function () {
                                                                                               var row = this;
                                                                                               if (th_checked)
                                                                                                   $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                                                                                               else
                                                                                                   $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                                                                                           });
                                                                                       });

                                                                                       //select/deselect a row when the checkbox is checked/unchecked
                                                                                       $('#simple-table').on('click', 'td input[type=checkbox]', function () {
                                                                                           var $row = $(this).closest('tr');
                                                                                           if ($row.is('.detail-row '))
                                                                                               return;
                                                                                           if (this.checked)
                                                                                               $row.addClass(active_class);
                                                                                           else
                                                                                               $row.removeClass(active_class);
                                                                                       });



                                                                                       /********************************/
                                                                                       //add tooltip for small view action buttons in dropdown menu
                                                                                       $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

                                                                                       //tooltip placement on right or left
                                                                                       function tooltip_placement(context, source) {
                                                                                           var $source = $(source);
                                                                                           var $parent = $source.closest('table')
                                                                                           var off1 = $parent.offset();
                                                                                           var w1 = $parent.width();

                                                                                           var off2 = $source.offset();
                                                                                           //var w2 = $source.width();

                                                                                           if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
                                                                                               return 'right';
                                                                                           return 'left';
                                                                                       }




                                                                                       /***************/
                                                                                       $('.show-details-btn').on('click', function (e) {
                                                                                           e.preventDefault();
                                                                                           $(this).closest('tr').next().toggleClass('open');
                                                                                           $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
                                                                                       });



                                                                                   })
        </script>
        
         
      
    </body>
</html>
