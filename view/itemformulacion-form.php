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
       action="index.php?page=itemformulacion&accion=insertar<?php if (!empty($_POST["id"])) : ?>&id=<?php echo $_POST["id"];
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
                        <div class="col-xs-12 col-sm-8">



                            

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nombre  </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="Nombre" class="form-control"
                                           name="itemform_descripcion"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $itemform->getItemform_descripcion(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Posición </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="Posición" class="form-control" 
                                           name="itemform_pocision"
<?php if (!empty($_POST["id"])) : ?> value="<?php echo $itemform->getItemform_pocision(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>

                            
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Semit. </label>

                                <div class="col-sm-9">

                                    <select name="tipsem_id" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($semiterminados)): ?>
                                                    <?php foreach ($semiterminados as $semit): ?>
                                                <option value="<?php echo $semit ['tipsem_id'] ?>" <?php if (!empty($_POST["id"])):if ($semit ['tipsem_id'] == $itemform->getTipsem_id()): ?> selected <?php endif;
                                                                                                                             endif;
                                                        ?>>
                                                <?php echo $semit['tipsem_titulo']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else : ?>

                                                <?php foreach ($semiterminados as $semit): ?>
                                                    <option value="<?php echo $semit ['tipsem_id'] ?>" >
                                                    <?php echo $semit ['tipsem_titulo']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Clase </label>

                                <div class="col-sm-9">

                                    <select name="clasem_id" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($clasifsemiterminado)): ?>
                                                    <?php foreach ($clasifsemiterminado as $clasifsemit): ?>
                                                <option value="<?php echo $clasifsemit ['clasem_id'] ?>" <?php if (!empty($_POST["id"])):if ($clasifsemit ['clasem_id'] == $itemform->getClasem_id()): ?> selected <?php endif;
                                                                                                                             endif;
                                                        ?>>
                                                <?php echo $clasifsemit['clasem_titulo']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else : ?>

                                                <?php foreach ($clasifsemiterminado as $clasifsemit): ?>
                                                    <option value="<?php echo $clasifsemit ['clasem_id'] ?>" >
                                                    <?php echo $clasifsemit ['clasem_titulo']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
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
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="1"  class="ace"  <?php if (!empty($_POST["id"])) : if ($itemform->getItemform_estado()  == 1): ?> checked <?php endif;
endif; ?>/>
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


