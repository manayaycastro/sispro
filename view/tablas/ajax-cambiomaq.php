
<?php
if (!isset($listaprocesos)) {// revisar
    require_once '../../model/planificacion.php';
        require_once '../../model/maquinas.php';
    require_once '../../controller/class.inputfilter.php';
    session_start();
    $filter = new InputFilter();
    ini_set('date.timezone', 'America/Lima');
//  $rango=''; maquina
//    if(isset($_REQUEST['rango'])) { ,area:$( "#area").val()

    $procesos = $filter->process($_REQUEST['procesos']);
    $ops_abierta = $filter->process($_REQUEST['ops_abierta']);

//    }    


//$maquinas = new maquinas();


    $planificacion = new planificacion();

    $listaOPs = $planificacion->ListarKanbanXproceso($ops_abierta, $procesos);
    $listamaquina = $planificacion->consultarMaqXproceso($procesos);
}
?> 
  <script src="assets/js/autosize.min.js"></script>
<div class="widget-body">
    <div class="widget-main">

        <div class="row">
            <div class="col-xs-12">
                <h3 class="header smaller lighter blue">Lista según siguiente filtro <?php echo ''; ?> </h3>
                <div class="clearfix">
                    <div class="pull-right tableTools-container"></div>
                </div>
                <div class="table-header">
                    Resultados
                </div>

                <input id ="procesos" type="hidden" value="<?php echo $procesos; ?>">

                <input id ="ops_abierta" type="hidden" value="<?php echo $ops_abierta; ?>">


                <table id="dynamic1-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center">
                                <label class="pos-rel">
                                    <input type="checkbox" class="ace" />
                                    <span class="lbl"></span>
                                </label>
                            </th>

                            <th>Kanban (OP)</th>
                            <th class="hidden-480"> Máquina Origen </th>
                            <th>Máquina Destino</th>
                            <th>Motivo</th>
                            <th>Acción</th>

                        </tr>
                    </thead>

                    <tbody>

<?php if (count($listaOPs)): ?>
    <?php foreach ($listaOPs as $lista): ?>
                                <tr>
                                    <td class="center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $lista ['movdismaq_idkanban'] . "  (" . $lista ['movdismaq_numped'] . ")"; ?></td>






                                    <td><?php echo $lista ['maq_nombre']; ?></td>

                                    <td><?php // echo $lista ['movdismaq_maqid']; ?>
                                  

                                                               
                                    <select name="maq_detino-<?php echo $lista ['movdismaq_id']; ?>" class="chosen-select form-control" id="maq_detino-<?php echo $lista ['movdismaq_id']; ?>" data-placeholder="Choose a State...">

                                        <?php if (count($listamaquina)): ?>
                                            <?php foreach ($listamaquina as $lista2): ?>
                                                <option value="<?php echo $lista2 ['maq_id'] ?>" 

                                                        >
                                                            <?php echo $lista2 ['maq_nombre']; ?>
                                                </option>
                                            <?php endforeach; ?>

                                        <?php endif; ?>
                                    </select>
                                                                                         
                                                                                 
                                    
                                    
                                    
                                    </td>


                                    <td><?php //echo $lista ['movdismaq_maqid']; ?>
                                    <textarea id="motivo-<?php echo $lista ['movdismaq_id']; ?>"  name ="motivo-<?php echo $lista ['movdismaq_id']; ?>" class="autosize-transition form-control"></textarea>
                                    
                                    </td>




                                    <td >
                                        <div class="hidden-sm hidden-xs action-buttons">
                                                 <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                                    src="view/img/loadingV02.gif" class="loading-<?php echo  $lista ['movdismaq_id']; ?>" >
                                    <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                                    <?php if ($lista ['movdismaq_atendido'] == '1'): ?> checked="checked" disabled="disabled" <?php else: ?> <?php endif; ?>
                                    id="cambiomaq" data-cambiomaq="<?php echo  $lista ['movdismaq_id']; ?>"

                                    />
                                    <span class="lbl"></span>

                                            <input id ="op-<?php echo $lista ['movdismaq_id']; ?>" type="hidden" value="<?php echo $lista ['movdismaq_numped']; ?>">
                                            <input id ="maqori-<?php echo $lista ['movdismaq_id']; ?>" type="hidden" value="<?php echo $lista ['movdismaq_maqid']; ?>">
                                            <input id ="kanban-<?php echo $lista ['movdismaq_id']; ?>" type="hidden" value="<?php echo $lista ['movdismaq_idkanban']; ?>">
                                            <input id ="artsemi-<?php echo $lista ['movdismaq_id']; ?>" type="hidden" value="<?php echo $lista ['artsemi_id']; ?>">
                                            <input id ="fecdispo-<?php echo $lista ['movdismaq_id']; ?>" type="hidden" value="<?php echo $lista ['fecdispmaq_fechadisp']; ?>">
                                               <input id ="mtrs-<?php echo $lista ['movdismaq_id']; ?>" type="hidden" value="<?php echo ROUND ($lista ['movdismaq_mtrs']); ?>">   
                                        </div>

                                        <div class="hidden-md hidden-lg">
                                            <div class="inline pos-rel">
                                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                    <li>

                                                    </li>


                                                </ul>
                                            </div>
                                        </div>
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
</div>





<script type="text/javascript">
    jQuery(function ($) {
        //initiate dataTables plugin
        var myTable1 =
                $('#dynamic1-table')
                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                .DataTable({
                    bAutoWidth: false,
                    "aoColumns": [
                        {"bSortable": false},
                        null, null, null, null,
                        {"bSortable": false}
                    ],
                    "aaSorting": [],
                    select: {
                        style: 'multi'
                    }
                });



        $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

        new $.fn.dataTable.Buttons(myTable1, {
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
        myTable1.buttons().container().appendTo($('.tableTools-container'));

        //style the message box
        var defaultCopyAction = myTable1.button(1).action();
        myTable1.button(1).action(function (e, dt, button, config) {
            defaultCopyAction(e, dt, button, config);
            $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
        });


        var defaultColvisAction = myTable1.button(0).action();
        myTable1.button(0).action(function (e, dt, button, config) {

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




        $(document).on('click', '#dynamic1-table .dropdown-toggle', function (e) {
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

    
           autosize($('textarea[class*=autosize]'));

            $(document).one('ajaxloadstart.page', function (e) {
                                    autosize.destroy('textarea[class*=autosize]')

                                    $('.limiterBox,.autosizejs').remove();
                                    $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
                                });

    })
</script>

