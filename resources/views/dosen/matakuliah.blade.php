@extends("components.layout", ["title" => $title ?? "Mata Kuliah Yang Diampu"])

@section('content')
<div class="container mx-auto px-4 py-8">
    @if($matkuls->isEmpty())
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded">
            Anda belum mengampu mata kuliah apapun.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($matkuls as $matkul)
                <x-matakuliah-card :matkul="$matkul" />
            @endforeach
        </div>
    @endif
</div>
@endsection