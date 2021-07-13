

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 ?>
  <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

  <div class="col-sm-12" id="actualizar">
  
    <div class="col-sm-12" id="cargando"></div>
    <form  class="form-horizontal" role="form"  
           method="post">

    <div class="modal-body">
        <div class="widget-box">
            <div class="widget-header widget-header-small">
                <h5 class="widget-title lighter">Ingresar Datos</h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <div class="row">

                        <div class="col-xs-12 col-sm-4">

   
                                  <div class="form-group">

                                <div class="col-sm-12">

                                    <select name="tabgen_id" class="chosen-select form-control" onchange="cargarregistros();" id="tabgen_id" data-placeholder="Choose a State...">
                                       
                                        <?php if (count($tabgenid)): ?>
                                            <?php foreach ($tabgenid as $lista): ?>
                                                <option value="<?php echo $lista ['tabgen_id'] ?>" 
                                                   
                                                >
                                                <?php echo $lista['tabgen_nombre']; ?>
                                                </option>
                                            <?php endforeach; ?>

<?php endif; ?>
                                    </select>
                                </div>
                            </div>


                   
                        
                            <div class="hr hr32 hr-dotted" style="margin-top: 15px; margin-bottom: 7px;"></div>
                            <div class="hr hr32 hr-dotted" style="margin-top: 7px; margin-bottom: 15px;"></div>
                            


                            <div class="form-group">


                                <div class="col-sm-12">
                                    <input type="text"  required="required" placeholder="valor" class="form-control" 
                                           name="tabgendet_nombre" id="tabgendet_nombre" value="" />
                                </div>
                            </div>

                     

                            <div class="form-group">
                                
                                <div class="col-xs-8">
                                   
                                </div>
                                <div class="col-xs-4">
<!--                                    <button class="btn btn-success btn-next" data-last="Finish" id="guardardiseno">
                                        Guardar
                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                    </button>-->
<button type="button" class="btn btn-success btn-next" data-last="Finish" id="btnguardardatos">
                                        Guardar
                                        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8" id="listatabgen">

                           
                        </div>
                    
                    
                    </div>


                </div>
            </div>
        </div>


    </div>

    <div class="space-18"></div>

       <div class="modal-footer">
          
        <button type="button" class="btn btn-sm" data-dismiss="modal">
            <i class="ace-icon fa fa-times"></i>
            Salir
        </button>

<!--          <button type="button" class="btn btn-sm btn-primary" id="btnActualizarRegistros">
            <i class="ace-icon fa fa-check"></i>
            Salir
        </button>-->
    </div>
       



</form>
</div>


  
                 <script type="text/javascript">


//            function sumaform() {
/*
                var total = 0;

                $(".valorform").each(function () {

                    if (isNaN(parseFloat($(this).val()))) {

                        total += 0;

                    } else {

                        total += parseFloat($(this).val());

                    }

                });

//alert(total);
//                document.getElementById('spTotal').innerHTML = total;
                document.getElementById("mtrslineales").value = total.toFixed(2);
                
            

            }
  */  
        </script>
         
  
  
  
  
  
  
  
  
  
  
<script src="view/js/tabgendet.js"></script>     
<!--<script  src="view/js/diseno.js"></script>-->  
 <script src="assets/js/jquery-ui.min.js"></script>
            <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
            


<script type="text/javascript">
                                jQuery(function ($) {




                          

                                    $('#modal-form-tabgendet').on('shown.bs.modal', function () {
                                        if (!ace.vars['touch']) {
                                            $(this).find('.chosen-container').each(function () {
                                                $(this).find('a:first-child').css('width', '350px');
                                                $(this).find('.chosen-drop').css('width', '350px');
                                                $(this).find('.chosen-search input').css('width', '340px');
                                            });
                                        }
                                    })


                                });
</script>











