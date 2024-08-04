
function showAlert(icon, title, message, confirm = false) {
    let messageCreate = "Crear buque";
    let messageNo = "Cancelar";
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
            $('#molda-myModal').hide();
        }
        else
            if (result.isConfirmed) {
                $('#molda-myModal').hide();
                if (confirm) {
                    window.location.href = '<?= UrlHelper::getUrlBase() ?>/Views/Buques/index.php?action=create';
                }
            }
            else {
                $('#molda-myModal').hide();
            }
    });
}
