@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Отзывы" />

    <div class="container">
        <h1>Отзывы</h1>

        <div class="reviews-list">
            @forelse ($reviews as $review)
                <div class="review-card">
                    <strong>{{ $review->author_name }}</strong>
                    @if ($review->rating)
                        <span class="rating">{{ str_repeat('★', $review->rating) }}</span>
                    @endif
                    @if ($review->hotel)
                        <a href="{{ route('hotels.show', $review->hotel->slug) }}">{{ $review->hotel->title }}</a>
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
