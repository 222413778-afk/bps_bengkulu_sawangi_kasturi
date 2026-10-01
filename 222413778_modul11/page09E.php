<?php
session_start();
// Jika user belum login, maka akan diarahkan kembali ke halaman login 
if (!isset($_SESSION['username'])) {
    header("Location: page10A.php");
    exit;
}

include 'dbconn.php';

$no = $_GET['no'] ?? '';
$stmt = $pdo->prepare("SELECT tanggal_rilis FROM praktikum9 WHERE no = :no");
$stmt->execute(['no' => $no]);
$publikasi = $stmt->fetch();

$tanggalRilis = $publikasi['tanggal_rilis'] ?? '';
$tanggal = DateTime::createFromFormat('Y-m-d', $tanggalRilis);
if (!$tanggal) {
    $tanggal = DateTime::createFromFormat('d/m/Y', $tanggalRilis);
}
$tanggalRilis = $tanggal ? $tanggal->format('Y-m-d') : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Publikasi</title>
    <link rel="stylesheet" href="myCSS.css">
    <script src="validasiForm.js?v=2"></script>
</head>

<body>

<main>
<h2>Formulir Ubah Data Publikasi</h2>

<form name="formEditPublikasi"
      onsubmit="return validate06C(true)"
      action="page09E_action.php"
      method="post"
      enctype="multipart/form-data">

    <div class="form-group">
        <label for="no">Nomor:</label>
        <div class="input-box">
            <input type="text" id="no" name="no" value="<?= htmlspecialchars($_GET['no'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly>
            <small class="error-text" id="errorNomor"></small>
        </div>
    </div>

    <div class="form-group">
        <label for="judul">Judul:</label>
        <div class="input-box">
            <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($_GET['judul'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <small class="error-text" id="errorJudul"></small>
        </div>
    </div>

    <div class="form-group">
        <label for="tanggal_rilis">Tanggal Rilis:</label>
        <div class="input-box">
            <input type="date" id="tanggal_rilis" name="tanggal_rilis" value="<?= htmlspecialchars($tanggalRilis, ENT_QUOTES, 'UTF-8'); ?>">
            <small class="error-text" id="errorTanggalRilis"></small>
        </div>
    </div>

    <div class="form-group">
        <label for="abstraksi">Abstraksi:</label>
        <div class="input-box">
            <textarea id="abstraksi" name="abstraksi" rows="5"><?= htmlspecialchars($_GET['abstraksi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            <small class="error-text" id="errorAbstraksi"></small>
        </div>
    </div>

    <div class="form-group">
        <label>Sampul Lama:</label>
        <div class="input-box sampul-lama-box">
            <img src="asset/<?= htmlspecialchars($_GET['sampul'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="sampul">Sampul Baru:</label>
        <div class="input-box">
            <input type="file" id="sampul" name="sampul_baru">
            <small class="error-text" id="errorSampul"></small>
        </div>
    </div>

    <div class="submit-box">
        <input type="submit" value="Ubah Data">
    </div>

</form>
</main>

</body>
</html>