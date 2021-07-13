/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#editar_caractart', function (e) {
        e.preventDefault();

        var id = $(this).data('estado'); //codigo del articulo
       //  var versionactual = $('#versionactual'+id).val(); 
        var permiso = 'enabled';

        var ver_caracttecnicasform = $('#ver_caracttecnicasform');
        		   var tipsemi = $('#tipsemi').val();

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxverform',
            data: {
                'id': id,
                'permiso':permiso,
                'tipsemi':tipsemi
            },
            dataType: 'html',
            success: function (response) {
                ver_caracttecnicasform.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id);


                ver_caracttecnicasform.html(response);

                $('#modal-caractart').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
    $('body').on('click', '#editar_caractart_parch', function (e) {
        e.preventDefault();

        var id = $(this).data('estado'); //codigo del articulo
       //  var versionactual = $('#versionactual'+id).val();  tipsemi
        var permiso = 'enabled';

        var ver_caracttecnicasform = $('#ver_caracttecnicasform');
		   var tipsemi = $('#tipsemi').val();
		     var descr = $('#descr-'+id).val();
        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxverformparch',
            data: {
                'id': id,
                'permiso':permiso,
                'tipsemi':tipsemi,
                'descr':descr
            },
            dataType: 'html',
            success: function (response) {
                ver_caracttecnicasform.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id);


                ver_caracttecnicasform.html(response);

                $('#modal-caractart').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
    
$('body').on('click', '#asignarmaqtelares', function (e) {
        e.preventDefault();

        var idsemiterminado = $(this).data('asignarmaq');
         var tipsemi = $('#tipsemi-'+idsemiterminado ).val();
   
        var ver_listatelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxListarTelares',
            data: {
                'idsemiterminado': idsemiterminado,
                'tipsemi':tipsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listatelares.html('');


                $('#datosActualTXTarticulo').val('');
                $('#datosActualTXTarticulo').html(idsemiterminado);


                ver_listatelares.html(response);

                $('#modal-asignarmaq').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
       $('body').on('click', '#maqsemit', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');

        var maq_id = $(this).data('maqsemi');
       
        
        var velocInicial = $('#velocInicial-' + maq_id).val();
     //   var puestapunto = $('#puestapunto-' + maq_id).val();
          var asig_maq_semi = $('#asig_maq_semi-' + maq_id).val();
          var id_semit = $('#id_semit').val();
         var tipsemi = $('#tipsemi').val();
         
         
           var items = $(this).data('items');
            var puestapunto = $('#timepicker' + items).val();
   
        if (
                velocInicial > 0 

                ) {


            var loading = $(".loading-" + maq_id);



            checkboxClickeado.hide();
            loading.show();
//$('#actualizarlistaTelares').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
  
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";

            }
            
            

            var _options = {
                type: 'POST',
                url: 'index.php?page=articulocaractecnicas&accion=ajaxregistrarmaqsemiterminado',
                data: {
                    'maq_id': maq_id,
                    'velocInicial': velocInicial,
                    'id_semit': id_semit,
                    'puestapunto':puestapunto,
                    'tipsemi':tipsemi,
                    'asig_maq_semi':asig_maq_semi,
                    'accion': accion
                },
                dataType: 'json',
                success: function (response) {




                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
              .done(function (res) {
//            $('#actualizarlistaTelares').html(res);
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });

        } else {

             bootbox.alert('No se adminten valores "0" (cero) para la velocidad de inicial y tiempo de puesta en marcha, favor de revisar!!', function(){}); 
                
        }


    });

$('body').on('click', '#asignarmaqtel', function (e) {
        e.preventDefault();

        var idsemiterminado = $(this).data('asignarmaq');
        var tipsemi = $(this).data('semit');
//         var tipsemi = $('#tipsemi-'+idsemiterminado ).val();
   
        var ver_listatelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxListarTelares',
            data: {
                'idsemiterminado': idsemiterminado,
                'tipsemi':tipsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listatelares.html('');


                $('#datosActualTXTarticulo').val('');
                $('#datosActualTXTarticulo').html(idsemiterminado);


                ver_listatelares.html(response);

                $('#modal-asignarmaq').modal('show');
            }
        };

        $.ajax(_options);

    });
  
$('body').on('click', '#asignarmaqlam', function (e) {
        e.preventDefault();

        var idsemiterminado = $(this).data('asignarmaq');
           var tipsemi = $(this).data('semit');
//         var tipsemi = $('#tipsemi-'+idsemiterminado ).val();
        var ver_listatelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxListarTelares',
            data: {
                'idsemiterminado': idsemiterminado,
                'tipsemi':tipsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listatelares.html('');


                $('#datosActualTXTarticulo').val('');
                $('#datosActualTXTarticulo').html(idsemiterminado);


                ver_listatelares.html(response);

                $('#modal-asignarmaq').modal('show');
            }
        };

        $.ajax(_options);

    });
    
$('body').on('click', '#asignarmaqimp', function (e) {
        e.preventDefault();

        var idsemiterminado = $(this).data('asignarmaq');
            var tipsemi = $(this).data('semit');
//         var tipsemi = $('#tipsemi-'+idsemiterminado ).val();
   
        var ver_listatelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxListarTelares',
            data: {
                'idsemiterminado': idsemiterminado,
                'tipsemi':tipsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listatelares.html('');


                $('#datosActualTXTarticulo').val('');
                $('#datosActualTXTarticulo').html(idsemiterminado);


                ver_listatelares.html(response);

                $('#modal-asignarmaq').modal('show');
            }
        };

        $.ajax(_options);

    });

$('body').on('click', '#asignarmaqconv', function (e) {
        e.preventDefault();

        var idsemiterminado = $(this).data('asignarmaq');
              var tipsemi = $(this).data('semit');
//         var tipsemi = $('#tipsemi-'+idsemiterminado ).val();
   
        var ver_listatelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxListarTelares',
            data: {
                'idsemiterminado': idsemiterminado,
                'tipsemi':tipsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listatelares.html('');


                $('#datosActualTXTarticulo').val('');
                $('#datosActualTXTarticulo').html(idsemiterminado);


                ver_listatelares.html(response);

                $('#modal-asignarmaq').modal('show');
            }
        };

        $.ajax(_options);

    });
    
$('body').on('click', '#asignarmaqbast', function (e) {
        e.preventDefault();

        var idsemiterminado = $(this).data('asignarmaq');
              var tipsemi = $(this).data('semit');
//         var tipsemi = $('#tipsemi-'+idsemiterminado ).val();
   
        var ver_listatelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxListarTelares',
            data: {
                'idsemiterminado': idsemiterminado,
                'tipsemi':tipsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listatelares.html('');


                $('#datosActualTXTarticulo').val('');
                $('#datosActualTXTarticulo').html(idsemiterminado);


                ver_listatelares.html(response);

                $('#modal-asignarmaq').modal('show');
            }
        };

        $.ajax(_options);

    });

$('body').on('click', '#asignarmaqprens', function (e) {
        e.preventDefault();

        var idsemiterminado = $(this).data('asignarmaq');
                var tipsemi = $(this).data('semit');
//         var tipsemi = $('#tipsemi-'+idsemiterminado ).val();
   
        var ver_listatelares = $('#ver_listatelares');

        var _options = {
            type: 'POST',
            url: 'index.php?page=articulocaractecnicas&accion=ajaxListarTelares',
            data: {
                'idsemiterminado': idsemiterminado,
                'tipsemi':tipsemi
               
            },
            dataType: 'html',
            success: function (response) {
                ver_listatelares.html('');


                $('#datosActualTXTarticulo').val('');
                $('#datosActualTXTarticulo').html(idsemiterminado);


                ver_listatelares.html(response);

                $('#modal-asignarmaq').modal('show');
            }
        };

        $.ajax(_options);

    });


    
    
    
    
    

});
