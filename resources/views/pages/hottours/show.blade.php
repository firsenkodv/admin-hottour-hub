@extends('layouts.layout')

@section('content')
    <x-seo.meta
        :title="$hottour->metatitle ?: $hottour->title"
        :description="$hottour->description"
        :keywords="$hottour->keywords"
    />

    <div class="container">
        <p><a href="{{ route('countries.show', $hottour->country->slug) }}">{{ $hottour->country->title }}</a></p>

        <h1>{{ $hottour->title }}</h1>

        @if ($hottour->hotel)
            <p><a href="{{ route('hotels.show', $hottour->hotel->slug) }}">{{ $hottour->hotel->title }}</a></p>
        @endif

        @if ($hottour->nights)
            <div class="nights">{{ $hottour->nights }} ночей</div>
        @endif

        @if ($hottour->old_price)
            <div class="old-price">{{ $hottour->old_price }}</div>
        @endif

        <div class="price">{{ $hottour->price }}</div>

        @if ($hottour->valid_until)
            <div class="valid-until">Актуально до {{ $hottour->valid_until->format('d.m.Y') }}</div>
        @endif

        @if ($hottour->image)
            <img src="{{ Storage::url($hottour->image) }}" alt="{{ $hottour->title }}" class="img-wide">
        @endif

        @if ($hottour->smalltext)
            <div class="short-desc">{!! $hottour->smalltext !!}</div>
        @endif

        @if ($hottour->text)
            <div class="desc">{!! $hottour->text !!}</div>
        @endif
    </div>
@endsection
