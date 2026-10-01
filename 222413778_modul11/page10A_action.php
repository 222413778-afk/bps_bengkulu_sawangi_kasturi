<?php
session_start();
include 'dbconn.php';

try {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : null;

    $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);

    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time();

        if ($remember) {
            setcookie('user_login', $username, time() + 3600, "/");
        } else {
            setcookie('user_login', $username, time() + 3600, "/");
        }

        header("Location: page09A.php");
        exit;

    } else {
        echo "<script>
            alert('Username/Password Tidak Ditemukan atau Salah!');
            window.location='page10A.php';
        </script>";
    }

    $pdo = null;

} catch(PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>