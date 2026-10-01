<?php

include 'dbconn.php';

$keyword = $_GET['q'] ?? '';
$keyword = trim($keyword);

if ($keyword == '') {
    exit;
}

$sql = "SELECT * FROM praktikum9
        WHERE judul LIKE :keyword
        ORDER BY CAST(no AS UNSIGNED)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':keyword' => '%' . $keyword . '%'
]);

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($result) == 0) {
    echo "<tr>";
    echo "<td colspan='6' style='text-align:center;'>Tidak ada publikasi yang ditemukan.</td>";
    echo "</tr>";
} else {
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td class='col-no'>" . htmlspecialchars($row['no']) . "</td>";
        echo "<td class='col-judul'>" . htmlspecialchars($row['judul']) . "</td>";
        echo "<td class='col-tgl'><span class='date-badge'>" . htmlspecialchars($row['tanggal_rilis']) . "</span></td>";
        echo "<td class='col-abstrak'>" . nl2br(htmlspecialchars($row['abstraksi'])) . "</td>";
        echo "<td class='col-sampul'><img class='img-thumbnail' src='asset/" . htmlspecialchars($row['sampul']) . "' alt='Sampul' onclick='zoomImage(this.src)'></td>";
        echo "<td class='col-aksi'>
                <div class='btn-action-group'>
                    <a class='btn-action btn-edit' href='page09E.php?no=" . urlencode($row['no']) . "&judul=" . urlencode($row['judul']) . "&tanggal_rilis=" . urlencode($row['tanggal_rilis']) . "&abstraksi=" . urlencode($row['abstraksi']) . "&sampul=" . urlencode($row['sampul']) . "'>Edit</a>
                    <a class='btn-action btn-delete' href='page09F.php?no=" . urlencode($row['no']) . "&sampul=" . urlencode($row['sampul']) . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                </div>
              </td>";
        echo "</tr>";
    }
}
?>