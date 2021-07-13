<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$a = 0;


if (count($disenos)):
    ?>
    <?php foreach ($disenos as $diseno): ?>
<iframe
id="inlineFrameExample"
    title="Inline Frame Example"
    width="100%"
    height="200%"
    src="<?php echo $diseno["prodidet_url"]; ?>"
    
    style="height: 580px;">
</iframe>
    



    <?php endforeach; ?>

<?php else: ?>

NO se ah cargado imagen alguna!!
<?php endif; ?>
 

