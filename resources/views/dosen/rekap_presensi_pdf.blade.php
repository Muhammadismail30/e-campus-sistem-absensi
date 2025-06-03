<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekap Presensi - {{ $matkul->nama_matkul }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .title {
            font-size: 14px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 12px;
        }
        .legend {
            text-align: center;
            margin: 10px 0;
            font-size: 11px;
        }
        .nama-mahasiswa {
            text-align: left;
            min-width: 100px;
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .hadir {
            color: #28a745;
            font-weight: bold;
        }
        .alpa {
            color: #dc3545;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Halaman 1 -->
    <div class="header">
        <div class="title">REKAP PRESENSI MATA KULIAH</div>
        <div class="subtitle">{{ $matkul->kode }} - {{ $matkul->sks }} SKS</div>
        <div class="subtitle">Dosen Pengampu: {{ $matkul->dosen->user->name }}</div>
    </div>

    <div class="legend">
        <span class="hadir">H = Hadir</span> | 
        <span class="alpa">A = Alpa</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 70px;">NIM</th>
                <th>Nama Mahasiswa</th>
                @for($i = 1; $i <= 16; $i++)
                    <th style="width: 20px;">P{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($matkul->mahasiswas as $index => $mahasiswa)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $mahasiswa->nim }}</td>
                <td class="nama-mahasiswa">{{ $mahasiswa->user->name }}</td>
                @for($i = 1; $i <= 16; $i++)
                    @php
                        $presence = $presences->where('pertemuan_ke', $i)->first();
                        $hadir = $presence ? $presence->attendances->where('mahasiswa_id', $mahasiswa->id)->count() > 0 : false;
                    @endphp
                    <td>
                        @if($hadir)
                            <span class="hadir">H</span>
                        @else
                            <span class="alpa">A</span>
                        @endif
                    </td>
                @endfor
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Halaman 2 -->
    <div class="page-break"></div>
    
    <div class="header">
        <div class="title">DETAIL PERTEMUAN</div>
        <div class="subtitle">{{ $matkul->kode }} - {{ $matkul->nama_matkul }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">Pert.</th>
                <th style="width: 80px;">Tanggal</th>
                <th>Topik</th>
                <th style="width: 50px;">Hadir</th>
                <th style="width: 70px;">Tidak Hadir</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 1; $i <= 16; $i++)
                @php
                    $presence = $presences->where('pertemuan_ke', $i)->first();
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        @if($presence)
                            {{ $presence->tanggal->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($presence)
                            {{ $presence->topik }}
                        @else
                            Belum dilaksanakan
                        @endif
                    </td>
                    <td>
                        @if($presence)
                            {{ $presence->attendances->count() }}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if($presence)
                            {{ $matkul->mahasiswas->count() - $presence->attendances->count() }}
                        @else
                            {{ $matkul->mahasiswas->count() }}
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>