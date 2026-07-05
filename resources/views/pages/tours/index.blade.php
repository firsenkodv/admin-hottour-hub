@extends('layouts.layout')

@section('content')
    <x-seo.meta title="{{ $country->title }}: туры" />

    <div class="container">
        <p><a href="{{ route('countries.show', $country->slug) }}">{{ $country->title }}</a></p>

        <h1>{{ $country->title }}: туры</h1>

        <div class="tours-grid">
            @forelse ($tours as $tour)
                <a href="{{ route('tours.show', $tour->slug) }}" class="tour-card">
                    @if ($tour->image)
                        <img src="{{ Storage::url($tour->image) }}" alt="{{ $tour->title }}">
                    @endif
                    <span>{{ $tour->title }}</span>
                    @if ($tour->nights)
                        <span class="nights">{{ $tour->nights }} ночей</span>
                    @endif
                    @if ($tour->price)
                        <span class="price">от {{ $tour->price }}</span>
                    @endif
                </a>
            @empty
                <p>Туры пока не добавлены.</p>
            @endforelse
        </div>

        {{ $tours->links() }}
    </div>
@endsection
