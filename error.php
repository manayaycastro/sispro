<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ERROR</title>
        <link href="view/css/bootstrap.css" rel="stylesheet">
        <link href="view/css/custom.css" rel="stylesheet">
        <!-- scripts  -->
        <script type="text/javascript" src="view/scripts/jquery.min.js"></script> 
        <script type="text/javascript" src="view/js/bootstrap.js"></script>
    </head>
    <body>
        <?php
        include './nav-bar.php';
        ?>
        <div class="container">
            <?php  if(!empty($_GET["mssg"])) :?>
            <div id="caplock" class="alert alert-danger">
                <strong>ERROR! </strong><?php echo $_GET["mssg"] ?>}
            </div>
            <?php endif; ?>
        </div>
    </body>
    aa
</html>

