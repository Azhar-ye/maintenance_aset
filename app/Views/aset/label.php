<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Label QR Aset</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f5f6fa;
            padding:30px;
        }

        .label-card{
            width:350px;
            margin:auto;
            border:2px solid #000;
            border-radius:10px;
            background:#fff;
            padding:20px;
            text-align:center;
        }

        .asset-title{
            font-size:18px;
            font-weight:bold;
            margin-bottom:15px;
        }

        .asset-info{
            text-align:left;
            margin-top:15px;
        }

        .asset-info p{
            margin-bottom:6px;
            font-size:14px;
        }

        @media print {

            .no-print{
                display:none;
            }

            body{
                background:white;
                padding:0;
            }

            .label-card{
                border:2px solid black;
                margin-top:20px;
            }
        }

    </style>

</head>

<body>

<?php
    $detailUrl = base_url('/admin/aset/detail/' . $aset['id_aset']);

    $qrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data='
                . urlencode($detailUrl);
?>

<div class="label-card">

    <div class="asset-title">
        ASSET MANAGEMENT SYSTEM
    </div>

    <img src="<?= $qrImage; ?>" width="220">

    <div class="asset-info">

        <p>
            <strong>Kode :</strong>
            <?= esc($aset['kode_aset']); ?>
        </p>

        <p>
            <strong>Nama :</strong>
            <?= esc($aset['nama_aset']); ?>
        </p>

        <p>
            <strong>Status :</strong>
            <?= esc($aset['status_aset']); ?>
        </p>

    </div>

</div>

<div class="text-center mt-4 no-print">

    <button onclick="window.print()" class="btn btn-primary">
        Cetak Label QR
    </button>

    <a href="<?= base_url('/admin/aset/detail/' . $aset['id_aset']); ?>"
       class="btn btn-secondary">

        Kembali

    </a>

</div>

</body>
</html>