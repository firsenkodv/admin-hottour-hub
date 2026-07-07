<header class="header">
    <div class="header__top-bg">
        <div class="header__top">
            <nav>
                <x-menu.top-menu />
            </nav>

            <div class="header__right">
                <div class="header__social">
                    <a href="#" class="icon-circle"><img src="{{ asset('images/icons/icon-facebook.svg') }}" alt="Facebook"></a>
                    <a href="#" class="icon-circle"><img src="{{ asset('images/icons/icon-youtube.svg') }}" alt="YouTube"></a>
                    <a href="#" class="icon-circle"><img src="{{ asset('images/icons/icon-instagram.svg') }}" alt="Instagram"></a>
                    <a href="#" class="icon-circle"><img src="{{ asset('images/icons/icon-whatsapp.svg') }}" alt="WhatsApp"></a>
                    <a href="#" class="icon-circle"><img src="{{ asset('images/icons/icon-telegram.svg') }}" alt="Telegram"></a>
                </div>
                <div class="header__langs">
                    <a href="#" class="is-active">Рус</a>
                    <a href="#">Қаз</a>
                    <a href="#">Eng</a>
                </div>
            </div>
        </div>
    </div>

    <div class="header__bottom-bg">
        <div class="header__bottom">
            <x-logo.logo />

            <div class="header__contacts">
                <div class="contact-item">
                    <span class="contact-icon contact-icon__first"><img src="{{ asset('images/icons/icon-callback.svg') }}" alt=""></span>
                    <div>
                        <div class="contact-label">Форма обратной связи</div>
                        <div class="contact-value">Заказать звонок</div>
                    </div>
                </div>
                <div class="contact-item">
                    <span class="contact-icon"><img src="{{ asset('images/icons/icon-phone.svg') }}" alt=""></span>
                    <div>
                        <div class="contact-label">Телефон</div>
                        <div class="contact-value">8 707 383 99 66</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('login.show') }}" class="cabinet-pill">
                <span class="cabinet-pill__avatar"></span> Вход
            </a>
        </div>
    </div>
</header>
