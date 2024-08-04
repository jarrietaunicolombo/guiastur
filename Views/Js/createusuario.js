$(document).ready(function () {
    $('#user-form').submit(function (e) {
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
                    message = 'Usuario creado. ' + response.message;
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
    $('#user-form')[0].reset();
}

function showFormError(errorMessages) {
    $("#error-rol").text(errorMessages.buque ?? '');
    $("#error-email").text(errorMessages.pais ?? '');
    $("#error-nombre").text(errorMessages.arribo ?? '');
}