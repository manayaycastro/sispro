/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_menu', function (e) {
        e.preventDefault();

        var id_menu = $(this).data('estado');
        var id = $('#id_' + id_menu).val();
        var permiso = 'disabled';

        var ver_form_detalle = $('#ver_form_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=menu&accion=ajaxverdetallemenu',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_menu);

                ver_form_detalle.html(response);

                $('#modal-form-menu').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_menu', function (e) {
        e.preventDefault();
      //  var url = "assets/js/selecticons.js";
        var id_menu = $(this).data('estado');
        var id = $('#id_' + id_menu).val();
        var permiso = 'enabled';

        var ver_form_detalle = $('#ver_form_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=menu&accion=ajaxverdetallemenu',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_menu);

                ver_form_detalle.html(response);
                
 

                $('#modal-form-menu').modal('show');
            }
        };
   //document.write('<script src="assets/js/selecticons.js"></script>');
        $.ajax(_options);
     

    });
    var url = "http://localhost:84/proyecto_produccion/assets/js/selecticons.js";

      $.getScript( url, function() {
  $( "#editar_form_menu" ).click(function() {
    $( "#ver_form_detalle" )
      alert('Contenido actualizado');
    
  });
});
//$("#editar_form_menu").on('click',function(evento){
//
//evento.preventDefault();
//
//$("#ver_form_detalle").load("http://localhost:84/proyecto_produccion/assets/js/selecticons.js");
//
//});











    $(document).on("click", "#bootbox-confirm", function (e) {
        var link = $(this).attr("href"); // "get" the intended link in a var
        e.preventDefault();
        bootbox.confirm("¿Esta seguro de querer eliminar el registro?", function (result) {
            if (result) {
                document.location.href = link;  // if result, "set" the document location       
            }
        });
    });


});

//document.write('<script src="assets/js/selecticons.js"></script>');