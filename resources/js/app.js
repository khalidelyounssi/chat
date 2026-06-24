import './bootstrap';

const setupMobileNav = () => {
    const toggles = document.querySelectorAll('[data-mobile-nav-toggle]');
    const backdrop = document.querySelector('[data-mobile-nav-backdrop]');

    if (!toggles.length) {
        return;
    }

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
            syncBodyLock();
        };

        const openNav = () => {
            nav.classList.remove('hidden');
            nav.classList.add('is-open');
            nav.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', 'Fermer le menu');
            syncBodyLock();
        };

        const syncDesktopState = () => {
            if (window.innerWidth >= 1024) {
                nav.classList.remove('hidden');
                nav.classList.remove('is-open');
                nav.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Ouvrir le menu');
                syncBodyLock();
                return;
            }

            if (toggle.getAttribute('aria-expanded') !== 'true') {
                nav.classList.add('hidden');
                nav.classList.remove('is-open');
                nav.setAttribute('aria-hidden', 'true');
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
    if (!document.body.classList.contains('site-shell')) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const targets = Array.from(document.querySelectorAll([
        'main > section',
        'main .section-card',
        'main .luminous-panel',
        'main .cat-card',
        'main .metric-card',
        'main .detail-pill',
        'main .gallery-tile',
    ].join(', ')));

    if (!targets.length) {
        return;
    }

    targets.forEach((target) => {
        target.setAttribute('data-reveal', '');
    });

    targets.forEach((target) => {
        const siblings = Array.from(target.parentElement?.children ?? []).filter((element) => element.hasAttribute('data-reveal'));
        const revealIndex = Math.max(siblings.indexOf(target), 0);
        target.style.setProperty('--reveal-delay', `${Math.min(revealIndex * 80, 280)}ms`);
    });

    const showTarget = (target) => {
        target.classList.add('is-visible');
    };

    if (!('IntersectionObserver' in window)) {
        targets.forEach(showTarget);
        document.body.classList.add('motion-ready');
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            showTarget(entry.target);
            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0.14,
        rootMargin: '0px 0px -8% 0px',
    });

    targets.forEach((target, index) => {
        if (index < 3) {
            showTarget(target);
            return;
        }

        observer.observe(target);
    });

    document.body.classList.add('motion-ready');
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
