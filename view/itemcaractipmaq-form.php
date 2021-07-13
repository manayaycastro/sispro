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
       action="index.php?page=itemcaractipmaq&accion=insertar<?php if (!empty($_POST["id"])) : ?>&id=<?php echo $_POST["id"];
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
                                           name="itemcaractipmaq_descripcion"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $itemcaractipmaq->getItemcaractipmaq_descripcion(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Posición </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="Posición" class="form-control" 
                                           name="itemcaractipmaq_pocision"
<?php if (!empty($_POST["id"])) : ?> value="<?php echo $itemcaractipmaq->getItemcaractipmaq_pocision(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>

                            
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Semit. </label>

                                <div class="col-sm-9">

                                    <select name="tipmaq_id" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($tipomaquina)): ?>
                                                    <?php foreach ($tipomaquina as $tipmaq): ?>
                                                <option value="<?php echo $tipmaq ['tipmaq_id'] ?>" <?php if (!empty($_POST["id"])):if ($tipmaq ['tipmaq_id'] == $itemcaractipmaq->getTipmaq_id()): ?> selected <?php endif;
                                                                                                                             endif;
                                                        ?>>
                                                <?php echo $tipmaq['tipmaq_titulo']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else : ?>

                                                <?php foreach ($tipomaquina as $tipmaq): ?>
                                                    <option value="<?php echo $tipmaq ['tipmaq_id'] ?>" >
                                                    <?php echo $tipmaq ['tipmaq_titulo']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Clase </label>

                                <div class="col-sm-9">

                                    <select name="clatipmaq_id" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                        <?php if (count($clasiftipmaquina)): ?>
                                                    <?php foreach ($clasiftipmaquina as $clasif): ?>
                                                <option value="<?php echo $clasif ['clatipmaq_id'] ?>" <?php if (!empty($_POST["id"])):if ($clasif ['clatipmaq_id'] == $itemcaractipmaq->getClatipmaq_id()): ?> selected <?php endif;
                                                                                                                             endif;
                                                        ?>>
                                                <?php echo $clasif['clatipmaq_titulo']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else : ?>

                                                <?php foreach ($clasiftipmaquina as $clasif): ?>
                                                    <option value="<?php echo $clasif ['clatipmaq_id'] ?>" >
                                                    <?php echo $clasif ['clatipmaq_titulo']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tipo Dato </label>

                                <div class="col-sm-9">

                                    <select name="itemcaractipmaq_tipodato" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                       <option value="_caja" <?php if (!empty($_POST["id"])):if ("_caja" == $itemcaractipmaq->getItemcaractipmaq_tipodato()): ?> selected <?php endif; endif; ?>>
                                              Caja de Texto
                                                </option>
                                       <option value="_combo" <?php if (!empty($_POST["id"])):if ("_combo" == $itemcaractipmaq->getItemcaractipmaq_tipodato()): ?> selected <?php endif; endif; ?>>
                                              Combo - Select
                                                </option>
                                           
                                       
                                     
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tabla  </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="tabla" class="form-control"
                                           name="itemcaractipmaq_tabla"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $itemcaractipmaq->getItemcaractipmaq_tabla(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> ID Tabla</label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder=" id tabla" class="form-control"
                                           name="itemcaractipmaq_tabla_id"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $itemcaractipmaq->getItemcaractipmaq_tabla_id(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">Nomb. Tabla</label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="nombre tabla" class="form-control"
                                           name="itemcaractipmaq_tabla_descripcion"
                                           <?php if (!empty($_POST["id"])) : ?> value="<?php echo $itemcaractipmaq->getItemcaractipmaq_tabla_descripcion(); ?>"<?php endif; ?> <?php echo $permiso; ?>
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
                                            <input name="optionsRadios" type="radio"  <?php echo $permiso; ?>  value="1"  class="ace"  <?php if (!empty($_POST["id"])) : if ($itemcaractipmaq->getItemcaractipmaq_estado() == 1): ?> checked <?php endif;
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


