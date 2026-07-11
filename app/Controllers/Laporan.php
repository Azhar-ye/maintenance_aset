<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\AsetModel;
use App\Models\MaintenanceModel;
use App\Models\CostTrackingModel;

class Laporan extends BaseController
{
    public function aset()
    {
        $filters = [
            'keyword'     => $this->request->getGet('keyword'),
            'id_kategori' => $this->request->getGet('id_kategori'),
            'id_lokasi'   => $this->request->getGet('id_lokasi'),
            'id_divisi'   => $this->request->getGet('id_divisi'),
            'kondisi'     => $this->request->getGet('kondisi'),
            'status_aset' => $this->request->getGet('status_aset')
        ];

        $db = db_connect();

        $data = [
            'title' => 'Laporan Aset',
            'aset' => $this->getAsetData($filters),

            'kategori' => $db->table('kategori_aset')
                ->orderBy('nama_kategori', 'ASC')
                ->get()
                ->getResultArray(),

            'lokasi' => $db->table('lokasi')
                ->orderBy('nama_lokasi', 'ASC')
                ->get()
                ->getResultArray(),

            'divisi' => $db->table('divisi')
                ->orderBy('nama_divisi', 'ASC')
                ->get()
                ->getResultArray(),

            'keyword'     => $filters['keyword'],
            'id_kategori' => $filters['id_kategori'],
            'id_lokasi'   => $filters['id_lokasi'],
            'id_divisi'   => $filters['id_divisi'],
            'kondisi'     => $filters['kondisi'],
            'status_aset' => $filters['status_aset']
        ];

        return view('laporan/aset', $data);
    }

    private function getAsetData($filters = [])
    {
        $asetModel = new AsetModel();

        $builder = $asetModel
            ->select('aset.*, kategori_aset.nama_kategori, lokasi.nama_lokasi, divisi.nama_divisi')
            ->join('kategori_aset', 'kategori_aset.id_kategori = aset.id_kategori', 'left')
            ->join('lokasi', 'lokasi.id_lokasi = aset.id_lokasi', 'left')
            ->join('divisi', 'divisi.id_divisi = aset.id_divisi', 'left');

        if (!empty($filters['keyword'])) {
            $builder->groupStart()
                ->like('aset.kode_aset', $filters['keyword'])
                ->orLike('aset.nama_aset', $filters['keyword'])
                ->orLike('kategori_aset.nama_kategori', $filters['keyword'])
                ->orLike('lokasi.nama_lokasi', $filters['keyword'])
                ->orLike('divisi.nama_divisi', $filters['keyword'])
                ->groupEnd();
        }

        if (!empty($filters['id_kategori'])) {
            $builder->where('aset.id_kategori', $filters['id_kategori']);
        }

        if (!empty($filters['id_lokasi'])) {
            $builder->where('aset.id_lokasi', $filters['id_lokasi']);
        }

        if (!empty($filters['id_divisi'])) {
            $builder->where('aset.id_divisi', $filters['id_divisi']);
        }

        if (!empty($filters['kondisi'])) {
            $builder->where('aset.kondisi', $filters['kondisi']);
        }

        if (!empty($filters['status_aset'])) {
            $builder->where('aset.status_aset', $filters['status_aset']);
        }

        return $builder
            ->orderBy('aset.id_aset', 'ASC')
            ->findAll();
    }

    public function maintenance()
    {
        $filters = [
            'keyword'           => $this->request->getGet('keyword'),
            'jenis_pekerjaan'   => $this->request->getGet('jenis_pekerjaan'),
            'status_pekerjaan'  => $this->request->getGet('status_pekerjaan'),
            'tanggal_awal'      => $this->request->getGet('tanggal_awal'),
            'tanggal_akhir'     => $this->request->getGet('tanggal_akhir')
        ];

        $data = [
            'title' => 'Laporan Maintenance',
            'maintenance' => $this->getMaintenanceData($filters),

            'keyword'          => $filters['keyword'],
            'jenis_pekerjaan'  => $filters['jenis_pekerjaan'],
            'status_pekerjaan' => $filters['status_pekerjaan'],
            'tanggal_awal'     => $filters['tanggal_awal'],
            'tanggal_akhir'    => $filters['tanggal_akhir']
        ];

        return view('laporan/maintenance', $data);
    }

    private function getMaintenanceData($filters = [])
    {
        $maintenanceModel = new MaintenanceModel();

        $builder = $maintenanceModel
            ->select('maintenance.*, aset.kode_aset, aset.nama_aset, vendor.nama_vendor')
            ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
            ->join('vendor', 'vendor.id_vendor = maintenance.id_vendor', 'left');

        if (!empty($filters['keyword'])) {
            $builder->groupStart()
                ->like('aset.kode_aset', $filters['keyword'])
                ->orLike('aset.nama_aset', $filters['keyword'])
                ->orLike('vendor.nama_vendor', $filters['keyword'])
                ->groupEnd();
        }

        if (!empty($filters['jenis_pekerjaan'])) {
            $builder->where('maintenance.jenis_pekerjaan', $filters['jenis_pekerjaan']);
        }

        if (!empty($filters['status_pekerjaan'])) {
            $builder->where('maintenance.status_pekerjaan', $filters['status_pekerjaan']);
        }

        if (!empty($filters['tanggal_awal'])) {
            $builder->where('maintenance.tanggal_mulai >=', $filters['tanggal_awal']);
        }

        if (!empty($filters['tanggal_akhir'])) {
            $builder->where('maintenance.tanggal_mulai <=', $filters['tanggal_akhir']);
        }

        return $builder
            ->orderBy('maintenance.id_maintenance', 'DESC')
            ->findAll();
    }

    public function costTracking()
    {
        $tanggalAwal = $this->request->getGet('tanggal_awal');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        $cost = $this->getCostTrackingData($tanggalAwal, $tanggalAkhir);

        $total = 0;
        foreach ($cost as $row) {
            $total += $row['nominal'];
        }

        $data = [
            'title' => 'Laporan Cost Tracking',
            'cost' => $cost,
            'total' => $total,
            'tanggal_awal' => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir
        ];

        return view('laporan/cost_tracking', $data);
    }

    private function getCostTrackingData($tanggalAwal = null, $tanggalAkhir = null)
    {
        $costModel = new CostTrackingModel();

        $builder = $costModel
            ->select('cost_tracking.*, maintenance.jenis_pekerjaan, aset.kode_aset, aset.nama_aset, vendor.nama_vendor')
            ->join('maintenance', 'maintenance.id_maintenance = cost_tracking.id_maintenance', 'left')
            ->join('aset', 'aset.id_aset = maintenance.id_aset', 'left')
            ->join('vendor', 'vendor.id_vendor = maintenance.id_vendor', 'left');

        if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
            $builder->where('cost_tracking.tanggal_biaya >=', $tanggalAwal);
            $builder->where('cost_tracking.tanggal_biaya <=', $tanggalAkhir);
        }

        return $builder
            ->orderBy('cost_tracking.id_cost', 'DESC')
            ->findAll();
    }

    public function exportCostTrackingPdf()
    {
        $tanggalAwal = $this->request->getGet('tanggal_awal');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        $data = [
            'cost' => $this->getCostTrackingData($tanggalAwal, $tanggalAkhir),
            'tanggal_awal' => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir
        ];

        $html = view('laporan/pdf_cost_tracking', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-cost-tracking.pdf', ['Attachment' => false]);
    }

    public function exportCostTrackingExcel()
    {
        $tanggalAwal = $this->request->getGet('tanggal_awal');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        $cost = $this->getCostTrackingData($tanggalAwal, $tanggalAkhir);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Cost Tracking Maintenance Aset');
        $sheet->mergeCells('A1:G1');

        if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
            $sheet->setCellValue('A2', 'Periode: ' . $tanggalAwal . ' sampai ' . $tanggalAkhir);
            $sheet->mergeCells('A2:G2');
        }

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Aset');
        $sheet->setCellValue('C4', 'Vendor');
        $sheet->setCellValue('D4', 'Jenis Biaya');
        $sheet->setCellValue('E4', 'Deskripsi');
        $sheet->setCellValue('F4', 'Tanggal');
        $sheet->setCellValue('G4', 'Nominal');

        $rowNumber = 5;
        $no = 1;
        $total = 0;

        foreach ($cost as $row) {
            $total += $row['nominal'];

            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, $row['kode_aset'] . ' - ' . $row['nama_aset']);
            $sheet->setCellValue('C' . $rowNumber, $row['nama_vendor'] ?? '-');
            $sheet->setCellValue('D' . $rowNumber, str_replace('_', ' ', ucfirst($row['jenis_biaya'])));
            $sheet->setCellValue('E' . $rowNumber, $row['deskripsi_biaya']);
            $sheet->setCellValue('F' . $rowNumber, $row['tanggal_biaya']);
            $sheet->setCellValue('G' . $rowNumber, $row['nominal']);

            $rowNumber++;
        }

        $sheet->setCellValue('F' . $rowNumber, 'Total Biaya');
        $sheet->setCellValue('G' . $rowNumber, $total);

        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-cost-tracking.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportAsetPdf()
    {
        $filters = [
            'keyword'     => $this->request->getGet('keyword'),
            'id_kategori' => $this->request->getGet('id_kategori'),
            'id_lokasi'   => $this->request->getGet('id_lokasi'),
            'id_divisi'   => $this->request->getGet('id_divisi'),
            'kondisi'     => $this->request->getGet('kondisi'),
            'status_aset' => $this->request->getGet('status_aset')
        ];

        $data = [
            'aset' => $this->getAsetData($filters)
        ];

        $html = view('laporan/pdf_aset', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-aset.pdf', ['Attachment' => false]);
    }

    public function exportMaintenancePdf()
    {
        $filters = [
            'keyword'           => $this->request->getGet('keyword'),
            'jenis_pekerjaan'   => $this->request->getGet('jenis_pekerjaan'),
            'status_pekerjaan'  => $this->request->getGet('status_pekerjaan'),
            'tanggal_awal'      => $this->request->getGet('tanggal_awal'),
            'tanggal_akhir'     => $this->request->getGet('tanggal_akhir')
        ];

        $data = [
            'maintenance' => $this->getMaintenanceData($filters)
        ];

        $html = view('laporan/pdf_maintenance', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan-maintenance.pdf', ['Attachment' => false]);
    }

    public function exportAsetExcel()
    {
        $filters = [
            'keyword'     => $this->request->getGet('keyword'),
            'id_kategori' => $this->request->getGet('id_kategori'),
            'id_lokasi'   => $this->request->getGet('id_lokasi'),
            'id_divisi'   => $this->request->getGet('id_divisi'),
            'kondisi'     => $this->request->getGet('kondisi'),
            'status_aset' => $this->request->getGet('status_aset')
        ];

        $aset = $this->getAsetData($filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Data Aset Perusahaan');
        $sheet->mergeCells('A1:H1');

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Kode Aset');
        $sheet->setCellValue('C3', 'Nama Aset');
        $sheet->setCellValue('D3', 'Kategori');
        $sheet->setCellValue('E3', 'Lokasi');
        $sheet->setCellValue('F3', 'Divisi');
        $sheet->setCellValue('G3', 'Kondisi');
        $sheet->setCellValue('H3', 'Status');

        $rowNumber = 4;
        $no = 1;

        foreach ($aset as $row) {
            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, $row['kode_aset']);
            $sheet->setCellValue('C' . $rowNumber, $row['nama_aset']);
            $sheet->setCellValue('D' . $rowNumber, $row['nama_kategori']);
            $sheet->setCellValue('E' . $rowNumber, $row['nama_lokasi']);
            $sheet->setCellValue('F' . $rowNumber, $row['nama_divisi']);
            $sheet->setCellValue('G' . $rowNumber, str_replace('_', ' ', ucfirst($row['kondisi'])));
            $sheet->setCellValue('H' . $rowNumber, ucfirst($row['status_aset']));

            $rowNumber++;
        }

        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-aset.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportMaintenanceExcel()
    {
        $filters = [
            'keyword'           => $this->request->getGet('keyword'),
            'jenis_pekerjaan'   => $this->request->getGet('jenis_pekerjaan'),
            'status_pekerjaan'  => $this->request->getGet('status_pekerjaan'),
            'tanggal_awal'      => $this->request->getGet('tanggal_awal'),
            'tanggal_akhir'     => $this->request->getGet('tanggal_akhir')
        ];

        $maintenance = $this->getMaintenanceData($filters);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Laporan Maintenance Aset Perusahaan');
        $sheet->mergeCells('A1:H1');

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Aset');
        $sheet->setCellValue('C3', 'Vendor');
        $sheet->setCellValue('D3', 'Jenis Pekerjaan');
        $sheet->setCellValue('E3', 'Tanggal Mulai');
        $sheet->setCellValue('F3', 'Tanggal Selesai');
        $sheet->setCellValue('G3', 'Status');
        $sheet->setCellValue('H3', 'Hasil Pekerjaan');

        $rowNumber = 4;
        $no = 1;

        foreach ($maintenance as $row) {
            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, $row['kode_aset'] . ' - ' . $row['nama_aset']);
            $sheet->setCellValue('C' . $rowNumber, $row['nama_vendor'] ?? '-');
            $sheet->setCellValue('D' . $rowNumber, str_replace('_', ' ', ucfirst($row['jenis_pekerjaan'])));
            $sheet->setCellValue('E' . $rowNumber, $row['tanggal_mulai']);
            $sheet->setCellValue('F' . $rowNumber, $row['tanggal_selesai'] ?? '-');
            $sheet->setCellValue('G' . $rowNumber, ucfirst($row['status_pekerjaan']));
            $sheet->setCellValue('H' . $rowNumber, $row['hasil_pekerjaan'] ?? '-');

            $rowNumber++;
        }

        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-maintenance.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}