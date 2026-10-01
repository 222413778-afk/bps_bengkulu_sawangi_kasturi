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
    <title>Ganti Password</title>
    <link rel="stylesheet" href="myCSS.css">
    <style>
        .password-card {
            width: 80%;
            max-width: 480px;
            margin: 40px auto;
            background-color: #F2F2F2;
            padding: 28px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: left;
        }

        .password-card h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #1f608b;
            text-align: center;
            font-size: 24px;
        }

        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-group-custom label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #374151;
            font-size: 14px;
        }

        .input-box-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-box-custom input {
            width: 100%;
            padding: 12px 42px 12px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: white;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
        }

        .input-box-custom input:focus {
            border-color: #3498db;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            fill: #555;
        }

        .btn-submit-pass {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #3498db;
            color: white;
            cursor: pointer;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-submit-pass:hover {
            background-color: #02345a;
        }

        .btn-back-profile {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #6c757d;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .btn-back-profile:hover {
            background-color: #5a6268;
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
    <div class="password-card">
        <h2>Ganti Password</h2>

        <form action="page_ganti_password_action.php" method="post">
            
            <div class="form-group-custom">
                <label for="old_pass">Password Lama:</label>
                <div class="input-box-custom">
                    <input type="password" id="old_pass" name="old_pass" placeholder="Masukkan password lama" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('old_pass', this)">
                        <svg class="eye-open" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="form-group-custom">
                <label for="new_pass">Password Baru:</label>
                <div class="input-box-custom">
                    <input type="password" id="new_pass" name="new_pass" placeholder="Masukkan password baru" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('new_pass', this)">
                        <svg class="eye-open" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="form-group-custom">
                <label for="confirm_pass">Konfirmasi Password Baru:</label>
                <div class="input-box-custom">
                    <input type="password" id="confirm_pass" name="confirm_pass" placeholder="Ulangi password baru" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('confirm_pass', this)">
                        <svg class="eye-open" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-submit-pass">Simpan Password Baru</button>
            <a href="page_profil.php" class="btn-back-profile">Kembali ke Profil</a>

        </form>
    </div>
</main>

<hr>

<address>
Created by Sawangi Kasturi <br>
222413778@stis.ac.id
</address>

<script>
function togglePasswordVisibility(inputId, toggleBtn) {
    const input = document.getElementById(inputId);
    const eyeOpenSvg = `<svg class="eye-open" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>`;
    const eyeClosedSvg = `<svg class="eye-closed" viewBox="0 0 24 24"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.44-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.17c0-1.66-1.34-3-3-3l-.17.02z"/></svg>`;

    if (input.type === "password") {
        input.type = "text";
        toggleBtn.innerHTML = eyeClosedSvg;
    } else {
        input.type = "password";
        toggleBtn.innerHTML = eyeOpenSvg;
    }
}

function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("show");
    document.getElementById("overlay").classList.toggle("show");
    document.querySelector(".hamburger").classList.toggle("hide");
}
</script>

</body>
</html>