@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Страны" />

    <div class="container">
        <h1>Страны</h1>

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

        {{ $countries->links() }}
    </div>
@endsection
