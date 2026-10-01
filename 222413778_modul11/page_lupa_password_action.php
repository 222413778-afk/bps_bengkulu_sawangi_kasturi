<?php
include 'dbconn.php';

try {
    $username = trim($_POST['username']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>
            alert('Password Baru dan Konfirmasi Password tidak cocok!');
            window.location='page_lupa_password.php';
        </script>";
        exit;
    }

    //
    $stmtCheck = $pdo->prepare("SELECT * FROM user WHERE username = :username");
    $stmtCheck->execute([':username' => $username]);
    
    if (!$stmtCheck->fetch()) {
        echo "<script>
            alert('Username tidak ditemukan!');
            window.location='page_lupa_password.php';
        </script>";
        exit;
    }

    // 
    $stmtUpdate = $pdo->prepare("UPDATE user SET password = :password WHERE username = :username");
    $stmtUpdate->execute([
        ':password' => $new_password,
        ':username' => $username
    ]);

    echo "<script>
        alert('Password berhasil diperbarui! Silakan Login.');
        window.location='page10A.php';
    </script>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>