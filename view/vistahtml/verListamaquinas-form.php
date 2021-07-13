    <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <div class="col-sm-12" id="actualizarDisponibilidad">


	  <input type="hidden" name="estado" id="estado" value="<?php echo $estado; ?>">
            <input type="hidden" name="items" id="items" value="<?php echo $items; ?>">
	 <input type="hidden" name="artsemi" id="artsemi" value="<?php echo $artsemi; ?>">

        <input type="hidden" name="op" id="op" value="<?php echo $op; ?>">
        <input type="hidden" name="codart" id="codart" value="<?php echo $codart; ?>">
        <input type="hidden" name="idkanban2" id="idkanban2" value="<?php echo $idkanban; ?>">
         <input type="hidden" name="mtrs" id="mtrs" value="<?php echo $mtrs; ?>">
          <input type="hidden" name="area" id="area" value="<?php echo $area; ?>">
                                 <input id="proceso" type="hidden" name="proceso" value="<?php echo $proceso; ?>" >
          
      
        <div class="widget-body">
            <div class="widget-main no-padding">


                <div class="col-sm-4">
                    <div class="">
                        <h3 class=" text-primary  blue">Fecha de Disponibilidad 
<!--                            <a class="btn btn-info pull-right" role="button" href="#formulario-registro" id="btnAgregarActividad" data-toggle="modal">
                                <i class="icon-plus icon-on-left bigger-110"> </i>Actividad</a>-->
                        </h3>
                              <!--<input  type="hidden" id="dependenciaActual" name="dependenciaActual" value="" />-->
                        <hr>

                        <table class="table table-bordered table-striped table-condensed table-hover" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>Cod</th>
                                    <th>Telar</th>
                                     <th>Fec. Disp.</th>
                                    <th>Programar</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php if($listamaquinas): ?>
                                 <?php foreach ($listamaquinas as $lista):?>
                                <tr class="maquinalista" 
                                    data-idtelar="<?php echo $lista['maq_id']; ?>"
                                    >
                                    <td>
                                         <?php echo $lista['maq_id']." (Vo= ".$lista['artsemimaq_velinicial']." m/s)"; ?>
                                    </td>
                                    <td>
                                          <?php echo $lista['maq_nombre']; ?>
                                    </td>
                                    <td>
										<?php    $fecha = new DateTime($lista['fecha_disponible']);?>
										<?php    $fecha_hora =  $fecha->format('Y-m-d H:i');?>
										
                                          <?php echo $fecha_hora; ?>
                                         <?php echo $lista['turno']; ?>
                                    </td>
                                    <td>
                                        <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                                                     src="view/img/loading.gif" class="loading-<?php echo $lista ['maq_id']; ?>" >
                                                <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                                                    
                                                       id="maq_id" data-maq_id="<?php echo $lista ['maq_id']; ?>"

                                                       />
                                                <span class="lbl"></span>
                                                 <input type="hidden" name="fecdisp-<?php echo $lista ['maq_id']; ?>" id="fecdisp-<?php echo $lista ['maq_id']; ?>" value="<?php  echo $lista['fecha_disponible']; ?>">
                                    <input type="hidden" name="maqdisp-<?php echo $lista ['maq_id']; ?>" 
                                           id="maqdisp-<?php echo $lista ['maq_id']; ?>" 
                                           <?php if ($lista['fecdispmaq_id'] == null):?>
                                            value="0"
                                            <?php else:?>
                                             value="1"
                                            <?php endif;?>
                                          
                                          
                                           
                                           >
                                    
                                    
                                    </td>
                                    
                                </tr>
                                 <?php endforeach;?> 
                                 <?php else : ?>
                <?php echo '<div class="alert alert-warning">No se encontraron registros.</div>'; ?>
                                 <?php endif;?>
                                
                            </tbody>
                        </table>
                         <div class="space-18"></div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="">
                        <h3 class="text-primary  blue">Ver detalle de Ocupación
<!--                            <a class="btn btn-info pull-right" href="#formulario-turnos" id="btnAgregarTurno">
                                <i class="icon-plus icon-on-left bigger-110"> &nbsp;Turno / Guardia</i></a>-->
                        </h3>
                        <input type="hidden" id="actividadDependenciaActual" name="actividadDependenciaActual" value="" />
                        <hr>
                        <table class="table table-bordered table-striped table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th>Pedido(Kanban)</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Duración</th>
                                    <th>Metros</th>
                                    <th>Estado</th>
                                     <th>+</th>
                                </tr>
                            </thead>
                            <tbody id="ajax_ocupacionmaq"></tbody>
                        </table>
                    </div>
                </div>   





            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->


    </div>




