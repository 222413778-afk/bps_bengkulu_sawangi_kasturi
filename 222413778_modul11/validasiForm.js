function validate06C() {

    const nomor = document.getElementById("no");
    const judul = document.getElementById("judul");
    const tanggal_rilis = document.getElementById("tanggal_rilis");
    const abstraksi = document.getElementById("abstraksi");

    let valid = true;

    resetError();

    if (nomor.value.trim() === "") {

        showError(nomor, "errorNomor", "Nomor tidak boleh kosong");
        valid = false;

    } else if (!/^[0-9]+$/.test(nomor.value.trim())) {

        showError(nomor, "errorNomor", "Masukkan nomor dalam angka");
        valid = false;

    }

    if (judul.value.trim() === "") {

        showError(judul, "errorJudul", "Judul tidak boleh kosong");
        valid = false;

    } else if (!/^[A-Za-z0-9\s:\-]+$/.test(judul.value.trim())) {

        showError(
            judul,
            "errorJudul",
            "Terdapat karakter yang tidak valid pada judul"
        );

        valid = false;

    }

    if (tanggal_rilis.value.trim() === "") {

        showError(
            tanggal_rilis,
            "errorTanggalRilis",
            "Tanggal rilis tidak boleh kosong"
        );

        valid = false;

    }

    if (abstraksi.value.trim() === "") {

        showError(
            abstraksi,
            "errorAbstraksi",
            "Abstraksi tidak boleh kosong"
        );

        valid = false;

    }

    return valid;
}

function showError(input, errorId, message) {
    const errorText = document.getElementById(errorId);
    const label = document.querySelector("label[for='" + input.id + "']");

    errorText.innerHTML = message;
    input.classList.add("error-input");
    label.classList.add("error-label");
}

function resetError() {
    const errorTexts = document.querySelectorAll(".error-text");
    const inputs = document.querySelectorAll("form input");
    const labels = document.querySelectorAll("form label");

    errorTexts.forEach(function(error) {
        error.innerHTML = "";
    });

    inputs.forEach(function(input) {
        input.classList.remove("error-input");
    });

    labels.forEach(function(label) {
        label.classList.remove("error-label");
    });
}