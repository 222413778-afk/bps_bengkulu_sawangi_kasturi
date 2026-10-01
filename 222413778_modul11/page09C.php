<?php
session_start();

if (!isset($_SESSION['username'])) {
    if (isset($_COOKIE['user_login'])) {
        $_SESSION['username'] = $_COOKIE['user_login'];
    } else {
        header("Location: page10A.php");
        exit;
    }
}

$_SESSION['last_activity'] = time();
setcookie('user_login', $_SESSION['username'], time() + 3600, "/");

include 'dbconn.php';

$stmtNum = $pdo->query("SELECT MAX(CAST(no AS UNSIGNED)) AS max_no FROM praktikum9");
$rowNum = $stmtNum->fetch();
$nextNo = ($rowNum['max_no']) ? ((int)$rowNum['max_no'] + 1) : 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Publikasi</title>
    <link rel="stylesheet" href="myCSS.css">
    <script src="validasiForm.js?v=2"></script>
</head>

<body>

<header>
    <div class="left-header">
        <img src="asset/logobpss.png" alt="Logo BPS">
        <div class="judulweb">BPS PROVINSI BENGKULU</div>
    </div>

    <button type="button" class="hamburger" onclick="toggleMenu()">☰</button>

    <nav id="navMenu">
        <div class="nav-header">
            <img src="asset/logobpss.png" alt="Logo BPS">
            <span>BPS PROVINSI BENGKULU</span>
        </div>

        <span class="close-btn" onclick="toggleMenu()">×</span>

        <a href="page_home.php">Home</a>
        <a href="page09A.php">Daftar Publikasi</a>
        <a class="active" href="page09C.php">Tambah Publikasi</a>
        <a href="page06E.php">Galeri Kegiatan</a>
        <a href="page_profil.php">Profil</a>
    </nav>
</header>

<div id="overlay" onclick="toggleMenu()"></div>

<main>
    <h2>Form Menambahkan Publikasi Baru</h2>

    <form name="formTambahPublikasi"
      onsubmit="return validate06C(false)"
      action="page09C_action.php"
      method="post"
      enctype="multipart/form-data">

        <div class="form-group">
            <label for="no">Nomor:</label>
            <div class="input-box">
                <select id="no" name="no" style="width: 100%; padding: 13px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;">
                    <?php 
                    for ($i = $nextNo; $i < $nextNo + 5; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>
                <small class="error-text" id="errorNomor"></small>
            </div>
        </div>

        <div class="form-group">
            <label for="judul">Judul:</label>
            <div class="input-box">
                <input type="text" id="judul" name="judul">
                <small class="error-text" id="errorJudul"></small>
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal_rilis">Tanggal Rilis:</label>
            <div class="input-box">
                <input type="date"
                       id="tanggal_rilis"
                       name="tanggal_rilis">
                <small class="error-text" id="errorTanggalRilis"></small>
            </div>
        </div>

        <div class="form-group">
            <label for="abstraksi">Abstraksi:</label>
            <div class="input-box">
                <textarea id="abstraksi" name="abstraksi" rows="5"></textarea>
                <small class="error-text" id="errorAbstraksi"></small>
            </div>
        </div>

        <div class="form-group">
            <label for="sampul">Sampul:</label>
            <div class="input-box">
                <input type="file"
                       id="sampul"
                       name="sampul">
                <small class="error-text" id="errorSampul"></small>
            </div>
        </div>

        <div class="submit-box">
            <input type="submit" value="Tambah">
        </div>

    </form>

</main>

<hr>

<address>
Created by Sawangi Kasturi <br>
222413778@stis.ac.id
</address>

<script>
function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("show");
    document.getElementById("overlay").classList.toggle("show");
    document.querySelector(".hamburger").classList.toggle("hide");
}
</script>

</body>
</html>