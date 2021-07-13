/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {




    $('body').on('click', '#mostrar_form_conenermensu', function (e) {
        e.preventDefault();

        var id_consumomes = $(this).data('estado');
        var id = $('#id_' + id_consumomes).val();
        var permiso = 'disabled';

        var ver_form_consumoenergia = $('#ver_form_consumoenergia');

        var _options = {
            type: 'POST',
            url: 'index.php?page=consumoenergia&accion=ajaxverdetalleconenerg',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_consumoenergia.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_consumomes);

                ver_form_consumoenergia.html(response);

                $('#modal-form-consumoenergia').modal('show');
            }
        };

        $.ajax(_options);

    });


    $('body').on('click', '#editar_form_conenermensu', function (e) {
        e.preventDefault();

        var id_consumomes = $(this).data('estado');
        var id = $('#id_' + id_consumomes).val();
        var permiso = 'enabled';

        var ver_form_consumoenergia = $('#ver_form_consumoenergia');

        var _options = {
            type: 'POST',
            url: 'index.php?page=consumoenergia&accion=ajaxverdetalleconenerg',
            data: {
                'id': id,
                'permiso': permiso
            },
            dataType: 'html',
            success: function (response) {
                ver_form_consumoenergia.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_consumomes);

                ver_form_consumoenergia.html(response);

                $('#modal-form-consumoenergia').modal('show');
            }
        };

        $.ajax(_options);

    });

    $(document).on("click", "#bootbox-confirm-insercion", function (e) {

        e.preventDefault();
        bootbox.confirm(" Advertencia!!!  solo se puede ingresar un registro en el mes por año. ¿Esta seguro que deseas continuar?", function (result) {
            if (result) {
                document.formularioconsumomes.submit();
            }
        });
    });



    $('body').on('click', '#prorrateoarea', function (e) {


        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idconsumomes = $(this).data('estado');
        var anio = $('#id_anio' + idconsumomes).val();
        var id_mes = $('#id_mes' + idconsumomes).val();
        var id_importe = $('#id_importe' + idconsumomes).val();
        var sesion = $('#sesion').val();

        if (id_importe > 0) {
            var loading = $(".loading-" + idconsumomes);
            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";

            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=consumoenergia&accion=ajaxProrratearConsArea',
                data: {
                    'idconsumomes': idconsumomes,
                    'anio': anio,
                    'id_mes': id_mes,
                    'id_importe': id_importe,
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

            alert("Debe Ingresar un valor valido.") ? "" : location.reload();
        }


    });


    $('body').on('click', '#conenermensual_areas', function (e) {
        e.preventDefault();

        var id_consumomes = $(this).data('estado');
        var id = $('#id_' + id_consumomes).val();


        var ver_porcen_areas = $('#ver_porcen_areas');

        var _options = {
            type: 'POST',
            url: 'index.php?page=consumoenergia&accion=ajaxverdetallePorcenAreas',
            data: {
                'id': id
            },
            dataType: 'html',
            success: function (response) {
                ver_porcen_areas.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_consumomes);

                ver_porcen_areas.html(response);

                $('#modal-form-porcen_areas').modal('show');
            }
        };

        $.ajax(_options);

    });


    $('body').on('click', '#prorratearmaquinas', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idprorra_area = $(this).data('estado'); //CODIGO DE LA TABLA CONSUMO DE ENERGIA
        var id = $('#id_' + idprorra_area).val(); // ID DEL AREA
        alert(id);
        var valorporcentaje = $('#valorporcentaje-' + idprorra_area).val();
        var suma = $('#suma').val();

        if (suma == 100) {
            var loading = $(".loading-" + idprorra_area);
            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=consumoenergia&accion=ajaxProrratearConsMaqui',
                data: {
                    'idprorra_area': idprorra_area,
                    'valorporcentaje': valorporcentaje,
                    'suma': suma,
                    'id': id,
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

            alert("Debe Ingresar valores validos para cada área.") ? "" : location.reload();
        }


    });


     $('body').on('click', '#conenermensual_maquinas', function (e) {
        e.preventDefault();

        var id_consumomaqu = $(this).data('estado');
        var valorporcentaje = $('#valorporcentaje-' + id_consumomaqu).val();
        var id_area = $('#id_' + id_consumomaqu).val();


        var ver_porcen_maq = $('#ver_porcen_maq');

        var _options = {
            type: 'POST',
            url: 'index.php?page=consumoenergia&accion=ajaxverdetallePorcenMaq',
            data: {
                'id_consumomaqu': id_consumomaqu,
                'valorporcentaje': valorporcentaje,
                'id_area' : id_area
            },
            dataType: 'html',
            success: function (response) {
                ver_porcen_maq.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_consumomaqu);

                ver_porcen_maq.html(response);

                $('#modal-form-porcen_maq').modal('show');
            }
        };

        $.ajax(_options);

    });
    
    
       $('body').on('click', '#updateporcmaq', function (e) {

        var checkboxClickeado = $(this);
        var agregar = $(this).is(':checked');
        var idprorra_maq = $(this).data('estado'); //CODIGO DE LA TABLA PRORRATEO MAQ
    
        var valorporcentaje = $('#valorporcentaje-' + idprorra_maq).val();
        var suma = $('#sumamaq').val();

        if (suma == 100) {
            var loading = $(".loading-" + idprorra_maq);
            checkboxClickeado.hide();
            loading.show();

            if (agregar) {
                var accion = "agregar";

            } else {
                var accion = "eliminar";
            }
            var _options = {
                type: 'POST',
                url: 'index.php?page=consumoenergia&accion=ajaxupdateporcemaq',
                data: {
                    'idprorra_maq': idprorra_maq,
                    'valorporcentaje': valorporcentaje,
                    'suma': suma,
                 
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

            alert("Debe Ingresar valores validos para cada Máquina.") ? "" : location.reload();
        }


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