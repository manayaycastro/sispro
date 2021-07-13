
/*
 *  [ -----------------  FUNCIONES JAVASCRIPT  23102019 17:26 HRS  --------------------- ]
 */

            $(document).ready(function () {
                cargarcaracteristicas();
            });

function cargarcaracteristicas() {

        var opc  =  document.getElementById("tipmaq_id").value;
        var opc_maquina  =  document.getElementById("maq_id").value;

         var maqfamid  =  document.getElementById("maqfamid").value;
          var permiso  =  document.getElementById("permiso").value;


    



                if(opc != -1  ){

                         cargarFormulario("cmbcaracteristicas", "index.php?page=maquinafamilia&accion=cargarportipmaquina&id2="+opc+"&maqfamid="+maqfamid+"&permiso="+permiso);   

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

