
                                  
                                       
                                 
<div class="col-sm-12" id="actualizarobs">
    
     <form action="">
                                                <div class="form-actions">
                                                        <div class="input-group">
                                                            <input placeholder="Escribe tu observaciòn aquí ..." type="text" id="obs" class="form-control" name="message" />
                                                            <input type="hidden" id="op" value="<?php echo $id;?>">
                                                            
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-sm btn-info no-radius" type="button" id="enviarobs">
                                                                                <i class="ace-icon fa fa-share"></i>
                                                                                Enviar
                                                                        </button>
                                                                </span>
                                                        </div>
                                                </div>
                                        </form>
        <div class="widget-box transparent">
                <div class="widget-header widget-header-flat">
                        <h4 class="widget-title lighter">
                                <i class="ace-icon fa fa-star orange"></i>
                                Observaciones realizadas
                        </h4>

                        <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-up"></i>
                                </a>
                        </div>
                </div>

                <div class="widget-body">
                        <div class="widget-main no-padding">
                                <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                                <tr>
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Usuario OBS
                                                        </th>

                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Observaciòn
                                                        </th>

                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Fecha Obs
                                                        </th>
                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Usuario Correg.
                                                        </th>
                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Fecha Correg.
                                                        </th>
                                                        <?php if ($vbpermiso ==  'produccion'): ?>
                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Corregir
                                                        </th>
                                                        <?php endif;?>
                                                        
                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Estado
                                                        </th>
                                                </tr>
                                        </thead>

                                        <tbody>
                                         
                                                
                                                <?php  if ($opedidos_obs):?>
                                                 <?php foreach ($opedidos_obs as $lista) : ?>
                                                 <tr>
                                                        <td> <?php echo $lista ["proobs_nickname_usr_obs"];?></td>

                                                        <td>
                                                                <b class="blue">    <?php echo $lista ["proobs_msn_obs"];?></b>
                                                        </td>

                                                        <td class="hidden-480">
                                                                 <?php echo $lista ["fecha_creacion_obs"];?>
                                                        </td>
                                                         <td>  <?php echo $lista ["proobs_nickname_usr_corrig"];?></td>
                                                        <td> <?php  if( $lista ["proobs_finalizado"] == '1'):?>
                                                              <?php echo $lista ["fecha_creacion_corrig"];?>
                                                            <?php else:?>
                                                        --
                                                            <?php endif;?>
                                                        
                                                        </td>
                                                        
                                                          <?php if ($vbpermiso ==  'produccion'): ?>
                                                        <td> 
                                                        
                                                            
                                                             <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo  $lista ['proobs_id']; ?>" >
                    <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                           <?php if ($lista ['proobs_finalizado'] == '1'): ?> checked="checked" <?php else: ?> <?php endif; ?>
                           id="idobs" data-idobs="<?php echo  $lista ['proobs_id']; ?>"
                           
                           />
                    <span class="lbl"></span>
                                                            
                                                            
                                                        </td>
                                                          <?php endif;?>
                                                        <td>  
                                                            <?php if ($lista ["proobs_finalizado"]== '0'):?>
                                                              <span class="label label-danger arrowed">Observado</span>
                                                             <?php else:?>
                                                                <span class="label label-success arrowed-in arrowed-in-right">Corregido</span>
                                                            <?php endif;?>
                                                        
                                                        </td>
                                                </tr>
                                                
                                                 <?php endforeach;?>
                                                 <?php endif; ?>
                                               

                                               
                                        </tbody>
                                </table>
                        </div><!-- /.widget-main -->
                </div><!-- /.widget-body -->
        </div>
    <!-- /.widget-box -->
</div><!-- /.col -->
