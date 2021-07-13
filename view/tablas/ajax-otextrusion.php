


<?php
require_once '../../model/extordentrabajo.php';
session_start();
$rango = '';

$rango = $_REQUEST['rango'];


$fecinicio = substr($rango, 0, 10);
$fecfinal = substr($rango, 13, 21);

$fecini = date_create($fecinicio);
$ini = date_format($fecini, 'Y-m-d');

$fecfin = date_create($fecfinal);
$fin = date_format($fecfin, 'Y-m-d');

//$area = new opedido();
//$areas = $area->consultar2($ini,$fin);

$list = new extordentrabajo();
$extordentrabajo = $list->consultarXfecha($ini,$fin);

$id_usuario = $_SESSION["idusuario"];
?> 
<style>
    #mdialTamanio{
        width: 90% !important;
    }
</style>
<div class="widget-body">
    <div class="widget-main">

        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue">Lista según siguiente filtro: <?php echo $ini . ' - ' . $fin; ?> </h3>
                


                <div id="actualizartabla">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->



                            <div class="row">
                                <div class="col-xs-12">


                                    <div class="col-xs-12"> 
                                        <div class="col-xs-9">
                                            <h4 class="header smaller lighter blue">Cantidad de registros <span class="badge"><?php echo count($extordentrabajo); ?></span></h4>
                                        </div>
                                           <?php if (($id_usuario == '1') or ( $id_usuario == '2') or ( $id_usuario == '3') or ( $id_usuario == '9')): ?>
                                        <div class="col-xs-3">

                                            <a class="btn btn-primary" href="index.php?page=extordentrabajo&accion=form"><i class="ace-icon fa fa-plus align-top bigger-125"></i>Nuevo</a>
                                        </div>
                                           <?php endif;?>
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
                                                    <th>Tip. Documento</th>

                                                    <th>Producto(s)</th>

                                                    <th class="hidden-480">Peine</th>
<!--                                                        <th>Area</th>
                                                    <th>Turno</th>
                                                    <th class="hidden-480">Máquina</th>-->

                                                    <th>
                                                        <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                                        Fecha Documento.
                                                    </th>
                                                    <th class="hidden-480">Num. Bajad.</th>
                                                    <th class="hidden-480">Turno</th>


                                                    <th class="hidden-480">Estado</th>
                                                    <th class="hidden-480">Alta</th>
                                                    <th class="hidden-480">Detalle</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>

                                            <tbody>

<?php if (count($extordentrabajo)): ?>
    <?php foreach ($extordentrabajo as $lista): ?>
                                                        <tr>
                                                            <td class="center">
                                                                <label class="pos-rel">
                                                                    <input type="checkbox" class="ace" />
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </td>
                                                            <td><?php echo $lista ['extot_id']; ?></td>
                                                            <td><?php echo $lista ['tipdoc_titulo']; ?></td>

                                                            <td>
        <?php if ($lista ['extot_peine'] == 0): ?>

                                                                    <span class="label label-sm label-inverse arrowed-in">  <?php echo $lista ['artsemi_descripcion'] . " (" . $lista ['artsemi_id'] . ")"; ?></span>
        <?php else: ?>
                                                                    <span class="label label-sm label-inverse arrowed-in">  <?php echo $lista ['artsemi_descripcion'] . " (" . $lista ['artsemi_id'] . ")"; ?></span>
                                                                    <span class="label label-sm label-info arrowed arrowed-righ">  <?php echo $lista ['artsemi_descripcion2'] . " (" . $lista ['artsemi_id2'] . ")"; ?></span>

                                                                <?php endif; ?>






                                                            </td>


        <?php if ($lista ['extot_peine'] == 0): ?>
                                                                <td class="hidden-480">
                                                                    <span class="label label-sm label-inverse arrowed-in">Simple</span>
                                                                </td>
        <?php else: ?>
                                                                <td class="hidden-480">
                                                                    <span class="label label-sm label-info arrowed arrowed-righ">Mixto</span>
                                                                </td>
        <?php endif; ?>

        <!--<td><?php // echo $lista ['are_titulo'];  ?></td>-->
        <!--<td><?php $fecha = new DateTime($lista ['extot_fecdoc']);
// echo $lista ['tur_titulo']; 
        ?></td>-->
        <!--<td><?php // echo $lista ['maq_nombre'];  ?></td>-->

                                                            <td><?php echo $fecha->format('Y-m-d'); ?></td>
                                                            <td><?php echo $lista ['extot_num_baj']; ?></td>
                                                            <td><?php echo $lista ['tur_titulo']; ?></td>


        <?php if ($lista ['estado'] == 0): ?>
                                                                <td class="hidden-480">
                                                                    <span class="label label-sm label-success">Activo</span>
                                                                </td>
        <?php else: ?>
                                                                <td class="hidden-480">
                                                                    <span class="label label-sm label-warning">Inactivo</span>
                                                                </td>
        <?php endif; ?>

                                                            <td><?php // echo $lista ['fecha_creacion']; ?>

                                                                <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                                                                     src="view/img/loadingV02.gif" class="loading-<?php echo $lista ['extot_id']; ?>" >
                                                                <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
        <?php if ($lista ['extot_alta'] != 1): ?> checked="checked" disabled="disabled"<?php else: ?> <?php endif; ?>
                                                                       id="aprobventas" data-aprobventas="<?php echo $lista ['extot_id']; ?>"

                                                                       />
                                                                <span class="lbl"></span>




                                                            </td>



                                                            <td> 
                                                                <div class="inline dropdown-hover">
                                                                    <a class="btn btn-minier btn-primary">
                                                                        OT Det.
                                                                        <i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
                                                                    </a>

                                                                    <ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
                                                                        <li class="active">

                                                                            <a  class="blue">
                                                                                <i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>
        <?php echo $lista ['are_titulo']; ?> (Area)
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a >
                                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
        <?php echo $lista ['pespro_descripcion']; ?> (Tubo)
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a >
                                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
        <?php echo $lista ['maq_nombre']; ?> (Máquina)
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a >
                                                                                <i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
        <?php echo $lista ['fecha_creacion']; ?> (Fec. Creación)
                                                                            </a>
                                                                        </li>


                                                                    </ul>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="hidden-sm hidden-xs action-buttons">

        <?php if (($id_usuario == '1') or ( $id_usuario == '2') or ( $id_usuario == '3') or ( $id_usuario == '9')): ?>
                                                                        <a class="blue"
                                                                           onclick=" false"  href="index.php?page=extordentrabajo&accion=verdetalleextordentrabajo&id=<?php echo $lista ['extot_id']; ?>&idmaq=<?php echo $lista ['maq_id']; ?>"
                                                                           >
                                                                            <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                                        </a>

                                                                        <a class="green" 
                                                                           onclick=" false"  href="index.php?page=extordentrabajo&accion=modificarextordentrabajo&id=<?php echo $lista ['extot_id']; ?>&idmaq=<?php echo $lista ['maq_id']; ?>"
                                                                           >
                                                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                                        </a>

                                                                        <a class="red" 
                                                                           id="bootbox-confirm"
                                                                           onclick=" false" href="index.php?page=extordentrabajo&accion=eliminar&id=<?php echo $lista ['extot_id']; ?>"
                                                                           >
                                                                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                        </a>

        <?php endif; ?>


                                                                    <a class="grey" 
                                                                       onclick=" false"  href="index.php?page=extordentrabajo&accion=RegistrarProducOT&id=<?php echo $lista ['extot_id']; ?>&idmaq=<?php echo $lista ['maq_id']; ?>"
                                                                       >
                                                                        <i class="ace-icon fa fa-list-alt bigger-130"></i>
                                                                    </a>



                                                                </div>

                                                                <div class="hidden-md hidden-lg">
                                                                    <div class="inline pos-rel">
                                                                        <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                            <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                                        </button>

                                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">

        <?php if (($id_usuario == '1') or ( $id_usuario == '2') or ( $id_usuario == '3') or ( $id_usuario == '9')): ?>
                                                                                <li>
                                                                                    <a  class="tooltip-info" data-rel="tooltip" title="Ver detalle"

                                                                                        onclick=" false" href="index.php?page=extordentrabajo&accion=verdetalleextordentrabajo&id=<?php echo $lista ['extot_id']; ?>&idmaq=<?php echo $lista ['maq_id']; ?>"

                                                                                        >

                                                                                        <span class="blue">
                                                                                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                                        </span>
                                                                                    </a>
                                                                                </li>

                                                                                <li>
                                                                                    <a class="tooltip-info" data-rel="tooltip" title="Editar"

                                                                                       onclick=" false" href="index.php?page=extordentrabajo&accion=modificarextordentrabajo&id=<?php echo $lista ['extot_id']; ?>&idmaq=<?php echo $lista ['maq_id']; ?>"

                                                                                       >
                                                                                        <span class="green">
                                                                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                                        </span>
                                                                                    </a>
                                                                                </li>

                                                                                <li>
                                                                                    <a class="tooltip-error" id="bootbox-confirm"
                                                                                       href="index.php?page=extordentrabajo&accion=eliminar&id=<?php echo $lista ['extot_id']; ?>"  data-rel="tooltip" title="Eliminar">
                                                                                        <span class="red">
                                                                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                                        </span>
                                                                                    </a>
                                                                                </li>
        <?php endif; ?>

                                                                            <li>
                                                                                <a class="tooltip-info" data-rel="tooltip" title="Reg. Produc."

                                                                                   onclick=" false" href="index.php?page=extordentrabajo&accion=RegistrarProducOT&id=<?php echo $lista ['extot_id']; ?>&idmaq=<?php echo $lista ['maq_id']; ?>"

                                                                                   >
                                                                                    <span class="grey">
                                                                                        <i class="ace-icon fa fa-list-alt bigger-120"></i>
                                                                                    </span>
                                                                                </a>
                                                                            </li>




                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" id="id_<?php echo $lista ['extot_id']; ?>" name="id_<?php echo $lista ['extot_id']; ?>" value="<?php echo $lista ['extot_id']; ?>" />  
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
                </div>

            </div>
        </div>
    </div>
</div>





<script src="assets/js/bootbox.js"></script>
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
                                                                                                   null, null, null, null, null, null, null, null, null, null,
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



                                                                                   $(document).on('click', '#dynamic-table .dropdown-toggle', function (e) {
                                                                                       e.stopImmediatePropagation();
                                                                                       e.stopPropagation();
                                                                                       e.preventDefault();
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
                                                                                   /***************/





                                                                                   /**
                                                                                    //add horizontal scrollbars to a simple table
                                                                                    $('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
                                                                                    {
                                                                                    horizontal: true,
                                                                                    styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
                                                                                    size: 2000,
                                                                                    mouseWheelLock: true
                                                                                    }
                                                                                    ).css('padding-top', '12px');
                                                                                    */


                                                                               })
</script>



