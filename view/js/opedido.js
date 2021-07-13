/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#mostrarpdf', function (e) {
        e.preventDefault();

        var id = $(this).data('estado');

//        var permiso = 'disabled';

        var ver_pdf = $('#ver_pdf');

        var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxverpdf',
            data: {
                'id': id
            },
            dataType: 'html',
            success: function (response) {
                ver_pdf.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id);


                ver_pdf.html(response);

                $('#modal-pdf-op').modal('show');
            }
        };

        $.ajax(_options);

    });



    $('body').on('click', '#mostrarnotaped', function (e) {
        e.preventDefault();

        var id = $(this).data('notaped');

//        var permiso = 'disabled';

        var ver_notaped = $('#ver_notaped');

        var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxvernotaped',
            data: {
                'id': id
            },
            dataType: 'html',
            success: function (response) {
                ver_notaped.html('');


                $('#datosActualTXT2').val('');
                $('#datosActualTXT2').html(id);


                ver_notaped.html(response);

                $('#modal-pdf-notaped').modal('show');
            }
        };

        $.ajax(_options);

    });


    $('body').on('click', '#mostrarcomentarios', function (e) {
        e.preventDefault();

        var id = $(this).data('comentarioped');

//        var permiso = 'disabled';
          var tipdoc = $('#tipdoc').val();
        var ver_comentarios = $('#ver_comentarios');

        var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxvercomentarioped',
            data: {
                'id': id,
                'tipdoc':tipdoc
            },
            dataType: 'html',
            success: function (response) {
                ver_comentarios.html('');


                $('#datosActualTXT3').val('');
                $('#datosActualTXT3').html(id);


                ver_comentarios.html(response);

                $('#modal-comentarios').modal('show');
            }
        };

        $.ajax(_options);

    });


 $('body').on('click', '#enviarcoment', function (e) {
        e.preventDefault();
        var comentario = $('#comentario').val();
         var op = $('#op').val();
         var tipdoc = $('#tipdoc').val();

if(comentario != ''){
    var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxregistrarcoments',
            data: {
                'comentario': comentario,
                'tipdoc': tipdoc,
                'op' :op
            },
            dataType: 'html'
        };

        $.ajax(_options)

        .done(function (res) {
            $('#actualizarcomentarios').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
}else{
			bootbox.alert("Para poder agregar un comentario, debe escribir un mensaje valido", function(){});
		}
        
    });




  $('body').on('click', '#mostrarobs', function (e) {
        e.preventDefault();

        var id = $(this).data('obsped');
        var vbpermiso = $('#vb').val();
//        var permiso = 'disabled';

        var ver_observaciones = $('#ver_observaciones');

        var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxverobsped',
            data: {
                'id': id,
                'vbpermiso':vbpermiso
            },
            dataType: 'html',
            success: function (response) {
                ver_observaciones.html('');


                $('#datosActualTXT4').val('');
                $('#datosActualTXT4').html(id);


                ver_observaciones.html(response);

                $('#modal-observaciones').modal('show');
            }
        };

        $.ajax(_options);

    });


 $('body').on('click', '#enviarobs', function (e) {
        e.preventDefault();
        var obs = $('#obs').val();
         var op = $('#op').val();
          var vbpermiso = $('#vb').val();

if(obs != ''){
    var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxregistrarobs',
            data: {
                'obs': obs,
                 'vbpermiso':vbpermiso,
                'op' :op
            },
            dataType: 'html'
        };

        $.ajax(_options)

        .done(function (res) {
            $('#actualizarobs').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
}else{
			bootbox.alert("Para poder agregar una observaciòn, debe escribir un mensaje valido", function(){});
		}
        
    });


    $('body').on('click', '#idobs', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idobs = $(this).data('idobs');
        var op = $('#op').val();
           var vbpermiso = $('#vb').val();

 
            var loading = $(".loading-" + idobs);
            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=opedido&accion=corregirobs',
                data: {
                    'idobs': idobs,
                    'op': op, 
                     'vbpermiso': vbpermiso, 
                    'accion': accion
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#actualizarobs').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    });
    
    
       $('body').on('click', '#mostrardiseno', function (e) {
        e.preventDefault();

        var id = $(this).data('diseno');

//        var permiso = 'disabled';

        var ver_diseno = $('#ver_diseno');

        var _options = {
            type: 'POST',
            url: 'index.php?page=opedido&accion=ajaxverdiseno',
            data: {
                'id': id
            },
            dataType: 'html',
            success: function (response) {
                ver_diseno.html('');


                $('#datosdisenoTXT').val('');
                $('#datosdisenoTXT').html(id);


                ver_diseno.html(response);

                $('#modal-diseno').modal('show');
            }
        };

        $.ajax(_options);

    });

$('body').on('click', '#aprobventas', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idop = $(this).data('aprobventas');
     var iddiseno = $('#iddisenovig-'+idop).val(); 
     
      var impresion = $('#diseno-'+idop).val(); 
     
    var ini = $('#ini').val();
       var fin = $('#fin').val();

 if(impresion == 'SI' && iddiseno > 0 ){
       var loading = $(".loading-" + idop);
            checkboxClickeado.hide();
            loading.show();
$('#cargar').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=opedido&accion=aprobventas',
                data: {
                    'idop': idop,
                    'ini': ini,
                    'fin': fin,
                    'iddiseno':iddiseno,
                    'accion': accion
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargar').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
 }else if(impresion == 'NO' && iddiseno === ''){
     iddiseno= 0 ;
     var loading = $(".loading-" + idop);
            checkboxClickeado.hide();
            loading.show();
$('#cargar').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=opedido&accion=aprobventas',
                data: {
                    'idop': idop,
                    'ini': ini,
                    'fin': fin,
                    'iddiseno':iddiseno,
                    'accion': accion
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargar').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    }else if(impresion === '' && iddiseno === ''){  
        
          bootbox.alert('El articulo no se encuentra definido si es impreso o no!', function(){}); 
            }else if(impresion == 'SI' && iddiseno === ''){  
        
          bootbox.alert('El articulo esta configurado con diseño, pero no se encuentra cargado ningun diseño!', function(){}); 
 }else{
        bootbox.alert('se encontraron datos incorrectos, favor de comunicar al area de TI.', function(){}); 
 }
          
    });
  
    $('body').on('click', '#aprobplanificacion', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idop = $(this).data('aprobplanificacion');
     var iddiseno = $('#iddisenovig-'+idop).val(); 
     
     if(iddiseno === ''){
         iddiseno=0;
     }
     
    var ini = $('#ini').val();
       var fin = $('#fin').val();

 
            var loading = $(".loading-" + idop);
            checkboxClickeado.hide();
            loading.show();
$('#cargarvb').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=opedido&accion=aprobPlanificacion',
                data: {
                    'idop': idop,
                    'ini': ini,
                    'fin': fin,
                    'iddiseno':iddiseno,
                    'accion': accion
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargarvb').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    });
    
    
    
     $('body').on('click', '#cerrarop', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idop = $(this).data('cerrarop');
     var op = $('#op-'+idop).val(); 
     
    
     
    var ini = $('#ini').val();
       var fin = $('#fin').val();
    var estado = $('#estado').val();
 
            var loading = $(".loading-" + idop);
            checkboxClickeado.hide();
            loading.show();
$('#cargarops').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=planificacion&accion=cerrarOps',
                data: {
                    'idop': idop,
                    'ini': ini,
                    'fin': fin,
                    'op':op,
                    'accion': accion,
                    'estado':estado
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
            
            
            .done(function (res) {
            $('#cargarops').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    });
    
      $('body').on('click', '#cambiomaq', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var id = $(this).data('cambiomaq');//
        
        
     var maq_detino = $('#maq_detino-'+id).val(); 
      var motivo = $('#motivo-'+id).val(); 
       var op = $('#op-'+id).val(); 
        var maqori = $('#maqori-'+id).val(); 
         var kanban = $('#kanban-'+id).val(); 
         
         var artsemi = $('#artsemi-'+id).val(); 
         var fecdispo = $('#fecdispo-'+id).val(); 
         var mtrs = $('#mtrs-'+id).val(); 
          var procesos = $('#procesos').val(); 
     
   
            var loading = $(".loading-" + id);
            checkboxClickeado.hide();
            loading.show();
 
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=planificacion&accion=cambiomaq',
                data: {
                    'id': id,
                    'maq_detino': maq_detino,
                    'motivo': motivo,
                    'op':op,
                    'accion': accion,
                    'maqori':maqori,
                      'kanban':kanban,
                      'artsemi':artsemi,
                      'fecdispo':fecdispo,
                      'mtrs':mtrs,
                      'procesos':procesos
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);
            
           
    });
    
});