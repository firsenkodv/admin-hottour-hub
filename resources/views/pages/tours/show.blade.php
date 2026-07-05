@extends('layouts.layout')

@section('content')
    <x-seo.meta
        :title="$tour->metatitle ?: $tour->title"
        :description="$tour->description"
        :keywords="$tour->keywords"
    />

    <div class="container">
        <p><a href="{{ route('countries.show', $tour->country->slug) }}">{{ $tour->country->title }}</a></p>

        <h1>{{ $tour->title }}</h1>

        @if ($tour->nights)
            <div class="nights">{{ $tour->nights }} ночей</div>
        @endif

        @if ($tour->price)
            <div class="price">от {{ $tour->price }}</div>
        @endif

        @if ($tour->image)
            <img src="{{ Storage::url($tour->image) }}" alt="{{ $tour->title }}" class="img-wide">
        @endif

        @if ($tour->gallery && $tour->gallery->isNotEmpty())
            <div class="gallery">
                @foreach ($tour->gallery as $image)
                    <img src="{{ Storage::url($image) }}" alt="{{ $tour->title }}">
                @endforeach
            </div>
        @endif

        @if ($tour->smalltext)
            <div class="short-desc">{!! $tour->smalltext !!}</div>
        @endif

        @if ($tour->text)
            <div class="desc">{!! $tour->text !!}</div>
        @endif
    </div>
@endsection
