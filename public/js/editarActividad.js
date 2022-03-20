let funciones = {
    setResponsableActividad: function () {
        let idDepartamento = $('#departamento_responsable').val();
        
        if (idDepartamento != '') {
            $('#id_responsable').attr("disabled", true);
            $('#editarCredito').attr("disabled", true);
            $.ajax({
                type: "post",
                url: `/alumnos/creditos-complementarios/responsables-departamento/${idDepartamento}`,
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {},
                dataType: "json",
                success: function (response) {
                    $('#id_responsable').empty();
                    $.each(response.responsables, function(i, responsable){
                        $('#id_responsable').append(new Option(
                            `${responsable.nombre} ${responsable.apellido_paterno} ${responsable.apellido_materno ? responsable.apellido_materno : ''}`, 
                            responsable.id));
                    });
                    $('#id_responsable').val($('#idResponsable').val());
                    $('#id_responsable').attr("disabled", false);
                    $('#editarCredito').attr("disabled", false);
                }
            });
        } else {
            $('#id_responsable').empty();
        }
    },
    getSelectResponsables: function (e) {  
        e.preventDefault();
        let idDepartamento = $('#departamento_responsable').val();
        
        if (idDepartamento != '') {
            $('#id_responsable').attr("disabled", true);
            $('#editarCredito').attr("disabled", true);
            $.ajax({
                type: "post",
                url: `/alumnos/creditos-complementarios/responsables-departamento/${idDepartamento}`,
                headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                data: {},
                dataType: "json",
                success: function (response) {
                    $('#id_responsable').empty();
                    $.each(response.responsables, function(i, responsable){
                        $('#id_responsable').append(new Option(
                            `${responsable.nombre} ${responsable.apellido_paterno} ${responsable.apellido_materno ? responsable.apellido_materno : ''}`, 
                            responsable.id));
                    });
                    $('#id_responsable').attr("disabled", false);
                    $('#editarCredito').attr("disabled", false);
                }
            });
        } else {
            $('#id_responsable').empty();
        }
    },
    compararFechas: function () {
        if ($('#fecha_inicio').val() != '' && $('#fecha_fin').val() != '') {
            if (new Date($('#fecha_fin').val()) < new Date($('#fecha_inicio').val())) {
                new PNotify({ title: 'Error', text: 'La fecha de inicio debe ser menor a la fecha de termino', type: 'error' });
                $('#fecha_fin').val('');
            }
        }
    }
};

$(document).ready(function () {
    funciones.setResponsableActividad();
    $('#departamento_responsable').change(funciones.getSelectResponsables);
    $('#fecha_inicio').change(funciones.compararFechas);
    $('#fecha_fin').change(funciones.compararFechas);
});