
  
                <link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
      

    <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<div class="col-sm-12" id="actualizarlistaTelares">
                <div class="widget-box">
                        <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                        <i class="ace-icon fa fa-comment blue"></i>
                                        Lista de Máquinas
                                </h4>
                         
<!--                            <div class="widget-toolbar hidden-480">
                           Click para  Imprimir toda la orden <?php // echo $op; ?>
                           <a class="btn btn-app btn-light btn-xs">
                               <i class="ace-icon fa fa-print bigger-160"></i>
                               Print
                           </a>-->
                           
<!--                           <a href="#"> glyphicon-signal
                                    <i class="ace-icon fa fa-print"></i>
                                </a>-->
                            </div>
                            
<!--                               <div class="widget-toolbar hidden-480">
                           Ver disponibilidad de Telares
                           <a class="btn btn-app btn-light btn-xs">
                               <i class="ace-icon fa fa-bar-chart-o bigger-160"></i>
                               Ver
                           </a>
                           
                           <a href="#">
                                    <i class="ace-icon fa fa-print"></i>
                                </a>
                            </div>-->
                        </div>
                    <input type="hidden" name="id_semit" id="id_semit" value="<?php echo $idsemiterminado; ?>">
                    <input type="hidden" name="tipsemi" id="tipsemi" value="<?php echo $tipsemi; ?>">
                      <input type="hidden" name="cantiReg" id="cantiReg" value="<?php echo count ($maquinas); ?>">
                        <div class="widget-body">
                                <div class="widget-main no-padding">
                                        <div class="dialogs">
                                               
                                                   <table class="table table-bordered table-striped">
                                        <thead class="thin-border-bottom">
                                                <tr>
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Items
                                                        </th>
                                                        
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Telar
                                                        </th>
                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Vel. Inic. (Metros x min)
                                                        </th>

                                                        <th>
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Tiempo de P.P (Horas)
                                                        </th>
                                                   
                                                     
                                                        
                                                        <th class="hidden-480">
                                                                <i class="ace-icon fa fa-caret-right blue"></i>Asignar
                                                        </th>
                                                       
                                                        
                                                </tr>
                                        </thead>

                                        <tbody>
                                            <?php  $a= 0;?>
                                                
                                                <?php  if ($maquinas):?>
                                                 <?php foreach ($maquinas as $lista) : ?>
                                                  <?php  $a++;?>
                                                 <tr>
                                                        <td> <?php echo $lista ["maq_id"];?></td>
                                                         <td> <?php echo $lista ["maq_nombre"];?></td>
                                                        <td>
                                                            
                                                            <input type="text" id="velocInicial-<?php echo $lista ["maq_id"];?>" 
                                                                   name="velocInicial-<?php echo $lista ["maq_id"];?>" 
                                                                   value="<?php echo $lista ["artsemimaq_velinicial"];?>">
                                                            
                                                        </td>
                                                          
                                                        <td>
                                                       
                                                         

                                                        <div class="input-group bootstrap-timepicker<?php echo  $a;?>">
                                                            <input id="timepicker<?php echo  $a;?>" name="timepicker<?php echo  $a;?>" type="text" class="form-control"
                                                            value="<?php echo $lista ["artsemimaq_puestapunto"];?>"
                                                             />
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-clock-o bigger-110"></i>
                                                            </span>
                                                        </div>
                                                       
                                                    
                                                       
                                                      
                                                        <td> 
                                                        
                                                
                                                            
                    <img width="18px" height="18px" style="margin-top: -7px; display: none;"
                     src="view/img/loading.gif" class="loading-<?php echo  $lista ['maq_id']; ?>" >
                    <input name="switch-field-1" class="ace ace-switch ace-switch-6" type="checkbox" 
                           <?php if ($lista ['artsemimaq_id'] > '0'): ?> checked="checked" <?php else: ?> <?php endif; ?>
                           id="maqsemit" data-maqsemi="<?php echo  $lista ['maq_id']; ?>"
                           data-items="<?php echo  $a; ?>"
                           />
                    <span class="lbl"></span>
                    
                     <input type="hidden" name="asig_maq_semi-<?php echo $lista ['maq_id']; ?>" id="asig_maq_semi-<?php  echo $lista ['maq_id']; ?>" value="<?php echo $lista ['artsemimaq_id']; ?>" />
           
                                                        </td>
                                                       
                                                     
                                                </tr>
                                                
                                                 <?php endforeach;?>
                                                 <?php endif; ?>
                                               

                                               
                                        </tbody>
                                </table>
                                        </div>


                                   
                                </div><!-- /.widget-main -->
                        </div><!-- /.widget-body -->
                </div><!-- /.widget-box -->
</div>

 <script src="assets/js/bootstrap-datepicker.min.js"></script>
            <script src="assets/js/bootstrap-timepicker.min.js"></script>
            <script src="assets/js/moment.min.js"></script>
           
            <script src="assets/js/bootstrap-colorpicker.min.js"></script>
	
 <script type="text/javascript">  
 
 

  $(document).ready(function(){

	var item = 	 document.getElementById("cantiReg").value;
 	 	console.log(item);
              
			

               
    for ( var i = 1; i <= (item+1); i++) {
		//var id = "'"+"#timepicker"+i +"'";
		var codigo = i;
  	//console.log(codigo);


  	    $('#timepicker'+codigo+'').timepicker({
                                    minuteStep: 1,
                                    showSeconds: true,
                                    showMeridian: false,
                                    disableFocus: false,
                                    icons: {
                                        up: 'fa fa-chevron-up',
                                        down: 'fa fa-chevron-down'
                                    }
                                }).on('focus', function () {
                                    $('#timepicker'+codigo+'').timepicker('showWidget');
                                }).next().on(ace.click_event, function () {
                                    $(this).prev().focus();
                                   // document.getElementById('timepicker'+codigo+'').focus();
                                });
      
      
     }    
 
  }); 
  
 
   
        </script>
