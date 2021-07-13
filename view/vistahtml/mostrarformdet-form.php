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
            
            <td>  <?php echo $lista ['itemform_id2']; ?></td>
             <td>  <?php echo $lista ['itemform_descripcion']; ?></td>
              <td>  <?php echo $lista ['itemform_pocision']; ?></td>
               <td>  
               
               <center>
                <div class="control-group " >

                    <div class="controls">
                        <input type="text" required="required" style="width: 140px; height:32px"  <?php if( $lista ['estado'] == '0'): ?> readonly="readonly"  <?php else: ?> <?php endif;?>
                              class=" valorform" id = "valor-<?php echo  $lista ['itemform_id2']; ?>"  onkeyup="sumaform();"
                               value="<?php echo $lista ['valitemform_valor']; ?>" autocomplete="off" autofocus>
                    </div>
                </div>
            </center>
               
               </td>
                <td> 
                <center>
                    <label>
                <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo $lista ['itemform_id2']; ?>" >
                <input type='checkbox'  <?php if( $lista ['estado'] == '0'): ?>  checked="checked"  disabled="disabled"<?php else: ?> <?php endif;?>
                       class="ace" id="insertarform" data-estado="<?php echo $lista ['itemform_id2']; ?>" ><span class="lbl"></span>
                    <input type="hidden" id="idform<?php echo $lista ['itemform_id2']; ?>" name="idform<?php echo $lista ['itemform_id2']; ?>" value="<?php echo $id_form; ?>" /> 
            </label>
          
           
          

                </center>
                </td>
       




        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>

 <tr >
            <td colspan ="3">
                   ---------> Sumatoria Total
            </td>
            <td>
        <center>
                <div class="control-group " >
                <div class="controls">
                    <!--<span>El resultado es: </span> <span id="spTotal"></span>-->
                    
                     <input type="text" required="required" style="width: 140px; height:32px"
                            id = "sumaform"  
                           autocomplete="off" autofocus>
                </div>
                    </div>
            </center>
            </td>
             <td colspan ="2">
            </td>
        </tr>
?>