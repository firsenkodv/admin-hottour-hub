@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Документы" />

    <div class="container">
        <h1>Документы</h1>

        <ul class="documents-list">
            @forelse ($documents as $document)
                <li>
                    <a href="{{ Storage::url($document->file) }}" target="_blank" rel="noopener">{{ $document->title }}</a>
                    @if ($document->description)
                        <p>{{ $document->description }}</p>
                    @endif
                </li>
            @empty
                <p>Документы пока не добавлены.</p>
            @endforelse
        </ul>

        {{ $documents->links() }}
    </div>
@endsection
