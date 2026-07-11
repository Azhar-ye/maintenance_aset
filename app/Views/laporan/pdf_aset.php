<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Aset</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2, p { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { border: 1px solid #000; padding: 6px; }
        table th { background-color: #eeeeee; }
    </style>
</head>
<body>

<h2>Laporan Data Aset Perusahaan</h2>
<p>Sistem Informasi Monitoring Maintenance dan Cost Tracking Aset Perusahaan</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Aset</th>
            <th>Nama Aset</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Divisi</th>
            <th>Kondisi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($aset as $row) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($row['kode_aset']); ?></td>
                <td><?= esc($row['nama_aset']); ?></td>
                <td><?= esc($row['nama_kategori']); ?></td>
                <td><?= esc($row['nama_lokasi']); ?></td>
                <td><?= esc($row['nama_divisi']); ?></td>
                <td><?= esc(str_replace('_', ' ', ucfirst($row['kondisi']))); ?></td>
                <td><?= esc(ucfirst($row['status_aset'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>