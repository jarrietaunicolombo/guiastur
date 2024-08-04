$(document).ready(function () {
    $('#atencion-form').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let message = "Error desconocido";
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.id >= 1) {
                    message = 'Atecion creado con ID: ' + response.id;
                    showAlert('success', 'Éxito', message, false);
                }
                else if (response.error) {
                    message = response.error;
                    showAlert('error', 'Error', message, false);
                    showFormError(response);
                }
                else {
                    message = "Error desconocido";
                    showAlert('error', 'Error', message, false);
                }
            },
            error: function (xhr, status, error) {
                showAlert('error', 'Error', message + ": " + error);
            }
        });
    });

    $('#fecha_inicio').on('change', function () {
        getEndDateAtencion();
    });

});

function showAlert(icon, title, message, confirm = false) {

    Swal.fire({
        icon: icon,
        title: title,
        text: message,
        showCancelButton: confirm,
        confirmButtonText: "OK",
        cancelButtonText: "Cancelar",
        allowOutsideClick: true,
    }).then((result) => {
        if (icon == "success") {
            cleanForm();
        }
    });
}

function cleanForm() {
    $('#atencion-form')[0].reset();
}

function showFormError(errorMessages) {
    $("#error-supervisor").text(errorMessages.supervisor ?? '');
    $("#error-inicio").text(errorMessages.inicio ?? '');
    $("#error-cierre").text(errorMessages.cierre ?? '');
    $("#error-turnos").text(errorMessages.turnos ?? '');
}

function getEndDateAtencion() {
    // Obtener la fecha de inicio
    const fechaInicio = $('#fecha_inicio').val();

    if (fechaInicio) {
        const fecha = new Date(fechaInicio);
        fecha.setHours(fecha.getHours() + 1);
        // Formatear la fecha para datetime-local
        const anio = fecha.getFullYear();
        const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Mes de 1-12
        const dia = String(fecha.getDate()).padStart(2, '0'); // Día de 1-31
        const horas = String(fecha.getHours()).padStart(2, '0'); // Horas de 0-23
        const minutos = String(fecha.getMinutes()).padStart(2, '0'); // Minutos de 0-59

        const fechaFormateada = `${anio}-${mes}-${dia}T${horas}:${minutos}`;

        // Establecer la fecha resultado
        $('#fecha_cierre').val(fechaFormateada);
    }
}