/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {



    $('body').on('click', '#mostrar_form_formulacion', function (e) {
        e.preventDefault();

        var id_formula = $(this).data('estado');
        var id = $('#id_' + id_formula).val();
        var permiso = 'disabled';

        var ver_formulacion = $('#ver_formulacion');

        var _options = {
            type: 'POST',
            url: 'index.php?page=formulacion&accion=ajaxverdetalleformulacion',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formulacion.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_formula);

                ver_formulacion.html(response);

                $('#modal-form-formulacion').modal('show');
            }
        };

        $.ajax(_options);

    });
    $('body').on('click', '#editar_form_formulacion', function (e) {
        e.preventDefault();

        var id_formula = $(this).data('estado');
        var id = $('#id_' + id_formula).val();
        var permiso = 'enabled';

        var ver_formulacion = $('#ver_formulacion');

        var _options = {
            type: 'POST',
            url: 'index.php?page=formulacion&accion=ajaxverdetalleformulacion',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_formulacion.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_formula);

                ver_formulacion.html(response);

                $('#modal-form-formulacion').modal('show');
            }
        };

        $.ajax(_options);

    });

    $(document).on("click", "#bootbox-confirm-formulacion", function (e) {

        e.preventDefault();
        bootbox.confirm(" Advertencia!!! ", function (result) {
            if (result) {
                document.formularioformulacion.submit();
            }
        });
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



    $('body').on('click', '#formulacion_detalle', function (e) {
        e.preventDefault();

        var id_form = $(this).data('estado');
//        var id_form = $('#id_' + id_form).val(); //
        var tipsem_id = $('#tipsem_id' + id_form).val();
        var tipsem_titulo = $('#tipsem_titulo' + id_form).val();
//        var permiso = 'enabled';

        var ver_formulacion_detalle = $('#ver_formulacion_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=formulacion&accion=ajaxverdetalleformulaciondet',
            data: {
               
                'id_form': id_form,
                'tipsem_id': tipsem_id,
                'tipsem_titulo': tipsem_titulo
            },
            dataType: 'html',
            success: function (response) {
                ver_formulacion_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(tipsem_titulo);

                ver_formulacion_detalle.html(response);

                $('#modal-form-formulacion-detalle').modal('show');
            }
        };

        $.ajax(_options);

    });


    $('body').on('click', '#insertarform', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');

        var id_item_form = $(this).data('estado');
        var valor = $('#valor-' + id_item_form).val();
        var form_id = $('#idform' +id_item_form).val();
    
           var suma = $('#sumaform').val();



        if (
                suma ==  100 && valor >0

                ) {


            var loading = $(".loading-" + id_item_form);



            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";

            }

            var _options = {
                type: 'POST',
                url: 'index.php?page=formulacion&accion=ajaxmanejarestadoitemform',
                data: {
                    'id_item_form': id_item_form,
                    'valor': valor,
                    'form_id' : form_id,
                    'accion': accion
                },
                dataType: 'json',
                success: function (response) {




                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);

        } else {

            alert("La sumatoria total debe ser igual a 100.") ? "" : location.reload();
        }


    });





















});