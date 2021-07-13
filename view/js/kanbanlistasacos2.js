
/*
 *  [ -----------------  FUNCIONES JAVASCRIPT  12042020 17:26 HRS  --------------------- ]
 */

            $(document).ready(function () {
                
                
                
                cargarregistrossacos();
               
            });

function cargarregistrossacos() {

        var opc  =  document.getElementById("proroll_id").value;
         var procesos =  document.getElementById("procesos").value;
                if(opc != -1  ){
					
					
                      $('#listaavanceproduccionsacos').html('<center><img src="view/img/loading.gif"/></center>');   
                         cargarFormulario("listaavanceproduccionsacos", "index.php?page=kanban&accion=cargarlistasacosconv&cod="+opc+"&procesos="+procesos);   
					

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
// <input type="submit" value="Guardar" class="btn btn-success btn-next" data-last="Finish" id="guardardiseno">
