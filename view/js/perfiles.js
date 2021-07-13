/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_perfiles', function (e) {
        e.preventDefault();

        var id_perfil = $(this).data('estado');
        var id = $('#id_' + id_perfil).val();
        var permiso = 'disabled';

        var ver_form_detalle_perfiles = $('#ver_form_detalle_perfiles');

        var _options = {
            type: 'POST',
            url: 'index.php?page=perfiles&accion=ajaxverdetalleperfiles',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_detalle_perfiles.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_perfil);

                ver_form_detalle_perfiles.html(response);

                $('#modal-form-perfiles').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_perfiles', function (e) {
        e.preventDefault();

        var id_perfil = $(this).data('estado');
        var id = $('#id_' + id_perfil).val();
        var permiso = 'enabled';

        var ver_form_detalle_perfiles = $('#ver_form_detalle_perfiles');

        var _options = {
            type: 'POST',
            url: 'index.php?page=perfiles&accion=ajaxverdetalleperfiles',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_detalle_perfiles.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_perfil);

                ver_form_detalle_perfiles.html(response);

                $('#modal-form-perfiles').modal('show');
            }
        };

        $.ajax(_options);

    });


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