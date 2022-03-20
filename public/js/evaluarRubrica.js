$(document).ready(function () {
    $('.criterio').change(function (e) { 
        e.preventDefault();
        /* Promedio de los criterios */
        let suma = parseInt($('input:radio[name=criterio_1]:checked').val());
        suma += parseInt($('input:radio[name=criterio_2]:checked').val());
        suma += parseInt($('input:radio[name=criterio_3]:checked').val());
        suma += parseInt($('input:radio[name=criterio_4]:checked').val());
        suma += parseInt($('input:radio[name=criterio_5]:checked').val());
        suma += parseInt($('input:radio[name=criterio_6]:checked').val());
        suma += parseInt($('input:radio[name=criterio_7]:checked').val());

        let promedio = (suma/7).toFixed(2)
        $('#showValor').text(promedio);
        $('#valor').val(promedio);

        /* Calcular el nivel de desempeño */
        if (promedio >= 0.00 && promedio <= 0.99) {
            $('#showNivel').text('Insuficiente');
        } else {
            if (promedio >= 1.00 && promedio <= 1.49) {
                $('#showNivel').text('Suficiente');
            } else {
                if (promedio >= 1.50 && promedio <= 2.49) {
                    $('#showNivel').text('Bueno');
                } else {
                    if (promedio >= 2.50 && promedio <= 3.49) {
                        $('#showNivel').text('Notable');
                    } else {
                        if (promedio >= 3.50 && promedio <= 4.00) {
                            $('#showNivel').text('Excelente');
                        }
                    }
                }
            }
        }
    });
});