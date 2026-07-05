@extends('layouts.layout')

@section('content')
    <x-seo.meta title="{{ $country->title }}: полезное" />

    <div class="container">
        <p><a href="{{ route('countries.show', $country->slug) }}">{{ $country->title }}</a></p>

        <h1>{{ $country->title }}: полезное</h1>

        <div class="travelcategories-grid">
            @forelse ($categories as $category)
                <a href="{{ route('travelcategories.show', $category->slug) }}" class="travelcategory-card">
                    @if ($category->image)
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->title }}">
                    @endif
                    <span>{{ $category->title }}</span>
                </a>
            @empty
                <p>Пока ничего не добавлено.</p>
            @endforelse
        </div>

        {{ $categories->links() }}
    </div>
@endsection
