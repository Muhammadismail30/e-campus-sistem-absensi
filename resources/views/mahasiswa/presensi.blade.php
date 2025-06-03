@extends("components.layout", ["title" => $title ?? "Presensi Mahasiswa"])

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Riwayat Presensi Mahasiswa</h1>

    @if(count($presensi) > 0)
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="py-2 px-4 border-b">Tanggal</th>
                    <th class="py-2 px-4 border-b">Mata Kuliah</th>
                    <th class="py-2 px-4 border-b">Pertemuan</th>
                    <th class="py-2 px-4 border-b">Topik</th>
                    <th class="py-2 px-4 border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presensi as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $item->tanggal->format('d M Y') }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->mataKuliah->nama ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">Pertemuan ke-{{ $item->pertemuan_ke }}</td>
                        <td class="py-2 px-4 border-b">{{ $item->topik }}</td>
                        <td class="py-2 px-4 border-b">
                            @php
                                $attendance = $item->attendances->first();
                            @endphp
                            @if($attendance && $attendance->status === 'hadir')
                                <span class="text-green-600 font-semibold">Hadir</span>
                            @else
                                <span class="text-red-600 font-semibold">Tidak Hadir</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">Belum ada riwayat presensi.</p>
    @endif
</div>
@endsection
