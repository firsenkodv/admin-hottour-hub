@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Hot Tour" />

    <div class="container">
        <section class="home-hottours">
            <h2>Горящие туры</h2>

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
                    </a>
                @empty
                    <p>Горящих туров пока нет.</p>
                @endforelse
            </div>

            <p><a href="{{ route('hottours.index') }}">Все горящие туры</a></p>
        </section>

        <section class="home-countries">
            <h2>Страны</h2>

            <div class="countries-grid">
                @forelse ($countries as $country)
                    <a href="{{ route('countries.show', $country->slug) }}" class="country-card">
                        @if ($country->image)
                            <img src="{{ Storage::url($country->image) }}" alt="{{ $country->title }}">
                        @endif
                        <span>{{ $country->title }}</span>
                    </a>
                @empty
                    <p>Страны пока не добавлены.</p>
                @endforelse
            </div>

            <p><a href="{{ route('countries.index') }}">Все страны</a></p>
        </section>

        <section class="home-reviews">
            <h2>Отзывы клиентов</h2>

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

            <p><a href="{{ route('reviews.index') }}">Все отзывы</a></p>
        </section>
    </div>
@endsection
