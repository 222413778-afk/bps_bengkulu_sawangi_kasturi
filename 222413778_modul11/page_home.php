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

include 'dbconn.php';


$domain = "1700";
$apiKey = "843cb284a888e07f9bb77bb19a152aa0";


$cacheFileBRS = 'bps_api_brs_cache.json';
$cacheTime = 3600;
$newsItems = [];

if (
    file_exists($cacheFileBRS) &&
    (time() - filemtime($cacheFileBRS) < $cacheTime)
) {

    $newsItems = json_decode(
        file_get_contents($cacheFileBRS),
        true
    );

} else {

    $apiUrlBRS =
        "https://webapi.bps.go.id/v1/api/list/model/pressrelease/domain/{$domain}/key/{$apiKey}/";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrlBRS);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);

    $responseBRS = curl_exec($ch);

    curl_close($ch);

    if ($responseBRS) {

        $dataBRS = json_decode($responseBRS, true);

        if (
            isset($dataBRS['status']) &&
            $dataBRS['status'] == 'OK' &&
            !empty($dataBRS['data'][1])
        ) {

            $articles = array_slice(
                $dataBRS['data'][1],
                0,
                6
            );

            foreach ($articles as $item) {

                $newsItems[] = [
                    'title' => $item['title']
                        ?? 'Berita Resmi BPS Bengkulu',

                    'date' => $item['rls_date']
                        ?? date('d F Y'),

                    'link' => $item['pdf']
                        ?? 'https://bengkulu.bps.go.id'
                ];
            }

            file_put_contents(
                $cacheFileBRS,
                json_encode($newsItems)
            );
        }
    }
}


if (empty($newsItems)) {

    $newsItems = [

        [
            'title' =>
            'Lalu lintas angkutan laut di Pelabuhan Pulau Baai tercatat 88 kapal, sedangkan di Bandara Fatmawati Soekarno terdapat 204 penerbangan berangkat dan 204 penerbangan datang',

            'date' => '1 September 2026',

            'link' => 'https://bengkulu.bps.go.id'
        ],

        [
            'title' =>
            'Pada Januari-Juli 2026 tercatat 4,43 juta perjalanan wisatawan nusantara (wisnus) menuju Provinsi Bengkulu',

            'date' => '1 September 2026',

            'link' => 'https://bengkulu.bps.go.id'
        ],

        [
            'title' =>
            'Nilai Tukar Petani (NTP) Provinsi Bengkulu pada Agustus 2026 sebesar 203,27 atau naik 1,54 persen',

            'date' => '1 September 2026',

            'link' => 'https://bengkulu.bps.go.id'
        ],

        [
            'title' =>
            'Total ekspor Provinsi Bengkulu Juli 2026 mencapai US$13,82 juta, sementara itu tidak ada impor yang tercatat ke Provinsi Bengkulu',

            'date' => '1 September 2026',

            'link' => 'https://bengkulu.bps.go.id'
        ],

        [
            'title' =>
            'Inflasi year-on-year (y-on-y) Provinsi Bengkulu Agustus 2026 sebesar 3,99 persen',

            'date' => '1 September 2026',

            'link' => 'https://bengkulu.bps.go.id'
        ],

        [
            'title' =>
            'Ekonomi Provinsi Bengkulu Triwulan II-2026 Secara Year on Year (Y-on-Y) Tumbuh Sebesar 5,11 Persen',

            'date' => '5 Agustus 2026',

            'link' => 'https://bengkulu.bps.go.id'
        ]

    ];
}

$cacheFileInd = 'bps_api_indicator_cache.json';
$indicators = [];

if (
    file_exists($cacheFileInd) &&
    (time() - filemtime($cacheFileInd) < $cacheTime)
) {

    $indicators = json_decode(
        file_get_contents($cacheFileInd),
        true
    );

} else {

    $apiUrlInd =
        "https://webapi.bps.go.id/v1/api/list/model/indicator/domain/{$domain}/key/{$apiKey}/";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrlInd);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);

    $responseInd = curl_exec($ch);

    curl_close($ch);

    if ($responseInd) {

        $dataInd = json_decode(
            $responseInd,
            true
        );

        if (
            isset($dataInd['status']) &&
            $dataInd['status'] == 'OK' &&
            !empty($dataInd['data'][1])
        ) {

            $indData = array_slice(
                $dataInd['data'][1],
                0,
                5
            );

            foreach ($indData as $ind) {

                $indicators[] = [

                    'title' =>
                        $ind['title'] ?? 'Indikator BPS',

                    'value' =>
                        $ind['value'] ?? '-',

                    'unit' =>
                        $ind['unit'] ?? ''
                ];
            }

            file_put_contents(
                $cacheFileInd,
                json_encode($indicators)
            );
        }
    }
}

if (empty($indicators)) {

    $indicators = [

        [
            'title' => 'Indeks Demokrasi Indonesia (IDI)',
            'value' => '79,66',
            'unit' => ''
        ],

        [
            'title' => 'Luas Panen Padi',
            'value' => '55.775',
            'unit' => 'Ha'
        ],

        [
            'title' => 'Jumlah Kecamatan',
            'value' => '129',
            'unit' => ''
        ],

        [
            'title' => 'Jumlah Desa/Kelurahan',
            'value' => '1.513',
            'unit' => ''
        ],

        [
            'title' => 'Luas Daerah',
            'value' => '20.122,21',
            'unit' => 'km²'
        ]

    ];
}

$stmtPublikasi = $pdo->query(
    "SELECT * FROM praktikum9 
     ORDER BY tanggal_rilis DESC, 
     CAST(no AS UNSIGNED) DESC 
     LIMIT 5"
);

$listPublikasi = $stmtPublikasi->fetchAll(
    PDO::FETCH_ASSOC
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Beranda - Badan Pusat Statistik Provinsi Bengkulu
    </title>

    <link
        rel="stylesheet"
        href="myCSS.css?v=10"
    >

    <style>

        body {
            background-color: #f1f5f9;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
        }


        /* Announcement Bar */

        .announcement-bar {
            background-color: #0091ea;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }


        .announcement-text {
            flex: 1;
            text-align: center;
            font-weight: 500;
        }


        .announcement-text a {
            color: #fff;
            font-weight: bold;
            text-decoration: underline;
        }


        .announcement-controls {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }


        .btn-close-ann {
            background: white;
            color: #0091ea;
            border: none;
            border-radius: 4px;
            padding: 2px 8px;
            cursor: pointer;
            font-weight: bold;
        }


        /* Hero Indicator Section */

        .indicator-hero {
            background-color: #0d47a1;
            padding: 35px 20px 20px;
            position: relative;
        }


        .indicator-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }


        .indicator-box {
            background: white;
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            min-height: 150px;
        }


        .indicator-icon {
            width: 38px;
            height: 38px;
            fill: #0091ea;
            margin-bottom: 8px;
        }


        .indicator-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
            line-height: 1.3;
            margin-bottom: 8px;
        }


        .indicator-num {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
        }


        .api-attribution-badge {
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            margin-top: 20px;
            padding-bottom: 5px;
            letter-spacing: 0.3px;
        }


        .api-attribution-badge strong {
            color: #ffeb3b;
        }

        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 15px;
        }


        .section-heading {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 20px;
            text-align: left;
        }

        .tabs-header {
            display: flex;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 25px;
            gap: 30px;
        }


        .tab-btn {
            background: none;
            border: none;
            padding: 10px 0;
            font-size: 15px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }


        .tab-btn.active {
            color: #0284c7;
            font-weight: bold;
        }


        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #0284c7;
        }


        .view-all-link {
            margin-left: auto;
            color: #0284c7;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            display: flex;
            align-items: center;
        }


        .tab-content {
            display: none;
        }


        .tab-content.active {
            display: block;
        }

        .brs-grid-2col {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }


        @media (max-width: 850px) {

            .brs-grid-2col {
                grid-template-columns: 1fr;
            }

        }


        .brs-card-horizontal {
            background: white;
            border-radius: 12px;
            padding: 18px;
            display: flex;
            gap: 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            text-decoration: none;
            transition: all 0.2s ease;
            align-items: flex-start;
            border: 1px solid #f1f5f9;
        }


        .brs-card-horizontal:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        }


        .brs-cover-img {
            width: 90px;
            height: 125px;
            object-fit: cover;
            border-radius: 4px;
            flex-shrink: 0;
            border: 1px solid #e2e8f0;
        }


        .brs-card-body {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: left;
        }


        .brs-date-text {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 500;
        }


        .brs-title-text {
            font-size: 15px;
            font-weight: bold;
            color: #0f172a;
            line-height: 1.45;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .list-item-card {
            background: white;
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: transform 0.2s;
            text-decoration: none;
        }


        .list-item-card:hover {
            transform: translateX(4px);
        }


        .item-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }


        .item-icon-bg {
            width: 42px;
            height: 42px;
            background-color: #0284c7;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }


        .item-icon-bg svg {
            width: 22px;
            height: 22px;
            fill: white;
        }


        .item-details {
            text-align: left;
        }


        .item-details h4 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #0f172a;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 700px;
        }


        .item-details span {
            font-size: 12px;
            color: #64748b;
            display: block;
            text-align: left;
        }


        .arrow-icon {
            color: #64748b;
            font-size: 18px;
            font-weight: bold;
        }

        .news-grid-horizontal {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(210px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }


        .news-card-v {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }


        .news-v-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }


        .news-v-body {
            padding: 15px;
            text-align: left;
        }


        .news-v-date {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 6px;
        }


        .news-v-title {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            line-height: 1.4;
        }

    </style>

</head>


<body>


<header>

    <div class="left-header">

        <img
            src="asset/logobpss.png"
            alt="Logo BPS"
        >

        <div class="judulweb">
            BPS PROVINSI BENGKULU
        </div>

    </div>


    <button
        type="button"
        class="hamburger"
        onclick="toggleMenu()"
    >
        ☰
    </button>


    <nav id="navMenu">

        <div class="nav-header">

            <img
                src="asset/logobpss.png"
                alt="Logo BPS"
            >

            <span>
                BPS PROVINSI BENGKULU
            </span>

        </div>


        <span
            class="close-btn"
            onclick="toggleMenu()"
        >
            ×
        </span>


        <a
            class="active"
            href="page_home.php"
        >
            Home
        </a>

        <a href="page09A.php">
            Daftar Publikasi
        </a>

        <a href="page09C.php">
            Tambah Publikasi
        </a>

        <a href="page06E.php">
            Galeri Kegiatan
        </a>

        <a href="page_profil.php">
            Profil
        </a>

    </nav>

</header>


<div
    id="overlay"
    onclick="toggleMenu()"
></div>


<main style="padding-top:0;">

    <div
        class="announcement-bar"
        id="annBar"
    >

        <div class="announcement-text">

            Publikasi Provinsi Bengkulu Website Resmi 2026
            sudah tersedia dan dapat diakses

            <a href="https://bengkulu.bps.go.id">
                disini
            </a>

        </div>


        <div class="announcement-controls">

            <button
                class="btn-close-ann"
                onclick="document.getElementById('annBar').style.display='none'"
            >
                x
            </button>

        </div>

    </div>

    <div class="indicator-hero">

        <div class="indicator-container">

            <?php foreach ($indicators as $ind): ?>

                <div class="indicator-box">

                    <svg
                        class="indicator-icon"
                        viewBox="0 0 24 24"
                    >

                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"
                        />

                    </svg>


                    <div class="indicator-title">

                        <?= htmlspecialchars(
                            $ind['title']
                        ); ?>

                    </div>


                    <div class="indicator-num">

                        <?= htmlspecialchars(
                            $ind['value']
                        ) . ' ' . htmlspecialchars(
                            $ind['unit']
                        ); ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>


        <div class="api-attribution-badge">

            Layanan ini menggunakan API

            <strong>
                Badan Pusat Statistik (BPS)
            </strong>

        </div>

    </div>

    <div class="main-container">

        <div class="section-heading">
            Informasi Terbaru
        </div>


        <div class="tabs-header">


            <button
                class="tab-btn active"
                onclick="switchTab('tab-brs', this)"
            >
                Berita Resmi Statistik
            </button>


            <button
                class="tab-btn"
                onclick="switchTab('tab-tabel', this)"
            >
                Tabel Statistik
            </button>


            <button
                class="tab-btn"
                onclick="switchTab('tab-publikasi', this)"
            >
                Publikasi
            </button>


            <a
                href="page09A.php"
                class="view-all-link"
            >
                Lihat Semua →
            </a>

        </div>


        <!-- ======================================
             TAB 1 : BERITA RESMI STATISTIK
        ======================================= -->

        <div
            id="tab-brs"
            class="tab-content active"
        >

            <div class="brs-grid-2col">

                <?php foreach (
                    $newsItems
                    as $index => $news
                ): ?>

                    <a
                        href="<?= htmlspecialchars(
                            $news['link']
                        ); ?>"
                        target="_blank"
                        class="brs-card-horizontal"
                    >


                        <img
                            src="asset/home<?= (
                                $index + 1
                            ); ?>.png"
                            class="brs-cover-img"
                            alt="Cover BRS <?= (
                                $index + 1
                            ); ?>"
                        >


                        <div class="brs-card-body">


                            <div class="brs-date-text">

                                <?= htmlspecialchars(
                                    $news['date']
                                ); ?>

                            </div>


                            <h4 class="brs-title-text">

                                <?= htmlspecialchars(
                                    $news['title']
                                ); ?>

                            </h4>


                        </div>


                    </a>

                <?php endforeach; ?>

            </div>

        </div>


        <!-- ======================================
             TAB 2 : TABEL STATISTIK
        ======================================= -->

        <div
            id="tab-tabel"
            class="tab-content"
        >


            <div class="list-item-card">

                <div class="item-left">


                    <div class="item-icon-bg">

                        <svg viewBox="0 0 24 24">

                            <path
                                d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"
                            />

                        </svg>

                    </div>


                    <div class="item-details">

                        <h4>
                            Kemiskinan Provinsi Bengkulu
                            Maret 2026
                        </h4>

                        <span>
                            9 September 2026 —
                            Kondisi Tempat Tinggal,
                            Kemiskinan
                        </span>

                    </div>


                </div>


                <span class="arrow-icon">
                    ›
                </span>

            </div>


            <div class="list-item-card">

                <div class="item-left">


                    <div class="item-icon-bg">

                        <svg viewBox="0 0 24 24">

                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"
                            />

                        </svg>

                    </div>


                    <div class="item-details">

                        <h4>
                            Nilai Ekspor Menurut
                            Pelabuhan Muat
                            (Juta US$)
                        </h4>

                        <span>
                            9 September 2026 —
                            Perdagangan Internasional
                        </span>

                    </div>


                </div>


                <span class="arrow-icon">
                    ›
                </span>

            </div>


        </div>


        <!-- ======================================
             TAB 3 : PUBLIKASI
        ======================================= -->

        <div
            id="tab-publikasi"
            class="tab-content"
        >


            <?php if (!empty($listPublikasi)): ?>


                <?php foreach (
                    $listPublikasi
                    as $pub
                ): ?>


                    <a
                        href="page09A.php"
                        class="list-item-card"
                    >


                        <div class="item-left">


                            <div class="item-icon-bg">

                                <svg viewBox="0 0 24 24">

                                    <path
                                        d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"
                                    />

                                </svg>

                            </div>


                            <div class="item-details">


                                <h4>

                                    <?= htmlspecialchars(
                                        $pub['judul']
                                    ); ?>

                                </h4>


                                <span>

                                    Tanggal Rilis:

                                    <?= htmlspecialchars(
                                        $pub['tanggal_rilis']
                                    ); ?>

                                    —

                                    Nomor:

                                    <?= htmlspecialchars(
                                        $pub['no']
                                    ); ?>

                                </span>


                            </div>


                        </div>


                        <span class="arrow-icon">
                            ›
                        </span>


                    </a>


                <?php endforeach; ?>


            <?php else: ?>


                <div class="list-item-card">

                    <div class="item-left">

                        <div class="item-details">

                            <h4>
                                Belum ada data publikasi
                                terdaftar.
                            </h4>

                        </div>

                    </div>

                </div>


            <?php endif; ?>


        </div>


        <!-- ======================================
             BERITA DAN SIARAN PERS BPS
        ======================================= -->

        <div style="margin-top: 45px;">


            <div
                class="section-heading"
                style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                "
            >


                <span>
                    Berita dan Siaran Pers BPS
                </span>


                <a
                    href="page06E.php"
                    style="
                        font-size: 14px;
                        color: #0284c7;
                        text-decoration: none;
                    "
                >
                    Lihat Semua →
                </a>


            </div>


            <div class="news-grid-horizontal">


                <div class="news-card-v">

                    <img
                        src="asset/kegiatan1.jpg"
                        class="news-v-img"
                        alt="Siaran Pers"
                    >


                    <div class="news-v-body">

                        <div class="news-v-date">
                            1 September 2026
                        </div>


                        <div class="news-v-title">
                            Siaran Pers BPS Provinsi Bengkulu
                            1 September 2026
                        </div>

                    </div>

                </div>


                <div class="news-card-v">

                    <img
                        src="asset/kegiatan2.jpg"
                        class="news-v-img"
                        alt="Foto BPS"
                    >


                    <div class="news-v-body">

                        <div class="news-v-date">
                            28 Agustus 2026
                        </div>


                        <div class="news-v-title">
                            Keberhasilan SE2026 Merupakan
                            Modal Kita Menuju Indonesia
                            Emas 2045
                        </div>

                    </div>

                </div>


                <div class="news-card-v">

                    <img
                        src="asset/kegiatan3.jpg"
                        class="news-v-img"
                        alt="Kuliah Umum"
                    >


                    <div class="news-v-body">

                        <div class="news-v-date">
                            27 Agustus 2026
                        </div>


                        <div class="news-v-title">
                            Kuliah Umum dan Penandatanganan
                            Perjanjian Kerja Sama BPS dan
                            FMIPA UNIB
                        </div>

                    </div>

                </div>


                <div class="news-card-v">

                    <img
                        src="asset/kegiatan4.jpg"
                        class="news-v-img"
                        alt="Sinergi BPS"
                    >


                    <div class="news-v-body">

                        <div class="news-v-date">
                            18 Agustus 2026
                        </div>


                        <div class="news-v-title">
                            Sinergi dan Kolaborasi Wujud
                            Komitmen Data Ekonomi Berkualitas
                        </div>

                    </div>

                </div>


            </div>

        </div>


    </div>


</main>


<hr>


<address>

    Layanan ini menggunakan API
    Badan Pusat Statistik (BPS)

    <br><br>

    Created by Sawangi Kasturi

    <br>

    222413778@stis.ac.id

</address>


<script>


function toggleMenu() {

    document
        .getElementById("navMenu")
        .classList
        .toggle("show");


    document
        .getElementById("overlay")
        .classList
        .toggle("show");


    document
        .querySelector(".hamburger")
        .classList
        .toggle("hide");

}


function switchTab(tabId, btn) {


    document
        .querySelectorAll('.tab-content')
        .forEach(content => {

            content.classList.remove('active');

        });


    document
        .querySelectorAll('.tab-btn')
        .forEach(button => {

            button.classList.remove('active');

        });


    document
        .getElementById(tabId)
        .classList
        .add('active');


    btn.classList.add('active');

}


</script>


</body>

</html>