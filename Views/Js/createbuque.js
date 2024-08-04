
$(document).ready(function () {
    $('#buque-form').submit(function (e) {
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
                    message = 'Buque creado con ID: ' + response.id;
                    showAlert('success', 'Éxito', message, false);
                    cleanForm();
                }
                else if (response.error) {
                    message = response.error;
                    showAlert('error', 'Error', message, false);
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

    $(window).click(function (event) {
        if (event.target.id === 'molda-myModal') {
            $('#molda-myModal').hide();
        }
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
    }).then((result) => {
        $('#molda-myModal').hide();
    });
}

function cleanForm() {
    $('#buque-form')[0].reset();
}

document.getElementById('hamburger').addEventListener('click', function () {
    var menu = document.getElementById('menu');
    if (menu.style.left === '0px') {
        menu.style.left = '-250px';
    } else {
        menu.style.left = '0px';
    }
});
