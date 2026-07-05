@extends('layouts.layout')

@section('content')
    <x-seo.meta
        :title="$category->metatitle ?: $category->title"
        :description="$category->description"
        :keywords="$category->keywords"
    />

    <div class="container">
        <h1>{{ $category->title }}</h1>

        @if ($category->image)
            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->title }}" class="img-wide">
        @endif

        @if ($category->smalltext)
            <div class="short-desc">{!! $category->smalltext !!}</div>
        @endif

        @if ($category->text)
            <div class="desc">{!! $category->text !!}</div>
        @endif

        <div class="travelitems-list">
            @forelse ($items as $item)
                <a href="{{ route('travelitems.show', [$category->slug, $item->slug]) }}" class="travelitem-card">
                    @if ($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}">
                    @endif
                    <span>{{ $item->title }}</span>
                </a>
            @empty
                <p>Пока ничего не добавлено.</p>
            @endforelse
        </div>

        {{ $items->links() }}
    </div>
@endsection
