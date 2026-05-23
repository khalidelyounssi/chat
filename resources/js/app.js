import './bootstrap';

const setupMobileNav = () => {
    const toggles = document.querySelectorAll('[data-mobile-nav-toggle]');

    if (!toggles.length) {
        return;
    }

    const syncBodyLock = () => {
        const anyOpen = Array.from(toggles).some((toggle) => toggle.getAttribute('aria-expanded') === 'true' && window.innerWidth < 1024);
        document.body.classList.toggle('overflow-hidden', anyOpen);
    };

    toggles.forEach((toggle) => {
        const targetId = toggle.getAttribute('data-mobile-nav-target') || toggle.getAttribute('aria-controls');
        const nav = targetId ? document.getElementById(targetId) : null;

        if (!nav) {
            return;
        }

        const closeNav = () => {
            nav.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            syncBodyLock();
        };

        const openNav = () => {
            nav.classList.remove('hidden');
            toggle.setAttribute('aria-expanded', 'true');
            syncBodyLock();
        };

        const syncDesktopState = () => {
            if (window.innerWidth >= 1024) {
                nav.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'false');
                syncBodyLock();
                return;
            }

            if (toggle.getAttribute('aria-expanded') !== 'true') {
                nav.classList.add('hidden');
            }
            syncBodyLock();
        };

        toggle.addEventListener('click', () => {
            if (toggle.getAttribute('aria-expanded') === 'true') {
                closeNav();
                return;
            }

            openNav();
        });

        nav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeNav();
                }
            });
        });

        window.addEventListener('resize', syncDesktopState);
        syncDesktopState();
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupMobileNav);
} else {
    setupMobileNav();
}
