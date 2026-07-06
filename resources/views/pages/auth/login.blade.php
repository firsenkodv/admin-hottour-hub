@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Вход" />

    <div class="container">
        <h1>Вход</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>

            <label>
                Пароль
                <input type="password" name="password" required>
            </label>

            <button type="submit">Войти</button>
        </form>

        <p><a href="{{ route('password.forgot.show') }}">Забыли пароль?</a></p>
        <p><a href="{{ route('register.show') }}">Нет аккаунта? Зарегистрироваться</a></p>
    </div>
@endsection
