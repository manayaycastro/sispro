

<div id="actualizaragruppucho">
    
     <div class="widget-box transparent">
                                                                                <div class="widget-header widget-header-flat">
                                                                                    <h4 class="widget-title lighter">
                                                                                        <i class="ace-icon fa fa-star orange"></i>
                                                                                       Saldos pendientes
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
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Código Principal
                                                                                                    </th>
                                                                                                     <th>
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Tipo
                                                                                                    </th>

                                                                                                    <th>
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Codigo Clase B
                                                                                                    </th>

                                                                                                    <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Descripción clase B
                                                                                                    </th>



                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>
                                                                                         
                                                                                                <?php

$a = 0;


if (count($claseb_lista)):
    ?>
    <?php foreach ($claseb_lista as $lista): ?>
        <tr>
            <td>  <?php echo $lista['form_id']; ?></td>
              <td>  <?php echo $lista['tipo']; ?></td>
             <td>  <?php echo $lista['codigofin']; ?></td>
                <td>  <?php echo $lista['descripcion']; ?></td>
             
        </tr>


    <?php endforeach; ?>

<?php endif; ?>
       

                                                                                                
                                                                                                
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div><!-- /.widget-main -->
                                                                                </div><!-- /.widget-body -->
                                                                            </div>

</div>
 



