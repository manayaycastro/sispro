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
       action="index.php?page=parada&accion=insertar<?php if (!empty($_POST["id"])) : ?>&id=<?php echo $_POST["id"];
endif; ?>" method="POST">

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

                                    <select name="are_id" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($areas)): ?>
                                                <?php foreach ($areas as $area): ?>
                                                <option value="<?php echo $area ['are_id'] ?>" <?php if (!empty($_POST["id"])):if ($area ['are_id'] == $parada->getAre_id()): ?> selected <?php endif;
                                    endif; ?>>
                                                <?php echo $area['are_titulo']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else : ?>

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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Parada </label>

                                <div class="col-sm-9">

                                    <select name="tippar_id" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($paradatipos)): ?>
                                                <?php foreach ($paradatipos as $paradatipo): ?>
                                                <option value="<?php echo $paradatipo ['tippar_id'] ?>" <?php if (!empty($_POST["id"])):if ($paradatipo ['tippar_id'] == $parada->getTippar_id() ): ?> selected <?php endif;
                                    endif; ?>>
                                                <?php echo $paradatipo['tippar_titulo']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else : ?>

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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nombre  </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="Nombre" class="form-control"
                                           name="par_nombre"
                 <?php if (!empty($_POST["id"])) : ?> value="<?php echo $parada->getPar_nombre(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>

                            
                            
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Estado  </label>

                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label>
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="0"  class="ace" checked />
                                            <span class="lbl"> Activo</span>
                                        </label>
                                    </div>

                                    <div class="radio">
                                        <label>
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="1"  class="ace"  <?php if(!empty($_POST["id"])) : if($parada->getPar_estado()  == 1):?> checked <?php endif; endif; ?>/>
                                            <span class="lbl"> Inactivo</span>
                                        </label>
                                    </div>
                                </div>
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

        <button class="btn btn-sm btn-primary" <?php echo $permiso; ?>>
            <i class="ace-icon fa fa-check"></i>
            Guardar
        </button>
    </div>


</form>


