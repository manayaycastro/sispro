    <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<div class="col-sm-12" id="actualizarcomentarios">
                <div class="widget-box">
                        <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                        <i class="ace-icon fa fa-comment blue"></i>
                                        Conversation
                                </h4>
                        </div>

                        <div class="widget-body">
                                <div class="widget-main no-padding">
                                        <div class="dialogs">
                                               
                                                    <?php if($opedidos_coments): ?>
                                                     <?php foreach ($opedidos_coments as $lista): ?>
                                                     <div class="itemdiv dialogdiv">
                                                        <div class="user">
                                                                <img alt="Alexa's Avatar" src="assets/images/avatars/user.jpg" />
                                                        </div>

                                                        <div class="body">
                                                                <div class="time">
                                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                                        <?php $date = date_create($lista['fecha_creacion']) ?>
                                                                        <span class="green"> <?php echo date_format($date, 'd-m-Y H:i')?> </span>
                                                                </div>

                                                                <div class="name">
                                                                        <a href="#"><?php echo $lista['procoment_nickname_usuario'] ?> </a>
                                                                </div>
                                                                <div class="text"><?php echo $lista['procoment_mensaje'] ?> </div>

                                                                <div class="tools">
                                                                        <a href="#" class="btn btn-minier btn-info">
                                                                                <i class="icon-only ace-icon fa fa-share"></i>
                                                                        </a>
                                                                </div>
                                                        </div>
                                                    
                                                    </div>
                                                    
                                                   
                                                    <?php endforeach; ?>
                                                     <?php endif; ?>
                                                


                                        </div>

                                  
                                        <form action="">
                                                <div class="form-actions">
                                                        <div class="input-group">
                                                            <input placeholder="Escribe tu mensaje aquí ..." type="text" id="comentario" class="form-control" name="message" />
                                                            <input type="hidden" id="op" value="<?php echo $id;?>">
                                                            
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-sm btn-info no-radius" type="button" id="enviarcoment">
                                                                                <i class="ace-icon fa fa-share"></i>
                                                                                Enviar
                                                                        </button>
                                                                </span>
                                                        </div>
                                                </div>
                                        </form>
                                   
                                </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                </div><!-- /.widget-box -->
</div>


	