/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_subsubmenu', function (e) {
        e.preventDefault();

        var id_subsubmenu = $(this).data('estado');
        var id = $('#id_' + id_subsubmenu).val();
        var permiso = 'disabled';

        var ver_formsubsubmenu_detalle = $('#ver_formsubsubmenu_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=subsubmenu&accion=ajaxverdetallesubsubmenu',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formsubsubmenu_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_subsubmenu);

                ver_formsubsubmenu_detalle.html(response);

                $('#modal-form-subsubmenu').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_subsubmenu', function (e) {
        e.preventDefault();

        var id_subsubmenu = $(this).data('estado');
        var id = $('#id_' + id_subsubmenu).val();
        var permiso = 'enabled';

        var ver_formsubsubmenu_detalle = $('#ver_formsubsubmenu_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=subsubmenu&accion=ajaxverdetallesubsubmenu',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formsubsubmenu_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_subsubmenu);

                ver_formsubsubmenu_detalle.html(response);

                $('#modal-form-subsubmenu').modal('show');
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