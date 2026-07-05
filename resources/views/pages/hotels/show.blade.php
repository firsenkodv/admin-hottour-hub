@extends('layouts.layout')

@section('content')
    <x-seo.meta
        :title="$hotel->metatitle ?: $hotel->title"
        :description="$hotel->description"
        :keywords="$hotel->keywords"
    />

    <div class="container">
        <p><a href="{{ route('countries.show', $hotel->country->slug) }}">{{ $hotel->country->title }}</a></p>

        <h1>{{ $hotel->title }}</h1>

        @if ($hotel->stars)
            <div class="stars">{{ str_repeat('★', $hotel->stars) }}</div>
        @endif

        @if ($hotel->rating)
            <div class="rating">Рейтинг: {{ $hotel->rating }}</div>
        @endif

        @if ($hotel->image)
            <img src="{{ Storage::url($hotel->image) }}" alt="{{ $hotel->title }}" class="img-wide">
        @endif

        @if ($hotel->gallery && $hotel->gallery->isNotEmpty())
            <div class="gallery">
                @foreach ($hotel->gallery as $image)
                    <img src="{{ Storage::url($image) }}" alt="{{ $hotel->title }}">
                @endforeach
            </div>
        @endif

        @if ($hotel->smalltext)
            <div class="short-desc">{!! $hotel->smalltext !!}</div>
        @endif

        @if ($hotel->text)
            <div class="desc">{!! $hotel->text !!}</div>
        @endif

        <h2>Отзывы</h2>

        <div class="reviews-list">
            @forelse ($reviews as $review)
                <div class="review-card">
                    <strong>{{ $review->author_name }}</strong>
                    @if ($review->rating)
                        <span class="rating">{{ str_repeat('★', $review->rating) }}</span>
                    @endif
                    <p>{{ $review->text }}</p>
                </div>
            @empty
                <p>Отзывов пока нет.</p>
            @endforelse
        </div>

        {{ $reviews->links() }}
    </div>
@endsection
