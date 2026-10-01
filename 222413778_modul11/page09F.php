<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: page10A.php");
	exit;
}

include 'dbconn.php';
try{
$no = $_GET['no'];
$namaFile =
$_GET['sampul'];

unlink(
'asset/'.$namaFile
);

$sql =
"DELETE FROM praktikum9
WHERE no='$no'";

$pdo->query($sql);

echo "
<script>
alert('Data berhasil dihapus');
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