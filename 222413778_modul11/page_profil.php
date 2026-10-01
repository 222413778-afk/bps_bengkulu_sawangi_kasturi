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

$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="myCSS.css">
    <style>
        .profile-card {
            width: 80%;
            max-width: 480px;
            margin: 40px auto;
            background-color: #F2F2F2;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: left;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
        }

        .avatar-icon {
            width: 55px;
            height: 55px;
            background-color: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-icon svg {
            width: 32px;
            height: 32px;
            fill: #6b7280;
        }

        .profile-title {
            display: flex;
            flex-direction: column;
        }

        .profile-title h3 {
            margin: 0;
            color: #15803d; /* Warna hijau */
            font-size: 22px;
            font-weight: bold;
        }

        .profile-title span {
            color: #6b7280;
            font-size: 14px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 16px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #ccc;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-change-pass {
            display: block;
            padding: 12px;
            background-color: #3498db;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .btn-change-pass:hover {
            background-color: #02345a;
        }

        .btn-logout {
            display: block;
            padding: 12px;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }
    </style>
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
        <a href="page06E.php">Galeri Kegiatan</a>
        <a class="active" href="page_profil.php">Profil</a>
    </nav>
</header>

<div id="overlay" onclick="toggleMenu()"></div>

<main>
    <div class="profile-card">
        <div class="profile-header">
            <div class="avatar-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <div class="profile-title">
                <h3>Profil</h3>
            </div>
        </div>

        <div class="profile-info">
            <div class="info-item">
                <span class="info-label">Username:</span>
                <span><?= htmlspecialchars($user['username'] ?? $_SESSION['username']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Status Sesi:</span>
                <span style="color: green; font-weight: bold;">Aktif</span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="page_ganti_password.php" class="btn-change-pass">Ganti Password</a>
            <a href="page10B.php" class="btn-logout" onclick="return confirm('Apakah Anda yakin ingin logout?')">Logout</a>
        </div>
    </div>
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
</html>22