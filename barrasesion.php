


<div id="navbar" class="navbar navbar-default          ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

        <div class="navbar-header pull-left">
            <a href="index.php" class="navbar-brand">


                <i class="icon-plus-sign  white home-icon  "></i>
                <span class="white"><strong>El Águila S.R.L.</strong></span>
                <span class="white">Application</span>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">


                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="assets/images/avatars/user.jpg" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>Bienvenido ,</small>
                            <?php echo $_SESSION['usuario'] ?> 
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="index.php?page=usuario&accion=cambioclave">
                              <i class="ace-icon fa fa-cog"></i>
                                Cambio Clave
                            </a>
                        </li>

                        <li>
                            <a href="#">
                              <i class="ace-icon fa fa-user"></i>
                                Mi Perfil
                            </a>
                        </li>

                        <li class="divider"></li>


                        <li>
                            <a href="index.php?page=login&accion=cerrar">
                              <i class="ace-icon fa fa-power-off"></i>
                                Salir
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.navbar-container -->
</div>
