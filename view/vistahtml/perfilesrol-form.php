   <?php $a= 0;$b=0; ?>     
<form class="form-horizontal">
    <div class="tabbable">
        <ul class="nav nav-tabs padding-16">
        <?php if($menus):?>
        
        <?php foreach ($menus as $menu):?>
            <?php $a= $a+1;?>     
            <li  <?php if($a==1):?>   class="active"<?php endif;?> >    
                <a data-toggle="tab" href="#edit-<?php echo $menu['menu_id'];?>">
                    <i class="green ace-icon fa <?php echo $menu['ico_descripcion'];?> bigger-125"></i>
                   <?php echo $menu['titulo'];?>
                </a>
            </li>
        
        
        <?php endforeach;?>
        
        <?php endif;?>
            
            </ul>
        <!-- ----------------------------aqui comienza a listar los submenus  --------------------------------- -->
        <div class="tab-content profile-edit-tab-content">
  <?php  if($menus1):?>
        
        <?php foreach ($menus1 as $menu):?>
       <?php  $b= $b+1;?>
            <div id="edit-<?php echo $menu['menu_id'];?>" class="tab-pane <?php if($b==1):?> in active  <?php endif;?>">
               
                   
                 
                    <h4 class="header blue bolder smaller"><?php echo $menu['titulo'];?></h4>
                     
               
                
 <?php 
//               $menu = new Menu();
//              $submenus =$menu->getSubMenu($menu['menu_id']); ?>
               
                <?php if($submenus): ?>
                <?php foreach ($submenus as $submenu): ?>
                    <?php if($submenu['menu_id'] == $menu['menu_id']): ?>
             
                
                        <div class="space-20"></div>

                            <div>
                                <div class="col-sm-12">
                    <div class="col-sm-1">
                    
                     </div>
                    <div class="col-sm-11">
                     <label class="inline">
                                    <input id="<?php echo $submenu['submenu_id'];?>" type="checkbox" data-menu = "<?php echo $menu['menu_id'];?>" name="form-field-checkbox" class="ace" />
                                    <span class="lbl"> <?php echo $submenu['titulosub']; ?></span> 
                                </label>
                     </div>
                </div>
                               
                                
                            </div>

                            <div class="space-8"></div>


                     <?php endif; ?>
                        
                <?php endforeach; ?>
                <?php endif; ?>
                          
                           
           
            </div>

        <?php endforeach;?>
        
        <?php endif;?>
     </div>

    </div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Save
            </button>

            &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                Reset
            </button>
        </div>
    </div>
</form>