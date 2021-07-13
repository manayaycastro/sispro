

$(document).on('ready', function () {

    $('body').on('click', '#mostrar_form_artsemi', function (e) {
        e.preventDefault();

        var id_artsemi = $(this).data('estado');

        var id = $('#id_' + id_artsemi).val();
        var permiso = 'disabled';

        var ver_artsemi_detalle = $('#ver_artsemi_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=artsemiterminado&accion=ajaxverdetalleartsemiterminado',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_artsemi_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_artsemi);

                ver_artsemi_detalle.html(response);

                $('#modal-form-artsemi').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#editar_form_artsemi', function (e) {
        e.preventDefault();

        var id_artsemi = $(this).data('estado');
        var id = $('#id_' + id_artsemi).val();
        var permiso = 'enabled';


        var ver_artsemi_detalle = $('#ver_artsemi_detalle');

        var _options = {
            type: 'POST',
            url: 'index.php?page=artsemiterminado&accion=ajaxverdetalleartsemiterminado',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_artsemi_detalle.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_artsemi);

                ver_artsemi_detalle.html(response);

                $('#modal-form-artsemi').modal('show');
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



    var lista_maquina = $('#lista_maquina'); // VARIABLE QUE SE DESPRENDE  AL SELEECIONAR UN TIPO DE SEMITERMINADO
    var ajax_maquinas = $('#ajax_maquinas'); //  LISTA DE MAQUINA






    $('#tipsem_id').on('change', function (e) {
        e.preventDefault();

        var tipsem_id = $('#tipsem_id').val();
        var idsemiterminado = $('#idsemi').val();
        var id_semiterminado_tex = $('#tipsem_id option:selected').text();
        var permiso = 'disabled';
//         var ajax_maquinas2 = $('#ajax_maquinas');


        if (tipsem_id != -1) {

            lista_maquina.slideUp("slow", function () {
                var options = {
                    type: 'POST',
                    url: 'index.php?page=artsemiterminado&accion=ajaxmostrarmaquina',
                    data: {
                        'tipsem_id': tipsem_id,
                        'id_semiterminado_tex': id_semiterminado_tex,
                        'idsemiterminado': idsemiterminado,
                        'permiso': permiso
                    },
                    dataType: 'html',
                    success: function (response) {
                        ajax_maquinas.html('');

                        $('#tipSemiActual').val(idsemiterminado);
                        $('#tipSemiActual2').val(tipsem_id);
                        ajax_maquinas.html(response);
                        lista_maquina.slideDown("slow");
                    }
                };

                $.ajax(options);


            });


        } else {
            alert("Debe seleccionar una opcion valida");
        }

    });




    $('body').on('click', '#btnAgregarMaquina', function (e) {
        e.preventDefault();

        var tipSemiActual = $('#tipSemiActual2').val();
        var idsemiterminado = $('#idsemiterminado').val();
        var idsemi = $('#idsemi').val();

        var permiso = 'enabled';
        var ver_maquina = $('#ver_maquina');


        var _options = {
            type: 'POST',
            url: 'index.php?page=artsemiterminado&accion=ajaxlistarmaquina',
            data: {
                'tipSemiActual': tipSemiActual, // tipo de semiterminado
                'idsemiterminado': idsemiterminado,
                'idsemi': idsemi, //id de semiterminado actual

                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_maquina.html('');


                $('#idsemiterminadomodal').val(idsemiterminado);

                $('#datosActualTXT').html(tipSemiActual);

                ver_maquina.html(response);

                $('#modal-form-maquina').modal('show');
            }
        };

        $.ajax(_options);

    });

    $('body').on('click', '#btnFinalizarAgregado', function (e) {
        e.preventDefault();

        $('#modal-form-maquina').modal('hide');

    });


    $('#tipsem_id').on('change', function (e) {
        lista_maquina.slideUp("fast");
    });




    $('body').on('click', '#maqsemit', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');

        var maq_id = $(this).data('maqsemi');
        var numcintas = $('#numcintas-' + maq_id).val();
        
        
        var semi_id = $('#semi-' + maq_id).val();
         var asig_maq_semi = $('#asig_maq_semi-' + maq_id).val();

   


            var loading = $(".loading-" + maq_id);



            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";

            }

            var _options = {
                type: 'POST',
                url: 'index.php?page=artsemiterminado&accion=ajaxregistrarmaqsemiterminado',
                data: {
                    'maq_id': maq_id,
                    'numcintas': numcintas,
                    'semi_id': semi_id,
                    'asig_maq_semi':asig_maq_semi,
                    'accion': accion
                },
                dataType: 'json',
                success: function (response) {




                    checkboxClickeado.show();
                    loading.hide();

                }
            };

            $.ajax(_options);

      


    });



    $('body').on('click', '#btnAgregarMaquina2', function (e) {
        e.preventDefault();


        var idsemiterminado = $(this).data('artsemi');
        var tipSemiActual = $(this).data('tipsemi');
 
//         var tipSemiActual = $('#tipSemiActual2'+ id).val();
//        var idsemiterminado = $('#idsemiterminado'+ id).val();
        var idsemi = idsemiterminado;

        var permiso = 'enabled';
        var ver_maquina = $('#ver_maquina');

        var _options = {
            type: 'POST',
             url: 'index.php?page=artsemiterminado&accion=ajaxlistarmaquinaV2',
            data: {
                'tipSemiActual': tipSemiActual, // tipo de semiterminado
                'idsemiterminado': idsemiterminado,
                'idsemi': idsemi, //id de semiterminado actual

                'permiso': permiso
            },
            dataType: 'html',
           success: function (response) {
                ver_maquina.html('');


                $('#idsemiterminadomodal').val(tipSemiActual);

                $('#datosActualTXT').html(tipSemiActual);

                ver_maquina.html(response);

                $('#modal-form-maquina').modal('show');
            }
        };

        $.ajax(_options);

    });

});
