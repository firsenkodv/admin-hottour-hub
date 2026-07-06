<header class="site-header">
    <nav class="site-nav">
        <a href="{{ route('home') }}" class="site-nav__logo">Hot Tour</a>

        <ul class="site-nav__menu">
            <li><a href="{{ route('countries.index') }}">Страны</a></li>
            <li><a href="{{ route('hottours.index') }}">Горящие туры</a></li>
            <li><a href="{{ route('reviews.index') }}">Отзывы</a></li>
            <li><a href="{{ route('about.show') }}">О нас</a></li>
            <li><a href="{{ route('documents.index') }}">Документы</a></li>
            <li><a href="{{ route('contacts.show') }}">Контакты</a></li>
        </ul>

        <div class="site-nav__auth">
            @auth
                <a href="{{ route('home') }}">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Выйти</button>
                </form>
            @else
                <a href="{{ route('login.show') }}">Войти</a>
                <a href="{{ route('register.show') }}">Регистрация</a>
            @endauth
        </div>
    </nav>
</header>
