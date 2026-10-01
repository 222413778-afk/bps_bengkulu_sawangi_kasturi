<?php
session_start();

// Hapus cookie remember me
if (isset($_COOKIE['user_login'])) {
    setcookie('user_login', '', time() - 3600, "/");
}

// Menghapus dan menghancurkan session
session_unset();
session_destroy();

// Arahkan kembali ke halaman login
header("Location: page10A.php");
exit;
?>