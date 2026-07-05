@extends('layouts.layout')

@section('content')
    <x-seo.meta
        :title="$item->metatitle ?: $item->title"
        :description="$item->description"
        :keywords="$item->keywords"
    />

    <div class="container">
        <p><a href="{{ route('travelcategories.show', $item->travelcategory->slug) }}">{{ $item->travelcategory->title }}</a></p>

        <h1>{{ $item->title }}</h1>

        @if ($item->image)
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="img-wide">
        @endif

        @if ($item->smalltext)
            <div class="short-desc">{!! $item->smalltext !!}</div>
        @endif

        @if ($item->text)
            <div class="desc">{!! $item->text !!}</div>
        @endif
    </div>
@endsection
