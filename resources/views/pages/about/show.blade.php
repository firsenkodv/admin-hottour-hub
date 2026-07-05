@extends('layouts.layout')

@section('content')
    <x-seo.meta
        :title="$about->metatitle ?: $about->title"
        :description="$about->description"
        :keywords="$about->keywords"
    />

    <div class="container">
        <h1>{{ $about->title }}</h1>

        @if ($about->image)
            <img src="{{ Storage::url($about->image) }}" alt="{{ $about->title }}" class="img-wide">
        @endif

        @if ($about->smalltext)
            <div class="short-desc">{!! $about->smalltext !!}</div>
        @endif

        @if ($about->text)
            <div class="desc">{!! $about->text !!}</div>
        @endif
    </div>
@endsection
