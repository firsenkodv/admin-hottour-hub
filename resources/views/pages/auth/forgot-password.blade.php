@extends('layouts.layout')

@section('content')
    <x-seo.meta title="Восстановление пароля" />

    <div class="container">
        <h1>Восстановление пароля</h1>

        <form method="POST" action="{{ route('password.forgot') }}">
            @csrf

            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>

            <button type="submit">Отправить инструкцию</button>
        </form>
    </div>
@endsection
