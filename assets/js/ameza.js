(() => {
    'use strict';
    const burger = document.getElementById('burger');
    const navigation = document.getElementById('navMenu');
    if (burger && navigation) {
        const close = () => {
            navigation.classList.remove('active');
            burger.setAttribute('aria-expanded', 'false');
        };
        burger.addEventListener('click', () => {
            const open = navigation.classList.toggle('active');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        navigation.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', close);
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') close();
        });
        document.addEventListener('click', event => {
            if (!burger.contains(event.target) && !navigation.contains(event.target)) close();
        });
    }
})();
