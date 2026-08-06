<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
        .title { font-size: 16pt; font-weight: bold; text-align: center; color: #1e3a8a; }
        .subtitle { font-size: 12pt; text-align: center; font-weight: bold; margin-bottom: 15px; }
        .table-header { background-color: #1e3a8a; color: #ffffff; font-weight: bold; text-align: center; border: 0.5pt solid #000000; }
        .table-header-sub { background-color: #3b82f6; color: #ffffff; font-weight: bold; text-align: center; border: 0.5pt solid #000000; }
        .cell-data { border: 0.5pt solid #cccccc; vertical-align: middle; }
        .cell-center { text-align: center; border: 0.5pt solid #cccccc; vertical-align: middle; }
        .cell-total { background-color: #f1f5f9; font-weight: bold; border: 0.5pt solid #000000; text-align: center; }
        .meta-label { font-weight: bold; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="7" class="title">UNIVERSITAS IBNU SINA BATAM</td>
        </tr>
        <tr>
            <td colspan="7" class="subtitle">LAPORAN REKAPITULASI PRESTASI MAHASISWA (SIMKATMAWA / BKAK)</td>
        </tr>
        <tr>
            <td class="meta-label">Periode Tahun</td>
            <td>: {{ $selectedTahun === 'all' ? 'Semua Tahun' : 'Tahun ' . $selectedTahun }}</td>
            <td colspan="2"></td>
            <td class="meta-label">Kategori</td>
            <td colspan="2">: {{ $selectedJenis === 'all' ? 'Semua Kategori' : $selectedJenis }}</td>
        </tr>
        <tr>
            <td class="meta-label">Program Studi</td>
            <td>: {{ $selectedProdi === 'all' ? 'Semua Program Studi' : $selectedProdi }}</td>
            <td colspan="2"></td>
            <td class="meta-label">Tanggal Export</td>
            <td colspan="2">: {{ date('d F Y H:i') }} WIB</td>
        </tr>
        <tr><td colspan="7"></td></tr>

        <!-- MATRIKS REKAPITULASI -->
        <tr>
            <td colspan="7" style="font-weight: bold; font-size: 12pt; color: #1e3a8a;">I. MATRIKS REKAPITULASI PRESTASI PER PROGRAM STUDI</td>
        </tr>
        <tr>
            <td class="table-header" style="width: 50px;">NO</td>
            <td class="table-header" style="width: 250px;">PROGRAM STUDI</td>
            <td class="table-header" style="width: 120px;">KABUPATEN / KOTA</td>
            <td class="table-header" style="width: 120px;">PROVINSI</td>
            <td class="table-header" style="width: 120px;">NASIONAL</td>
            <td class="table-header" style="width: 120px;">INTERNASIONAL</td>
            <td class="table-header" style="width: 130px;">TOTAL CAPAIAN</td>
        </tr>
        @php
            $no = 1;
            $sKab = 0; $sProv = 0; $sNas = 0; $sInter = 0; $sTot = 0;
        @endphp
        @foreach($matrix as $prodiName => $c)
            @php
                $sKab += $c['Kabupaten/Kota'];
                $sProv += $c['Provinsi'];
                $sNas += $c['Nasional'];
                $sInter += $c['Internasional'];
                $sTot += $c['total'];
            @endphp
            <tr>
                <td class="cell-center">{{ $no++ }}</td>
                <td class="cell-data"><b>{{ $prodiName }}</b></td>
                <td class="cell-center">{{ $c['Kabupaten/Kota'] }}</td>
                <td class="cell-center">{{ $c['Provinsi'] }}</td>
                <td class="cell-center">{{ $c['Nasional'] }}</td>
                <td class="cell-center">{{ $c['Internasional'] }}</td>
                <td class="cell-center" style="font-weight: bold; background-color: #eff6ff;">{{ $c['total'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" class="cell-total">TOTAL KESELURUHAN</td>
            <td class="cell-total">{{ $sKab }}</td>
            <td class="cell-total">{{ $sProv }}</td>
            <td class="cell-total">{{ $sNas }}</td>
            <td class="cell-total">{{ $sInter }}</td>
            <td class="cell-total" style="background-color: #3b82f6; color: #ffffff;">{{ $sTot }}</td>
        </tr>

        <tr><td colspan="7"></td></tr>
        <tr><td colspan="7"></td></tr>

        <!-- RINCIAN DATA -->
        <tr>
            <td colspan="7" style="font-weight: bold; font-size: 12pt; color: #1e3a8a;">II. RINCIAN CAPAIAN PRESTASI MAHASISWA</td>
        </tr>
        <tr>
            <td class="table-header-sub">NO</td>
            <td class="table-header-sub">MAHASISWA (NIM)</td>
            <td class="table-header-sub">PROGRAM STUDI</td>
            <td class="table-header-sub">JUDUL KEGIATAN / PRESTASI</td>
            <td class="table-header-sub">MODUL / KATEGORI</td>
            <td class="table-header-sub">TINGKAT & CAPAIAN</td>
            <td class="table-header-sub">TAHUN</td>
        </tr>
        @forelse($filteredRecords as $i => $r)
            <tr>
                <td class="cell-center">{{ $i + 1 }}</td>
                <td class="cell-data">{{ $r['mahasiswa'] }} ({{ $r['nim'] }})</td>
                <td class="cell-data">{{ $r['prodi'] }}</td>
                <td class="cell-data">{{ $r['judul_kegiatan'] }}</td>
                <td class="cell-data">{{ $r['modul'] }} - {{ $r['kategori'] }} ({{ $r['jenis'] }})</td>
                <td class="cell-center">{{ $r['level'] }} - {{ $r['capaian'] }}</td>
                <td class="cell-center">{{ $r['tahun'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="cell-center" style="font-style: italic;">Tidak ada data rekapitulasi yang tersedia.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
