<?php
include 'dbconn.php';

try {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>
            alert('Konfirmasi Password tidak cocok!');
            window.location='page_register.php';
        </script>";
        exit;
    }

    $stmtCheck = $pdo->prepare("SELECT * FROM user WHERE username = :username");
    $stmtCheck->execute([':username' => $username]);
    
    if ($stmtCheck->fetch()) {
        echo "<script>
            alert('Username sudah terdaftar! Gunakan username lain.');
            window.location='page_register.php';
        </script>";
        exit;
    }

    $stmtInsert = $pdo->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
    $stmtInsert->execute([
        ':username' => $username,
        ':password' => $password
    ]);

    echo "<script>
        alert('Registrasi Berhasil! Silakan Login.');
        window.location='page10A.php';
    </script>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>