function showHint(str) {

    var rows = document.getElementById("publicationRows");

    if (str.length == 0) {
        location.reload();
        return;
    }

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            rows.innerHTML = this.responseText;

        }

    };

    xmlhttp.open(
        "GET",
        "page11A_gethint.php?q=" + encodeURIComponent(str),
        true
    );

    xmlhttp.send();

}