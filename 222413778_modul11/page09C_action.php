<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: page10A.php");
    exit;
}

include 'dbconn.php';

try {

    // mengambil data dari form
    $no = $_POST['no'];
    $judul = $_POST['judul'];
    $tanggal_rilis = $_POST['tanggal_rilis'];
    $abstraksi = $_POST['abstraksi'];

    // upload file sampul
    $namaFile = $_FILES['sampul']['name'];
    $lokasiSementara = $_FILES['sampul']['tmp_name'];

    // folder tujuan upload
    $dirUpload = "asset/";

    // memindahkan file
    move_uploaded_file(
        $lokasiSementara, $dirUpload . $namaFile
    );

    // query insert
    $sql = "
    INSERT INTO praktikum9
    (
        no,
        judul,
        tanggal_rilis,
        abstraksi,
        sampul
    )
    VALUES
    (
        '$no',
        '$judul',
        '$tanggal_rilis',
        '$abstraksi',
        '$namaFile'
    )
    ";

    $pdo->query($sql);

    echo "
    <script>
        alert('Data Berhasil Ditambahkan');
        window.location='page09A.php';
    </script>
    ";

    $pdo = null;

}
catch(PDOException $e)
{
    exit(
        'PDO Error : ' .
        $e->getMessage()
    );
}

?>