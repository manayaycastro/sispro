<?php
require_once 'model/usuarios.php';
require_once 'model/menu.php';
$oUsuario = new Usuario();
$id_usuario = $_SESSION['idusuario'];


$perfil = $_SESSION['perusuario'];
// echo $_SESSION['perusuario'];

$menu = new menu();

$menus_del_usuario = $menu->getPorPerfil($perfil);

$active = 0;
$menu_permitido = array();
foreach ($menus_del_usuario as $menu_del_usuario) {

    $menu_permitido[] = $menu_del_usuario ['menu_id'];
}
?>
 <script src="assets/js/ace.min.js"></script>
 <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

<div id="sidebar" class="sidebar responsive ace-save-state">
<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>


    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </button>

            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->


    <ul class="nav nav-list">

        <?php foreach ($menu->getMenu() as $m): ?>
        
            <?php if (in_array($m['menu_id'], $menu_permitido) == true): ?>
                <?php $active++;?>
        <!--variable para que aparesca donde esta el menu actualmente   $active-->
        <li <?php  if($active=='1'):?> class="active"   <?php else: ?> class=""    <?php endif; ?>>
                    <a href="<?php echo $m['enlace']; ?>" class="dropdown-toggle" >
                        <i class="menu-icon fa <?php echo $m['ico_descripcion']; ?>" ></i>
                        <span class="menu-text"> <?php echo $m['titulo']; ?> </span>

                     <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                   
                    <ul class="submenu">
                        <?php foreach ($menu->getSubMenu($m['menu_id']) as $s): ?>
                            <?php if ($menu->Subsubmenucount($s['submenu_id'])): ?> 
                                <?php foreach ($menu->Subsubmenucount($s['submenu_id']) as $cant): ?>
                                    <?php $cant2 = $cant[0]; ?>
                                    <?php if ($cant2 > 0): ?>

                                        <li class="" >
                                            <a href="<?php echo $s['enlacesub']; ?>" class="dropdown-toggle">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                            
                                                <?php echo $s['titulosub']; ?>
                                                  <b class="arrow fa fa-angle-down"></b>
                                            </a>
                                            <b class="arrow"></b>
                                            <?php if ($menu->Subsubmenucount($s['submenu_id'])): ?>
                                                <?php foreach ($menu->Subsubmenucount($s['submenu_id']) as $cant): ?>
                                                    <?php $cant1 = $cant[0]; ?>
                                                    <?php if ($cant1 > 0): ?>

                                                        <ul class="submenu nav-show">
                                                            <?php foreach ($menu->Subsubmenu($s['submenu_id']) as $ssm) : ?> 
                                                                <li > 
                                                                    <a href="<?php echo $ssm['sub_enlacesub']; ?>"  >
                                                                        <i class="menu-icon fa fa-caret-right"></i>
                                                                        <?php echo $ssm['sub_titulosub']; ?>
                                                                    </a>
                                                                </li>	

                                                            <?php endforeach; ?> 

                                                        </ul>
                                                    <?php endif; ?>
                                                <?php endforeach; ?> 
                                            <?php endif; ?>
                                        </li>

                                    <?php else: ?> 
                                        <li > <a href="<?php echo $s['enlacesub']; ?>"> <i class="menu-icon fa fa-caret-right"></i><?php echo $s['titulosub']; ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?> 
                            <?php endif; ?> 
                        <?php endforeach; ?>
                    </ul>

                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
	<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    

</div>

