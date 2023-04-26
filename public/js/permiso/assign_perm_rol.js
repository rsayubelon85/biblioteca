


/*$(function(){
    $('#select-roles').on('change',onSelectRolChange);
    
});

function onSelectRolChange(){
    var rol_id = $(this).val();

    //AJAX
    $.get('permisos/'+rol_id+'/perm',function(data){
        var varhtml = ''
        data.forEach(element => {
            varhtml += '<td><input type="checkbox" class="form-check-input ck" id="chboxpermiso" name="array_perm[]" style="transform: scale(1.5)" value="'+ element.id +'" '+element.activo+'"/></td>';
            varhtml += '<td>'+element.name+'</td> ';
        });
        $('#permisos').html(varhtml);
    });
}*/

