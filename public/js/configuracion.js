$(document).ready(function () {

    var hay_mensaje = document.getElementById("tipo_men").value;

});
function MostrarFormContact(){
    if ($('#formcontac').is(':visible')) {
        document.getElementById("formcontac").hidden = true;
    } else {
        document.getElementById("formcontac").hidden = false;
    }
    
}