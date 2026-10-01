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

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Galeri Kegiatan</title>
<link rel="stylesheet" href="myCSS.css">
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
        <a href="page09C.php">Tambah Publikasi</a>
        <a class="active" href="page06E.php">Galeri Kegiatan</a>
        <a href="page_profil.php">Profil</a>
    </nav>
</header>

<div id="overlay" onclick="toggleMenu()"></div>

<main>
<h2>Galeri Kegiatan</h2>

<div class="galeri-container">

    <div class="preview-box">
        <button class="nav-btn left" onclick="prevImage()">❮</button>
        <img id="previewBesar" src="asset/kegiatan1.jpg">
        <button class="nav-btn right" onclick="nextImage()">❯</button>
    </div>

    <div class="thumbnail-box">
        <img src="asset/kegiatan1.jpg" class="active" onclick="gantiGambar(this)">
        <img src="asset/kegiatan2.jpg" onclick="gantiGambar(this)">
        <img src="asset/kegiatan3.jpg" onclick="gantiGambar(this)">
        <img src="asset/kegiatan4.jpg" onclick="gantiGambar(this)">
        <img src="asset/kegiatan5.jpg" onclick="gantiGambar(this)">
        <img src="asset/kegiatan6.jpg" onclick="gantiGambar(this)">
    </div>

</div>
</main>

<hr>

<address>
Created by Sawangi Kasturi <br>
222413778@stis.ac.id
</address>

<script>
let images = [
    "asset/kegiatan1.jpg",
    "asset/kegiatan2.jpg",
    "asset/kegiatan3.jpg",
    "asset/kegiatan4.jpg",
    "asset/kegiatan5.jpg",
    "asset/kegiatan6.jpg"
];

let index = 0;

function showImage(i) {
    index = i;
    document.getElementById("previewBesar").src = images[index];

    document.querySelectorAll(".thumbnail-box img").forEach((img, idx) => {
        img.classList.toggle("active", idx === index);
    });
}

function nextImage() {
    index = (index + 1) % images.length;
    showImage(index);
}

function prevImage() {
    index = (index - 1 + images.length) % images.length;
    showImage(index);
}

function gantiGambar(el) {
    const semua = document.querySelectorAll(".thumbnail-box img");

    semua.forEach((img, idx) => {
        if (img === el) {
            showImage(idx);
        }
    });
}

function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("show");
    document.getElementById("overlay").classList.toggle("show");
    document.querySelector(".hamburger").classList.toggle("hide");
}
</script>

</body>
</html>