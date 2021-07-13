<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($listar)):
    ?>
    <?php foreach ($listar as $lista): ?>
        <tr>
            <td>  <?php echo $lista ['maqmetdet_id']; ?></td>
             <td>  <?php echo $lista ['maqmetdet_anio']; ?></td>
              <td>  <?php echo $lista ['nombre_mes']; ?></td>
               <td>  
               
               <center>
                <div class="control-group " >

                    <div class="controls">
                        <input type="text" required="required" style="width: 140px; height:32px"
                               class=" form-control" id = "valormensual-<?php echo  $lista ['maqmetdet_id']; ?>"  
                               value="<?php echo round( $lista ['maqmetdet_valor'],0); ?>" autocomplete="off" autofocus>
                    </div>
                </div>
            </center>
               
               </td>
                <td> 
                <center>
                    <label>
                <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo $lista ['maqmetdet_id']; ?>" >
                <input type='checkbox'  <?php if( $lista ['estado'] == '0'): ?>  checked="checked"  <?php else: ?> <?php endif;?>
                       class="ace" id="agregarEstado" data-estado="<?php echo $lista ['maqmetdet_id']; ?>" ><span class="lbl"></span>

            </label>
          
           
              <input type="hidden" id="sesion" name="sesion" value="<?php echo $_SESSION['idusuario']; ?>" /> 
                </center>
                </td>
       




        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>


?>