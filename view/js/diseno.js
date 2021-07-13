/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#editar_diseno', function (e) {
        e.preventDefault();

        var id = $(this).data('estado'); //codigo del articulo
       //  var versionactual = $('#versionactual'+id).val(); 
        var permiso = 'enabled';

        var ver_disenoform = $('#ver_disenoform');

        var _options = {
            type: 'POST',
            url: 'index.php?page=diseno&accion=ajaxverform',
            data: {
                'id': id,
                'permiso':permiso
            //    'versionactual':versionactual
            },
            dataType: 'html',
            success: function (response) {
                ver_disenoform.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id);


                ver_disenoform.html(response);

                $('#modal-diseno').modal('show');
            }
        };

        $.ajax(_options);

    });
    



$('body').on('click', '#updateversion', function (e) {

 
        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var iddetallle = $(this).data('iddetallle');
        var codartactual = $('#codartactual').val();
        
 var iddiseno = $('#iddiseno').val();
 
            var loading = $(".loading-" + iddetallle);
            checkboxClickeado.hide();
            loading.show();
   $('#actualizarlista').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>");   
            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=diseno&accion=versionvig',
                data: {
                    'iddetallle': iddetallle,
                    'codartactual': codartactual,                 
                    'accion': accion,
                    'iddiseno':iddiseno
                },
                dataType: 'html',
                success: function (response) {
                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options)
            
          
            
            .done(function (res) {
           
                  $('#actualizarlista').html(res);
         
          
        })
        
        
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
    });
















//////////////////////////******************* VERSIONES DE PRUEBA *********  NO FUNCIONALES

function insertardatos4 (){
    //e.preventDefault();
       var form_data = new FormData($('#datos-diseno')[0]);
     //  $("#cargando").html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>")
        //var actualizarlista = $('#actualizarlista');
           var _options = {
            type: 'POST',
            url: 'index.php?page=diseno&accion=ajaxregistrardiseno',
            data:form_data,
          //  dataType: 'html',
            contentType: false,
            processData: false,
            beforesend:function(){
                
            },
              success: function (response) {
                
                    	$.get("index.php?page=diseno&accion=ajaxregistrardiseno","",function(data){ $("#actualizarlista").html(data); });

                }
                
        };

        $.ajax(_options)
        .done(function (res) {
            $('#actualizarlista').html(res);
        })
        
                .fail(function(){
                    console.log("error");
                })
                
                .always(function(){
                    console.log("complete");
                });
}


$('body').on('click', '#guardardiseno', function (e) {
        e.preventDefault();
        
        var articulo = $('#articulos').val();
         var cliente = $('#cliente').val();
         var nomdiseno = $('#nomdiseno').val();
         var comentario = $('#comentario').val();
         var comentariodet = $('#comentariodet').val();
       //  var archivo = $('#archivo').val();
//          var form_data = new FormData($('#datosdiseno')[0]);

               //  document.getElementById("archivo").value; $('#archivo');
         var version = $('#spinner').val();
         var permiso = $('#permiso').val();
          var iddiseno = $('#iddiseno').val();
          

        
  $('#actualizarlista').html("<center><img  style='background:transparent;'  src='view/img/loadingV02.gif'/></center>"); 
if(articulo != -1){
    var _options = {
            type: 'POST',
            url: 'index.php?page=diseno&accion=ajaxregistrardiseno',
            data: {
                'articulo': articulo,
                'cliente' :cliente,
                'nomdiseno': nomdiseno,
                'comentario' :comentario,
                'version': version,
                'permiso':permiso,
                'comentariodet':comentariodet,
//                'archivo':archivo,
                'iddiseno':iddiseno,
//                'form_data':form_data
                
            },
            dataType: 'html',
//             contentType: false,
//            processData: false,
        };

        $.ajax(_options)

        .done(function (res) {
            $('#actualizarlista').html(res);
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


});