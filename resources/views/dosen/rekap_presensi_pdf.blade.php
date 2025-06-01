<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Presensi - {{ $matkul->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #577BC1;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">Rekap Kehadiran Mata Kuliah: {{ $matkul->nama }}</div>
        <div class="subtitle">Jumlah Mahasiswa: {{ $mahasiswas->count() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matkul->presences as $index => $presence)
                @foreach($presence->attendances as $attendance)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $attendance->mahasiswa->user->name ?? 'Nama tidak tersedia' }}</td>
                        <td>{{ $attendance->status ?? 'Belum Dikonfirmasi' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>
