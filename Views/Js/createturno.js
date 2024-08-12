
function showAlert(icon, title, message, confirm = false, urlConfirm = null, urlTurnos = null,urlNegation = null, ) {
    let messageCreate = "Crear turno";
    let messageNo = "Regresar";
    let messageOk = message;
    Swal.fire({
        icon: icon,
        title: title,
        text: message,
        showCancelButton: confirm,
        confirmButtonText: (!confirm) ? messageOk : messageCreate,
        cancelButtonText: messageNo,
    }).then((result) => {
        if (icon === "info") {
            Swal.close();
        }
        else
            if (result.isConfirmed) {
                createTurno(urlConfirm, urlTurnos);
            }
            else {
                window.location.href = urlNegation;
            }
    });
}


function createTurno(urlCreateTuno, urlTurnos) {
    $.ajax({
        url: urlCreateTuno,
        type: "POST",
        dataType: 'json',

        success: function (response) {
            // Maneja la respuesta si es necesario
            if (response.id) {
                Swal.close();
                const message = "Su turno es #" + response.id;
                Swal.fire({
                    title: "",
                    text: message,
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonText: "Sí",
                    cancelButtonText: "No"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario dice "Sí", realiza la petición
                        window.location.href = urlTurnos;
                    }
                });
            }
            else if (response.error) {
                Swal.close();
                const message = response.error;
                Swal.fire({
                    title: "",
                    text: message,
                    icon: "error"
                });

            }
        },
        error: function (error) {
            Swal.close();
            const message = "Ocurrio un error desconicodo";
            Swal.fire({
                title: "",
                text: message,
                icon: "error"
            });
        }
    });
}