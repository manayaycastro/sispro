

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
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Tipo Producto
                                                                                                    </th>

                                                                                                    <th>
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Producción
                                                                                                    </th>

                                                                                                    <th class="hidden-480">
                                                                                                        <i class="ace-icon fa fa-caret-right blue"></i>Pendiente
                                                                                                    </th>



                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>
                                                                                                 <tr>
            <td>  <?php echo $tipo; ?></td>
             <td>  
              <select name="kanban"   id="kanban" class="chosen-select form-control">

                                                                   
                                                                    <?php if (count($pucho)): ?>
                                                                        <?php foreach ($pucho as $lista): ?>
                                                                            <option value="<?php echo $lista ['prefila_id'] ?>" >
                                                                                <?php echo $lista ['prefila_kanban']; ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
             
             
             </td>
              <td>  
                  
                  <input  type="text" readonly="readonly" id="suma"  value="0">
                  <input  type="hidden"  id="op"  value="<?php echo $op;?>">
                      <input  type="hidden"  id="tipo"  value="<?php echo $tipo;?>">
                </td>
        

        </tr>
                                                                                                <?php

$a = 0;


if (count($pucho)):
    ?>
    <?php foreach ($pucho as $lista): ?>
        <tr>
            <td>  <?php echo $lista['prefila_tipo']; ?></td>
             <td>  <?php echo $lista['prefila_cantidad_fin']; ?></td>
              <td>  
                  
                  <input class="sumar" type="text" onkeyup="sumaform();" id="<?php echo $lista['prefila_id']; ?>" name="descontar[]" value="0">
                  <input  type="hidden"  name="prefila_id[]" value="<?php echo $lista['prefila_id']; ?>">
                </td>
 
        </tr>


    <?php endforeach; ?>

<?php endif; ?>
       

                                                                                                
                                                                                                
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div><!-- /.widget-main -->
                                                                                </div><!-- /.widget-body -->
                                                                            </div>

</div>
 


    <script type="text/javascript">


            function sumaform() {

                var total = 0;

                $(".sumar").each(function () {

                    if (isNaN(parseFloat($(this).val()))) {

                        total += 0;

                    } else {

                        total += parseFloat($(this).val());

                    }

                });

//alert(total);
//                document.getElementById('spTotal').innerHTML = total;
                document.getElementById("suma").value = total.toFixed(2);
                
                

            }

        </script>
        




