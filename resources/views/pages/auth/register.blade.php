@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Регистрация" />

    <div class="container">
        <h1>Регистрация</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label>
                Имя
                <input type="text" name="name" value="{{ old('name') }}" required>
            </label>

            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>

            <label>
                Пароль
                <input type="password" name="password" required minlength="6">
            </label>

            <label>
                Повтор пароля
                <input type="password" name="password_confirmation" required minlength="6">
            </label>

            <button type="submit">Зарегистрироваться</button>
        </form>

        <p><a href="{{ route('login.show') }}">Уже есть аккаунт? Войти</a></p>
    </div>
@endsection
