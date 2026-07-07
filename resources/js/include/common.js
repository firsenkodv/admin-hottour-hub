export function toggleHeaderScroll() {
    const header = document.querySelector('.header__bottom-bg');
    if (!header) return;

    function update() {
        header.classList.toggle('is-scrolled', window.scrollY > 0);
    }

    window.addEventListener('scroll', update);
    update();
}
