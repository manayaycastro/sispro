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
       action="index.php?page=submenu&accion=insertar<?php if(!empty($_POST["id"])) :?>&id=<?php echo $_POST["id"]; endif; ?>" method="POST">

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
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Menu </label>

                                <div class="col-sm-9">
                                    
                                    <select name="menu" class="chosen-select form-control" <?php echo $permiso; ?> id="form-field-select-3" data-placeholder="Choose a State...">
                                                              <?php if (count($menus)): ?>
                                                            <?php foreach ($menus as $menu): ?>
                                                                <option value="<?php echo $menu ['menu_id'] ?>" <?php if(!empty($_POST["id"])):if($menu ['menu_id'] == $submenu->getMenu_id()): ?> selected <?php endif; endif; ?>>
                                                                    <?php echo $menu['titulo']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php else : ?>
                                                      
                                                            <?php foreach ($menus as $menu): ?>
                                                                <option value="<?php echo $menu ['menu_id'] ?>" >
                                                                    <?php echo $menu ['titulo']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                        </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Sub menu  </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="Nombre del Submenu" class="form-control"
                                            name="submenu"
                                           <?php if(!empty($_POST["id"])) :?> value="<?php echo  $submenu->getTitulosub(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Enlace </label>

                                <div class="col-sm-9">
                                    <input type="text" id="form-field-1-1" required="required" placeholder="enlace" class="form-control" 
                                           name="enlacesub"
                                           <?php if(!empty($_POST["id"])) :?> value="<?php  echo $submenu->getEnlacesub(); ?>"<?php endif; ?> <?php echo $permiso; ?>
                                           />
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


