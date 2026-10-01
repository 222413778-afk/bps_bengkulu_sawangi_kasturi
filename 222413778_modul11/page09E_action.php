<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: page10A.php");
	exit;
}

include 'dbconn.php';
try{
$no = $_POST['no'];
$judul = $_POST['judul'];
$tanggal_rilis = $_POST['tanggal_rilis'];
$abstraksi = $_POST['abstraksi'];

if(
isset($_FILES['sampul_baru'])
&&
$_FILES['sampul_baru']['error'] === 0
){

$namaFile =
$_FILES['sampul_baru']['name'];

$lokasiSementara =
$_FILES['sampul_baru']['tmp_name'];

$dirUpload = "asset/";

move_uploaded_file(
$lokasiSementara,
$dirUpload.$namaFile
);

$sql = "
UPDATE praktikum9
SET
judul='$judul',
tanggal_rilis='$tanggal_rilis',
abstraksi='$abstraksi',
sampul='$namaFile'
WHERE no='$no'
";

}
else{

$sql = "
UPDATE praktikum9
SET
judul='$judul',
tanggal_rilis='$tanggal_rilis',
abstraksi='$abstraksi'
WHERE no='$no'
";

}

$pdo->query($sql);

echo "
<script>
alert('Data berhasil diubah');
window.location='page09A.php';
</script>
";

}
catch(PDOException $e){

exit(
'PDO Error : '
.$e->getMessage()
);

}

?>