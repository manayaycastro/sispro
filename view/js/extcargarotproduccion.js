
/*
 *  [ -----------------  FUNCIONES JAVASCRIPT   --------------------- ]
 */ 



$(document).ready(function() {
    cargardetalle();
});



function cargardetalle(){

    
    var tipdoc_id = document.getElementById("tipdoc_id").value;
     var tur_id = document.getElementById("tur_id").value;
    
  //  var optionsRadios = document.getElementById("optionsRadios").value;
    var resultado = $('input:radio[name=optionsRadios]:checked').val();
    
    
    
     var maq_id = document.getElementById("maq_id").value;
      var spinner = document.getElementById("spinner").value;
      var ot = document.getElementById("ot").value;

    
    if(tipdoc_id != -1 &&  tur_id != -1  ){
      
             cargarFormulario("detalle", "index.php?page=extordentrabajo&accion=cargardetalleProduccion&peine="+resultado+"&bajada="+spinner+"&ot="+ot);   
        }
              
    
    }
        

function nuevoAjax()  {  
    var xmlhttp=false;  
    try  {  
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");  
    }  
    catch (e)  {  
        try  {  
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");  
        }  
        catch (e)  {  
            xmlhttp = false;  
        }  
    }  
    if (!xmlhttp && typeof XMLHttpRequest!='undefined')  {  
        xmlhttp = new XMLHttpRequest();  
    }  
    return xmlhttp;  
}  

function cargarFormulario(id, url)  {  
    var objDiv = document.getElementById(id);  
    ajax = nuevoAjax();  
    ajax.open("GET", url, true);  
    ajax.onreadystatechange = function() {
        switch (ajax.readyState) {  
            case 4:
                if(ajax.status == 200)  {  
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

