function showSimpleAlert(icon, title, message, url = null) {
    Swal.fire({
        icon: icon,
        title: title,
        text: message,
        showCancelButton: false,
        confirmButtonText: 'Aceptar',
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then((result) => {
        if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop || result.dismiss === Swal.DismissReason.esc) {
            if (url) {
                window.location.href = url;
            }
            else {
                Swal.close();
            }
        }
    });
}

function showConfirmAlert(
    title,
    message,
    buttonOkLbl = 'Aceptar',
    buttonNoLbl = "Cancelar",
    urlok = null,
    urlno = null
) {
    Swal.fire({
        icon: "question",
        title: title,
        text: message,
        showCancelButton: true,
        confirmButtonText: buttonOkLbl,
        cancelButtonText: buttonNoLbl,
    }).then((result) => {
        if (result.isConfirmed) {
                window.location.href = urlok;
        }
        else  {
            window.location.href = urlno;
        }
    });
}
