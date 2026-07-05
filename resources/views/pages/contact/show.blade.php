@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Контакты" />

    <div class="container">
        <h1>Контакты</h1>

        <ul class="contacts-list">
            @if ($contact->phone)
                <li>Телефон: <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></li>
            @endif

            @if ($contact->email)
                <li>Email: <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></li>
            @endif

            @if ($contact->address)
                <li>Адрес: {{ $contact->address }}</li>
            @endif

            @if ($contact->working_hours)
                <li>Режим работы: {{ $contact->working_hours }}</li>
            @endif
        </ul>

        @if ($contact->map_embed)
            <div class="contacts-map">{!! $contact->map_embed !!}</div>
        @endif

        @if ($contact->text)
            <div class="desc">{!! $contact->text !!}</div>
        @endif
    </div>
@endsection
