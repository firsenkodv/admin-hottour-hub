<footer class="footer">
    <div class="container">
        <ul class="footer__menu">
            <li><a href="{{ route('countries.index') }}">Страны</a></li>
            <li><a href="{{ route('hottours.index') }}">Горящие туры</a></li>
            <li><a href="{{ route('reviews.index') }}">Отзывы</a></li>
            <li><a href="{{ route('about.show') }}">О нас</a></li>
            <li><a href="{{ route('documents.index') }}">Документы</a></li>
            <li><a href="{{ route('contacts.show') }}">Контакты</a></li>
        </ul>

        <p class="footer__copyright">&copy; {{ now()->year }} Hot Tour Group</p>
    </div>
</footer>
