@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Новый пароль" />

    <div class="container">
        <h1>Новый пароль</h1>

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label>
                Новый пароль
                <input type="password" name="password" required minlength="6">
            </label>

            <label>
                Повтор пароля
                <input type="password" name="password_confirmation" required minlength="6">
            </label>

            <button type="submit">Сохранить</button>
        </form>
    </div>
@endsection
