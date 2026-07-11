<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Maintenance</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, p { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { border: 1px solid #000; padding: 6px; }
        table th { background-color: #eeeeee; }
    </style>
</head>
<body>

<h2>Laporan Maintenance Aset Perusahaan</h2>
<p>Sistem Informasi Monitoring Maintenance dan Cost Tracking Aset Perusahaan</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Aset</th>
            <th>Vendor</th>
            <th>Jenis Pekerjaan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Status</th>
            <th>Hasil Pekerjaan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($maintenance as $row) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($row['kode_aset']); ?> - <?= esc($row['nama_aset']); ?></td>
                <td><?= esc($row['nama_vendor'] ?? '-'); ?></td>
                <td><?= esc(str_replace('_', ' ', ucfirst($row['jenis_pekerjaan']))); ?></td>
                <td><?= esc($row['tanggal_mulai']); ?></td>
                <td><?= esc($row['tanggal_selesai'] ?? '-'); ?></td>
                <td><?= esc(ucfirst($row['status_pekerjaan'])); ?></td>
                <td><?= esc($row['hasil_pekerjaan'] ?? '-'); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>