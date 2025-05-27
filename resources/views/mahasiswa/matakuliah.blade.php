@extends("components.layout", ["title" => $title ?? "Mata Kuliah Mahasiswa"])

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Daftar Mata Kuliah</h1>

    @if($matkuls->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded">
            Anda belum terdaftar pada mata kuliah manapun.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($matkuls as $matkul)
                <x-matakuliah-card :matkul="$matkul" :role="auth()->user()->role" />
            @endforeach
        </div>
    @endif
</div>
@endsection
