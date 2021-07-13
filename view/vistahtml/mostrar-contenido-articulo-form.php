<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($detalle)):
    ?>
    <?php foreach ($detalle as $lista): ?>
        <tr>
            <td>  <?php echo $lista['nroped']; ?></td>
             <td>  <?php echo $lista['codart']; ?></td>
              <td>  <?php echo $lista['desart']; ?></td>
               <td>  <?php echo $lista['cantped']; ?></td>
               <td>  <?php echo $lista['razonsocial']; ?></td>
               
                <td> 
                
                <a class="blue" onclick=" false" href="#" data-diseno=" <?php echo $lista['codart']; ?>" id="mostrardiseno">
                                     <!--href="index.php?page=opedido&accion=mostrarnotaped&id="-->
                                    <i class="ace-icon glyphicon glyphicon-file bigger-120"></i>
                                </a>
                
                
                </td>
               
                <td> 
                
                <a class="blue" onclick=" false" href="#" data-claseb=" <?php echo $lista['codart']; ?>" id="mostrarclaseb">
                                     <!--href="index.php?page=opedido&accion=mostrarnotaped&id="-->
                                    <i class="ace-icon glyphicon glyphicon-zoom-in bigger-120"></i>
                                </a>
                               
                
                </td>




        <!--aqui hoy ********************************************************************************-->

        </tr>


    <?php endforeach; ?>

<?php endif; ?>


?>
