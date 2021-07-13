
/*
 *  [ -----------------  FUNCIONES JAVASCRIPT  23102019 17:26 HRS  --------------------- ]
 */

            $(document).ready(function () {
                cargarcaracteristicas();
            });

function cargarcaracteristicas() {

        var opc  =  document.getElementById("tipsem_id").value;
//        var opc_formulacion  =  document.getElementById("form_id").value;
//        var opc_color  =  document.getElementById("col_id").value;
         var idsemiterminado  =  document.getElementById("idsemiterminado").value;
          var permiso  =  document.getElementById("permiso").value;


    



                if(opc != -1  ){
//                    if(opc_color == -1  && opc_formulacion != -1 ){
//                          alert("Debe seleccionar un color valido");
//                    }else if (opc_formulacion == -1 && opc_color != -1){
//
//                       alert("Debe seleccionar una formulacion valida.");
//                    }else if (opc_color == -1 && opc_formulacion == -1){
//                            alert("Debe seleccionar un color y una formulación.");
//                    }else{
                         cargarFormulario("cmbcaracteristicas", "index.php?page=artsemiterminado&accion=cargarportipsemi&id2="+opc+"&idsemiterminado="+idsemiterminado+"&permiso="+permiso);   
//                    }


                }

}

/*
 *  [ -----------------  FUNCIONES AJAX   --------------------- ]
 */

function nuevoAjax() {
    var xmlhttp = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function cargarFormulario(id, url) {
    var objDiv = document.getElementById(id);




    ajax = nuevoAjax();
    ajax.open("POST", url, true);
    ajax.onreadystatechange = function () {
        switch (ajax.readyState) {
            case 4:
                if (ajax.status == 200) {

                    objDiv.innerHTML = "";
                    objDiv.innerHTML = ajax.responseText;
                }
                else {
                    objDiv.innerHTML = 'Error 200';
                }
                break;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send();
}

