<?php
session_start();

if (!isset($_SESSION['username'])) {
    if (isset($_COOKIE['user_login'])) {
        $_SESSION['username'] = $_COOKIE['user_login'];
    } else {
        header("Location: page10A.php");
        exit;
    }
}

$_SESSION['last_activity'] = time();
setcookie('user_login', $_SESSION['username'], time() + 3600, "/");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Publikasi BPS Bengkulu</title>
    <link rel="stylesheet" href="myCSS.css?v=3">
    <script src="page11A_suggestion.js"></script>
    <style>
        body {
            background-color: #f8fafc;
        }

        .main-card {
            width: 65%;
            max-width: 1200px;
            margin: 30px auto;
            background: white;
            padding: 35px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Judul dibuat ke tengah agar lebih rapi */
        .title-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .title-section h2 {
            margin: 0;
            color: #0f172a;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .title-section p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        /* Container pencarian di kanan atas tabel */
        .search-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
            width: 320px;
            display: flex;
            align-items: center;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #cbd5e1;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .search-box input:focus {
            border-color: #0d9488;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 14px;
            width: 18px;
            height: 18px;
            fill: #64748b;
            pointer-events: none;
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: left;
            margin: 0;
        }

        /* Warna Header Table Diganti ke Teal Toska */
        .modern-table th {
            background: linear-gradient(135deg, #0f766e, #0d9488);
            color: white;
            padding: 14px 16px;
            font-weight: 600;
            border: none;
            text-align: center;
        }

        .modern-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
            border-left: none;
            border-right: none;
        }

        .modern-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background-color: #f0fdf4;
        }

        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }

        .col-no { width: 5%; text-align: center; font-weight: bold; }
        .col-judul { width: 22%; font-weight: 600; color: #0f172a; }
        .col-tgl { width: 13%; text-align: center; }
        .col-abstrak { width: 38%; text-align: justify; line-height: 1.5; color: #475569; }
        .col-sampul { width: 12%; text-align: center; }
        .col-aksi { width: 10%; text-align: center; }

        .date-badge {
            display: inline-block;
            background: #ccfbf1;
            color: #0f766e;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .img-thumbnail {
            width: 75px;
            height: 105px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.08);
        }

        .btn-action-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
        }

        .btn-action {
            display: inline-block;
            width: 70px;
            padding: 6px 0;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background-color: #e0f2fe;
            color: #0284c7;
        }

        .btn-edit:hover {
            background-color: #0284c7;
            color: white;
        }

        .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background-color: #dc2626;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 99999;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            max-width: 90%;
            max-height: 85%;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.5);
        }
    </style>
</head>

<body>

<?php include 'dbconn.php'; ?>

<header>
    <div class="left-header">
        <img src="asset/logobpss.png" alt="Logo">
        <div class="judulweb">BPS PROVINSI BENGKULU</div>
    </div>

    <button type="button" class="hamburger" onclick="toggleMenu()">☰</button>

    <nav id="navMenu">
        <div class="nav-header">
            <img src="asset/logobpss.png" alt="Logo BPS">
            <span>BPS PROVINSI BENGKULU</span>
        </div>

        <span class="close-btn" onclick="toggleMenu()">×</span>

        <a href="page_home.php">Home</a>
        <a class="active" href="page09A.php">Daftar Publikasi</a>
        <a href="page09C.php">Tambah Publikasi</a>
        <a href="page06E.php">Galeri Kegiatan</a>
        <a href="page_profil.php">Profil</a>
    </nav>
</header>

<div id="overlay" onclick="toggleMenu()"></div>

<main>
    <div class="main-card">
        <!-- Judul halaman dibuat ke tengah -->
        <div class="title-section">
            <h2>Daftar Publikasi BPS Provinsi Bengkulu</h2>
            <p>Kelola dan tinjau seluruh informasi publikasi resmi BPS Bengkulu</p>
        </div>

        <!-- Box pencarian di kanan atas tabel -->
        <div class="search-container">
            <div class="search-box">
                <svg class="search-icon" viewBox="0 0 24 24">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                <input
                    type="text"
                    id="search"
                    onkeyup="showHint(this.value)"
                    placeholder="Cari publikasi..."
                >
            </div>
        </div>

        <div id="suggestion"></div>

        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-judul">Judul</th>
                        <th class="col-tgl">Tanggal Rilis</th>
                        <th class="col-abstrak">Abstraksi</th>
                        <th class="col-sampul">Sampul</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody id="publicationRows">
                    <?php
                    $result = $pdo->query(
                        "SELECT * FROM praktikum9 ORDER BY CAST(no AS UNSIGNED)"
                    );

                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td class='col-no'>" . htmlspecialchars($row['no']) . "</td>";
                        echo "<td class='col-judul'>" . htmlspecialchars($row['judul']) . "</td>";
                        echo "<td class='col-tgl'><span class='date-badge'>" . htmlspecialchars($row['tanggal_rilis']) . "</span></td>";
                        echo "<td class='col-abstrak'>" . nl2br(htmlspecialchars($row['abstraksi'])) . "</td>";
                        echo "<td class='col-sampul'>
                                <img class='img-thumbnail' src='asset/" . htmlspecialchars($row['sampul']) . "'
                                alt='Sampul' onclick='zoomImage(this.src)'>
                              </td>";
                        echo "<td class='col-aksi'>
                                <div class='btn-action-group'>
                                    <a class='btn-action btn-edit' href='page09E.php?
                                    no=" . urlencode($row['no']) . "
                                    &judul=" . urlencode($row['judul']) . "
                                    &tanggal_rilis=" . urlencode($row['tanggal_rilis']) . "
                                    &abstraksi=" . urlencode($row['abstraksi']) . "
                                    &sampul=" . urlencode($row['sampul']) . "'>
                                    Edit
                                    </a>

                                    <a class='btn-action btn-delete' href='page09F.php?
                                    no=" . urlencode($row['no']) . "
                                    &sampul=" . urlencode($row['sampul']) . "'
                                    onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                    Hapus
                                    </a>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="imgModal" class="modal" onclick="this.style.display='none'">
    <img class="modal-content" id="imgModalSrc">
</div>

<hr>

<address>
Created by Sawangi Kasturi <br>
222413778@stis.ac.id
</address>

<script>
function toggleMenu() {
    document.getElementById("navMenu").classList.toggle("show");
    document.getElementById("overlay").classList.toggle("show");
    document.querySelector(".hamburger").classList.toggle("hide");
}

function zoomImage(src) {
    document.getElementById("imgModalSrc").src = src;
    document.getElementById("imgModal").style.display = "flex";
}
</script>

</body>
</html>