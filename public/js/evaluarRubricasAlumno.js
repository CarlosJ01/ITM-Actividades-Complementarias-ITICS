$(document).ready(function () {
    $('.criterio1').change(function (e) { 
        e.preventDefault();
        suma("1");
    });
    $('.criterio2').change(function (e) { 
        e.preventDefault();
        suma("2");
    });
    $('.criterio3').change(function (e) { 
        e.preventDefault();
        suma("3");
    });
    $('.criterio4').change(function (e) { 
        e.preventDefault();
        suma("4");
    });
    $('.criterio5').change(function (e) { 
        e.preventDefault();
        suma("5");
    });
});

function suma(clase){
    var sum=0;
    var inputs = $('.criterio'+clase).find('input');
    for(i=0; i<inputs.length; i++){
        if(inputs[i].checked){
            inp=parseInt(inputs[i]['value']);
            sum+=inp;
        }
    }
    let promedio = (sum/7).toFixed(2)
        $('#showValor'+clase).text(promedio);
        $('#valor'+clase).val(promedio);
    
        if (promedio >= 0.00 && promedio <= 0.99) {
            $('#showNivel'+clase).text('Insuficiente');
        } else {
            if (promedio >= 1.00 && promedio <= 1.49) {
                $('#showNivel'+clase).text('Suficiente');
            } else {
                if (promedio >= 1.50 && promedio <= 2.49) {
                    $('#showNivel'+clase).text('Bueno');
                } else {
                    if (promedio >= 2.50 && promedio <= 3.49) {
                        $('#showNivel'+clase).text('Notable');
                    } else {
                        if (promedio >= 3.50 && promedio <= 4.00) {
                            $('#showNivel'+clase).text('Excelente');
                        }
                    }
                }
            }
        }
}