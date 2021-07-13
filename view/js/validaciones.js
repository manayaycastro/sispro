

function soloLetras(e) {
        key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toUpperCase();
                letras = " ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
                especiales = "8-37-39-46";
                tecla_especial = false;
                for (var i in especiales) 
                {
                    if (key == especiales[i]) 
                    {
                    tecla_especial = true;
                            break;
                    }
                }
               
        if (letras.indexOf(tecla) == - 1 && !tecla_especial) {
        return false;
        
        }
            
            
    }

        function soloNumeros(e) {
        key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toUpperCase();
                letras = "1234567890";
                especiales = "8-37-39-46";
                tecla_especial = false;
                for (var i in especiales) {
        if (key == especiales[i]) {
        tecla_especial = true;
                break;
        }
        }

        if (letras.indexOf(tecla) == - 1 && !tecla_especial) {
        return false;
        }
        }

        function NumeroLetras(e) {
        key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toUpperCase();
                letras = " ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890.-,'";
                especiales = "8-37-39-46";
                tecla_especial = false;
                for (var i in especiales) {
        if (key == especiales[i]) {
        tecla_especial = true;
                break;
        }
        }

        if (letras.indexOf(tecla) == - 1 && !tecla_especial) {
        return false;
        }
        }
