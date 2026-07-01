import './bootstrap';

const setupMobileNav = () => {
    const toggles = document.querySelectorAll('[data-mobile-nav-toggle]');
    const backdrop = document.querySelector('[data-mobile-nav-backdrop]');

    if (!toggles.length) {
        return;
    }

    const syncToggleIcons = (toggle, isOpen) => {
        const openIcon = toggle.querySelector('.menu-open-icon');
        const closeIcon = toggle.querySelector('.menu-close-icon');

        openIcon?.classList.toggle('hidden', isOpen);
        closeIcon?.classList.toggle('hidden', !isOpen);
    };

    const syncBodyLock = () => {
        const anyOpen = Array.from(toggles).some((toggle) => toggle.getAttribute('aria-expanded') === 'true' && window.innerWidth < 1024);
        document.body.classList.toggle('overflow-hidden', anyOpen);
        document.body.classList.toggle('mobile-nav-open', anyOpen);

        if (backdrop) {
            backdrop.classList.toggle('hidden', !anyOpen || window.innerWidth >= 1024);
            backdrop.setAttribute('aria-hidden', anyOpen && window.innerWidth < 1024 ? 'false' : 'true');
        }
    };

    toggles.forEach((toggle) => {
        const targetId = toggle.getAttribute('data-mobile-nav-target') || toggle.getAttribute('aria-controls');
        const nav = targetId ? document.getElementById(targetId) : null;

        if (!nav) {
            return;
        }

        const closeNav = () => {
            nav.classList.add('hidden');
            nav.classList.remove('is-open');
            nav.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Ouvrir le menu');
            syncToggleIcons(toggle, false);
            syncBodyLock();
        };

        const openNav = () => {
            nav.classList.remove('hidden');
            nav.classList.add('is-open');
            nav.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', 'Fermer le menu');
            syncToggleIcons(toggle, true);
            syncBodyLock();
        };

        const syncDesktopState = () => {
            if (window.innerWidth >= 1024) {
                nav.classList.remove('hidden');
                nav.classList.remove('is-open');
                nav.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Ouvrir le menu');
                syncToggleIcons(toggle, false);
                syncBodyLock();
                return;
            }

            if (toggle.getAttribute('aria-expanded') !== 'true') {
                nav.classList.add('hidden');
                nav.classList.remove('is-open');
                nav.setAttribute('aria-hidden', 'true');
                syncToggleIcons(toggle, false);
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

        backdrop?.addEventListener('click', closeNav);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
                closeNav();
            }
        });

        window.addEventListener('resize', syncDesktopState);
        syncDesktopState();
    });
};

const setupMotionExperience = () => {
    document.body.classList.remove('motion-ready');
};

const setupPageLoader = () => {
    const loader = document.querySelector('[data-page-loader]');

    if (!loader) {
        return;
    }

    const hideLoader = () => {
        document.body.classList.remove('is-loading');
    };

    window.addEventListener('load', hideLoader, { once: true });
    window.setTimeout(hideLoader, 1400);
};

const setupLightbox = () => {
    const root = document.querySelector('[data-lightbox]');
    const triggers = Array.from(document.querySelectorAll('[data-lightbox-trigger]'));

    if (!root || !triggers.length) {
        return;
    }

    const image = root.querySelector('[data-lightbox-image]');
    const caption = root.querySelector('[data-lightbox-caption]');
    const closeButtons = root.querySelectorAll('[data-lightbox-close]');
    const prevButton = root.querySelector('[data-lightbox-prev]');
    const nextButton = root.querySelector('[data-lightbox-next]');

    if (!(image instanceof HTMLImageElement) || !caption || !(prevButton instanceof HTMLButtonElement) || !(nextButton instanceof HTMLButtonElement)) {
        return;
    }

    let currentIndex = 0;

    const syncSlide = () => {
        const trigger = triggers[currentIndex];
        const src = trigger.getAttribute('data-lightbox-src') || '';
        const alt = trigger.getAttribute('data-lightbox-alt') || '';
        const text = trigger.getAttribute('data-lightbox-caption') || alt;

        image.src = src;
        image.alt = alt;
        caption.textContent = text;
    };

    const close = () => {
        root.classList.add('hidden');
        root.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
        image.src = '';
    };

    const open = (index) => {
        currentIndex = index;
        syncSlide();
        root.classList.remove('hidden');
        root.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
    };

    const move = (direction) => {
        currentIndex = (currentIndex + direction + triggers.length) % triggers.length;
        syncSlide();
    };

    triggers.forEach((trigger, index) => {
        trigger.addEventListener('click', () => open(index));
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', close);
    });

    prevButton.addEventListener('click', () => move(-1));
    nextButton.addEventListener('click', () => move(1));

    document.addEventListener('keydown', (event) => {
        if (root.classList.contains('hidden')) {
            return;
        }

        if (event.key === 'Escape') {
            close();
        }

        if (event.key === 'ArrowLeft') {
            move(-1);
        }

        if (event.key === 'ArrowRight') {
            move(1);
        }
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        setupPageLoader();
        setupMobileNav();
        setupMotionExperience();
        setupLightbox();
    });
} else {
    setupPageLoader();
    setupMobileNav();
    setupMotionExperience();
    setupLightbox();
}
