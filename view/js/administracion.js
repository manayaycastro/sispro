/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function () {

    $('body').on('click', '#acceso_form_perfiles', function (e) {
        e.preventDefault();

        var id_perfil = $(this).data('estado');
        var id = $('#id_' + id_perfil).val();
        var descp_perfil = $('#rol-' + id_perfil).val();
//        var permiso = 'disabled';

        var ver_form_detalle_acceso = $('#ver_form_detalle_acceso');

        var _options = {
            type: 'POST',
            url: 'index.php?page=administracion&accion=ajaxveracceso',
            data: {
                'id': id,
               'descp_perfil': descp_perfil
            },
            dataType: 'html',
            success: function (response) {
                ver_form_detalle_acceso.html('');


                $('#datosActualTXT').val('');
                $('#datosActualTXT').html(id_perfil);
                
                $('#datosrolTXT').val('');
                $('#datosrolTXT').html(descp_perfil);

                ver_form_detalle_acceso.html(response);

                $('#modal-form-acceso-rol').modal('show');
            }
        };

        $.ajax(_options);

    });






        var sampleData = initiateDemoData();//see below


        $('#tree1').ace_tree({
            dataSource: sampleData['dataSource1'],
            multiSelect: true,
            cacheItems: true,
            'open-icon': 'ace-icon tree-minus',
            'close-icon': 'ace-icon tree-plus',
            'itemSelect': true,
            'folderSelect': false,
            'selected-icon': 'ace-icon fa fa-check',
            'unselected-icon': 'ace-icon fa fa-times',
            loadingHTML: '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'
        });

        function initiateDemoData() {
            var tree_data = {
                'mantenimiento': {text: 'mantenimiento', type: 'folder',id:'1'},
                'vehicles': {text: 'Vehicles', type: 'folder'},
                'rentals': {text: 'Rentals', type: 'folder'},
                'real-estate': {text: 'Real Estate', type: 'folder'},
                'pets': {text: 'Pets', type: 'folder'},
                'tickets': {text: 'Tickets', type: 'item'},
                'services': {text: 'Services', type: 'item'},
                'personals': {text: 'Personals', type: 'item'}
            }
            tree_data['mantenimiento']['additionalParameters'] = {
                'children': {
                    'appliances': {text: 'Appliances', type: 'item',id:'2'},
                    'arts-crafts': {text: 'Arts & Crafts', type: 'item'},
                    'clothing': {text: 'Clothing', type: 'item'},
                    'computers': {text: 'Computers', type: 'item'},
                    'jewelry': {text: 'Jewelry', type: 'item'},
                    'office-business': {text: 'Office & Business', type: 'item'},
                    'sports-fitness': {text: 'Sports & Fitness', type: 'item'}
                }
            }
            tree_data['vehicles']['additionalParameters'] = {
                'children': {
                    'cars': {text: 'Cars', type: 'folder'},
                    'motorcycles': {text: 'Motorcycles', type: 'item'},
                    'boats': {text: 'Boats', type: 'item'}
                }
            }
            tree_data['vehicles']['additionalParameters']['children']['cars']['additionalParameters'] = {
                'children': {
                    'classics': {text: 'Classics', type: 'item'},
                    'convertibles': {text: 'Convertibles', type: 'item'},
                    'coupes': {text: 'Coupes', type: 'item'},
                    'hatchbacks': {text: 'Hatchbacks', type: 'item'},
                    'hybrids': {text: 'Hybrids', type: 'item'},
                    'suvs': {text: 'SUVs', type: 'item'},
                    'sedans': {text: 'Sedans', type: 'item'},
                    'trucks': {text: 'Trucks', type: 'item'}
                }
            }

            tree_data['rentals']['additionalParameters'] = {
                'children': {
                    'apartments-rentals': {text: 'Apartments', type: 'item'},
                    'office-space-rentals': {text: 'Office Space', type: 'item'},
                    'vacation-rentals': {text: 'Vacation Rentals', type: 'item'}
                }
            }
            tree_data['real-estate']['additionalParameters'] = {
                'children': {
                    'apartments': {text: 'Apartments', type: 'item'},
                    'villas': {text: 'Villas', type: 'item'},
                    'plots': {text: 'Plots', type: 'item'}
                }
            }
            tree_data['pets']['additionalParameters'] = {
                'children': {
                    'cats': {text: 'Cats', type: 'item'},
                    'dogs': {text: 'Dogs', type: 'item'},
                    'horses': {text: 'Horses', type: 'item'},
                    'reptiles': {text: 'Reptiles', type: 'item'}
                }
            }

            var dataSource1 = function (options, callback) {
                var $data = null
                if (!("text" in options) && !("type" in options)) {
                    $data = tree_data;//the root tree
                    callback({data: $data});
                    return;
                }
                else if ("type" in options && options.type == "folder") {
                    if ("additionalParameters" in options && "children" in options.additionalParameters)
                        $data = options.additionalParameters.children || {};
                    else
                        $data = {}//no data
                }

                if ($data != null)//this setTimeout is only for mimicking some random delay
                    setTimeout(function () {
                        callback({data: $data});
                    }, parseInt(Math.random() * 500) + 200);

                //we have used static data here
                //but you can retrieve your data dynamically from a server using ajax call
                //checkout examples/treeview.html and examples/treeview.js for more info
            }




            return {'dataSource1': dataSource1};
        }



});