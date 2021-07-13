<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($opedidos)):
    ?>
    <?php foreach ($opedidos as $opedido): ?>
<iframe
id="inlineFrameExample"
    title="Inline Frame Example"
    width="100%"
    height="200%"
    src="index.php?page=opedido&accion=mostrarnotaped&id=<?php echo $opedido["NROPED"]; ?>"
    
    style="height: 580px;">
</iframe>
    



    <?php endforeach; ?>

<?php endif; ?>
 

