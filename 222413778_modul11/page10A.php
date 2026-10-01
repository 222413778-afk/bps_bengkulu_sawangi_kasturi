<?php
session_start();

if (isset($_SESSION['username']) || isset($_COOKIE['user_login'])) {
    if (!isset($_SESSION['username'])) {
        $_SESSION['username'] = $_COOKIE['user_login'];
    }
    header("Location: page09A.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BPS Bengkulu</title>
    <link rel="stylesheet" href="myCSS.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background-image:
                linear-gradient(
                    rgba(0, 91, 180, 0.82),
                    rgba(0, 30, 90, 0.92)
                ),
                url("asset/kegiatan1.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 100%;
            max-width: 380px;
            text-align: center;
            padding: 30px;
        }

        .logo {
            width: 75px;
            height: 75px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .title {
            font-size: 28px;
            letter-spacing: 3px;
            margin: 5px 0 20px;
            color: #fff;
            font-weight: 600;
        }

        .login-form {
            width: 100%;
        }

        .input-group {
            background: white;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 12px;
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group input {
            width: 100%;
            border: none;
            outline: none;
            padding: 15px 45px 15px 12px;
            font-size: 14px;
            background: white;
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

        .remember-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.85);
            padding: 8px 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .remember-left {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #000;
            font-size: 14px;
        }

        .forgot-link {
            color: #087ff5;
            font-size: 13px;
            text-decoration: none;
            font-weight: bold;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            border: none;
            border-radius: 5px;
            padding: 12px;
            background: #087ff5;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 5px;
        }

        .login-button:hover {
            background: #066ed3;
        }

        .register-link {
            margin-top: 15px;
            color: white;
            font-size: 14px;
        }

        .register-link a {
            color: #ffeb3b;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
        }
    </style>

</head>

<body>

    <div class="login-container">

        <img src="asset/logobpss.png" class="logo" alt="Logo BPS">

        <div class="title">LOGIN</div>

        <form method="POST" action="page10A_action.php" class="login-form">

            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                    <svg class="eye-open" viewBox="0 0 24 24">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                </span>
            </div>

            <div class="remember-group">
                <div class="remember-left">
                    <input type="checkbox" id="remember" name="remember" value="1">
                    <label for="remember">Ingat saya</label>
                </div>
                <a href="page_lupa_password.php" class="forgot-link">Lupa Password?</a>
            </div>

            <button type="submit" name="login" class="login-button">
                Sign in
            </button>

        </form>

        <div class="register-link">
            Belum punya akun? <a href="page_register.php">Daftar disini</a>
        </div>

        <div class="footer">
            © 2026 BPS Bengkulu
        </div>

    </div>

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
    </script>

</body>

</html>