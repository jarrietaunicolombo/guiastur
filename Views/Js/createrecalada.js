$(document).ready(function () {
    $('#recalada-form').submit(function (e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                let message = "Error desconocido";
                if (response.id >= 1) {
                    message = 'Recalada creado con ID: ' + response.id;
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
       if(icon == "success"){
         cleanForm();
       }
    });
}

function cleanForm(){
    $('#recalada-form')[0].reset();
}

function showFormError(errorMessages){
    $("#error-buque").text(errorMessages.buque ?? '');
    $("#error-pais").text(errorMessages.pais ?? '');
    $("#error-arribo").text(errorMessages.arribo ?? '');
    $("#error-zarpe").text(errorMessages.zarpe ?? '');
    $("#error-turistas").text(errorMessages.turistas ?? '');
}