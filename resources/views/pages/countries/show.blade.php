@extends('layouts.layout')

@section('content')
    <x-seo.meta
        :title="$country->metatitle ?: $country->title"
        :description="$country->description"
        :keywords="$country->keywords"
    />

    <div class="container">
        <h1>{{ $country->title }}</h1>

        @if ($country->image)
            <img src="{{ Storage::url($country->image) }}" alt="{{ $country->title }}" class="img-wide">
        @endif

        @if ($country->smalltext)
            <div class="short-desc">{!! $country->smalltext !!}</div>
        @endif

        @if ($country->text)
            <div class="desc">{!! $country->text !!}</div>
        @endif

        <h2>Отели</h2>

        <div class="hotels-grid">
            @forelse ($hotels as $hotel)
                <a href="{{ route('hotels.show', $hotel->slug) }}" class="hotel-card">
                    @if ($hotel->image)
                        <img src="{{ Storage::url($hotel->image) }}" alt="{{ $hotel->title }}">
                    @endif
                    <span>{{ $hotel->title }}</span>
                    @if ($hotel->stars)
                        <span class="stars">{{ str_repeat('★', $hotel->stars) }}</span>
                    @endif
                </a>
            @empty
                <p>Отели пока не добавлены.</p>
            @endforelse
        </div>

        {{ $hotels->links() }}

        <p><a href="{{ route('travelcategories.index', $country->slug) }}">Полезное про {{ $country->title }}</a></p>
    </div>
@endsection
