<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Cost Tracking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
        }

        table th {
            background-color: #eeeeee;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>

<h2>Laporan Cost Tracking Maintenance Aset</h2>
<p>Sistem Informasi Monitoring Maintenance dan Cost Tracking Aset Perusahaan</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Aset</th>
            <th>Vendor</th>
            <th>Jenis Biaya</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php $total = 0; ?>
        <?php foreach ($cost as $row) : ?>
            <?php $total += $row['nominal']; ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?></td>
                <td><?= esc($row['nama_vendor'] ?? '-'); ?></td>
                <td><?= esc(str_replace('_', ' ', ucfirst($row['jenis_biaya']))); ?></td>
                <td><?= esc($row['deskripsi_biaya']); ?></td>
                <td><?= esc($row['tanggal_biaya']); ?></td>
                <td class="text-right">Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <th colspan="6" class="text-right">Total Biaya</th>
            <th class="text-right">Rp <?= number_format($total, 0, ',', '.'); ?></th>
        </tr>
    </tbody>
</table>

</body>
</html>