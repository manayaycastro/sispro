<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;
?>


<?php ?>

<form  class="form-horizontal" role="form" 
       action="index.php?page=parada&accion=insertarreg" method="POST">

    <div class="modal-body">
        <div class="widget-box">
            <div class="widget-header widget-header-small">
                <h5 class="widget-title lighter">Ingresar Datos</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <div class="row">
                        <div class="col-xs-12 col-sm-8">

  <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Área </label>

                                <div class="col-sm-9">

                                    <select name="are_id" class="chosen-select form-control"  id="form-field-select-3" data-placeholder="Choose a State...">
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

                                    <select name="maq_id" class="chosen-select form-control"  id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($maquinas)): ?>
                                      
                                                <?php foreach ($maquinas as $item): ?>
                                                <option value="<?php echo $item ['maq_id'] ?>" >
                                                <?php echo $item ['maq_nombre']; ?>
                                                </option>
    <?php endforeach; ?>
<?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Parada </label>

                                <div class="col-sm-9">

                                    <select name="tippar_id" class="chosen-select form-control"  id="form-field-select-3" data-placeholder="Choose a State...">
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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Parada </label>

                                <div class="col-sm-9">

                                    <select name="par_id" class="chosen-select form-control"  id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($paradas)): ?>
                                      
                                                <?php foreach ($paradas as $parada): ?>
                                                <option value="<?php echo $parada ['par_id'] ?>" >
                                                <?php echo $parada ['par_nombre']; ?>
                                                </option>
    <?php endforeach; ?>
<?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                           

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nombre  </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="Observación" class="form-control"
                                           name="parreg_obs"
                 
                                           />
                                </div>
                            </div>

                            
                                 <label for="date-timepicker1">Date/Time Picker</label>

                                                        <div class="input-group">
                                                            <input id="date-timepicker1" type="text" class="form-control" />
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-clock-o bigger-110"></i>
                                                            </span>
                                                        </div>
                          
                            
                               <div class="input-group bootstrap-timepicker">
                                                            <input id="timepicker1" type="text" class="form-control" />
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

    <div class="space-18"></div>

    <div class="modal-footer">
        <button class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
            Cancelar
        </button>

        <button class="btn btn-sm btn-primary" >
            <i class="ace-icon fa fa-check"></i>
            Guardar
        </button>
    </div>


</form>


