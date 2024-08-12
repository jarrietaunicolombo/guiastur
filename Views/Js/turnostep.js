$(document).ready(function () {
    let turnoNumero = 0;
    $('.molda-row').click(function () {
        let turnoId = $(this).data('id');
        turnoNumero = $(this).data('numero');
        let guiaNombre = $(this).data('nombre');
        let atencionId = $(this).data('atencion');

        $('#molda-id_turno').val(turnoId);
        $('#molda-id_atencion').val(atencionId);
        $('#molda-modalGuia').text('GUIA: ' + guiaNombre);
        $('#molda-modalTurno').text('TURNO NUMERO: ' + turnoNumero);
        $('#molda-myModal').show();
    });

    $('.molda-use').click(function () {
        $('#molda-action').val(action);
        $('#molda-turnoForm').submit();
    });

    $('.molda-cancel').click(function () {
        $('#molda-action').val('cancelarturno');
        $('#molda-turnoForm').submit();
    });

    $('#molda-turnoForm').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                let msg = "Error desconocido";
                if (response.estado === turnoStatus) {
                    msg = message + turnoNumero;
                    $('#molda-myModal').hide();
                    showSimpleAlert('success', 'Éxito', msg, url);
                }
                else if (response.error) {
                    msg = response.error;
                    $('#molda-myModal').hide();
                     showSimpleAlert('warning', 'Error', msg, url);
                }
                else {
                    msg = "Error desconocido";
                    $('#molda-myModal').hide();
                    showSimpleAlert('error', 'Error', msg, url);
                }
            },
            error: function (xhr, status, error) {
                $('#molda-myModal').hide();
                showSimpleAlert('error', 'Error', error, url);
            }
        });
    });

    $(window).click(function (event) {
        if (event.target.id === 'molda-myModal') {
            $('#molda-myModal').hide();
        }
    });

});