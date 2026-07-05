@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Горящие туры" />

    <div class="container">
        <h1>Горящие туры</h1>

        <div class="hottours-grid">
            @forelse ($hottours as $hottour)
                <a href="{{ route('hottours.show', $hottour->slug) }}" class="hottour-card">
                    @if ($hottour->image)
                        <img src="{{ Storage::url($hottour->image) }}" alt="{{ $hottour->title }}">
                    @endif
                    <span>{{ $hottour->title }}</span>
                    @if ($hottour->old_price)
                        <span class="old-price">{{ $hottour->old_price }}</span>
                    @endif
                    <span class="price">{{ $hottour->price }}</span>
                    @if ($hottour->valid_until)
                        <span class="valid-until">до {{ $hottour->valid_until->format('d.m.Y') }}</span>
                    @endif
                </a>
            @empty
                <p>Горящих туров пока нет.</p>
            @endforelse
        </div>

        {{ $hottours->links() }}
    </div>
@endsection
