import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('theme', {
    dark: false,
    init() {
        this.dark = document.documentElement.classList.contains('dark');
    },
    toggle() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        fetch('/user/theme', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ theme: this.dark ? 'dark' : 'light' }),
        });
    },
});

Alpine.start();
