<?php
session_start();
include 'dbconn.php';

if (!isset($_SESSION['username'])) {
    header("Location: page10A.php");
    exit;
}

try {
    $username = $_SESSION['username'];
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if ($new_pass !== $confirm_pass) {
        echo "<script>
            alert('Password Baru dan Konfirmasi Password tidak cocok!');
            window.location='page_ganti_password.php';
        </script>";
        exit;
    }

    // Verifikasi password lama
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = :username AND password = :old_pass");
    $stmt->execute([
        ':username' => $username,
        ':old_pass' => $old_pass
    ]);

    if (!$stmt->fetch()) {
        echo "<script>
            alert('Password lama Anda salah!');
            window.location='page_ganti_password.php';
        </script>";
        exit;
    }

    // Update password baru
    $updateStmt = $pdo->prepare("UPDATE user SET password = :new_pass WHERE username = :username");
    $updateStmt->execute([
        ':new_pass' => $new_pass,
        ':username' => $username
    ]);

    echo "<script>
        alert('Password berhasil diperbarui!');
        window.location='page09A.php';
    </script>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>