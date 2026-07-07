@props(['prefix' => 'header__logo'])

@php
    $isHome = request()->routeIs('home');
@endphp

@if ($isHome)
    <div {{ $attributes->merge(['class' => $prefix]) }}>
@else
    <a href="{{ route('home') }}" {{ $attributes->merge(['class' => $prefix]) }}>
@endif

    <img src="{{ asset('images/icons/logo.svg') }}" width="260" height="48" alt="HOTTOUR">

@if ($isHome)
    </div>
@else
    </a>
@endif
