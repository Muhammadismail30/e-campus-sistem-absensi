<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekap Presensi - {{ $matkul->nama_matkul }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .page-break { page-break-after: always; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; color: #555; }
        .legend { display: flex; justify-content: center; gap: 20px; margin-bottom: 15px; }
        .legend-item { display: flex; align-items: center; }
        .h-present { color: #16a34a; font-weight: bold; }
        .a-absent { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <!-- Halaman 1 -->
    <div class="header">
        <div class="title">REKAP PRESENSI MATA KULIAH</div>
        <div class="subtitle">{{ $matkul->nama_matkul }} ({{ $matkul->kode }}) - {{ $matkul->sks }} SKS</div>
        <div class="subtitle">Dosen Pengampu: {{ $matkul->dosen->user->name }}</div>
    </div>

    <!-- Legend -->
    <div class="legend">
        <div class="legend-item">
            <span class="h-present">H</span>&nbsp;= Hadir
        </div>
        <div class="legend-item">
            <span class="a-absent">A</span>&nbsp;= Alpa
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                @for($i = 1; $i <= 16; $i++)
                    <th>P{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($matkul->mahasiswas as $index => $mahasiswa)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mahasiswa->nim }}</td>
                <td>{{ $mahasiswa->user->name }}</td>
                @foreach($presences as $presence)
                    <td>
                        @if($presence->attendances->where('mahasiswa_id', $mahasiswa->id)->count() > 0)
                            <span class="h-present">H</span>
                        @else
                            <span class="a-absent">A</span>
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Halaman 2 -->
    <div class="page-break"></div>
    
    <div class="header">
        <div class="title">DETAIL PERTEMUAN</div>
        <div class="subtitle">{{ $matkul->nama_matkul }} ({{ $matkul->kode }})</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Pertemuan</th>
                <th>Tanggal</th>
                <th>Topik</th>
                <th>Hadir</th>
                <th>Tidak Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presences as $presence)
            <tr>
                <td>{{ $presence->pertemuan_ke }}</td>
                <td>{{ $presence->tanggal->format('d/m/Y') }}</td>
                <td>{{ $presence->topik }}</td>
                <td>{{ $presence->attendances->count() }}</td>
                <td>{{ $matkul->mahasiswas->count() - $presence->attendances->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>