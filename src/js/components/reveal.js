const SELECTOR = '.section__heading, .section__lead, .cta__container, .testimonial-slider';

// Repeated grid/list items - staggered relative to their siblings within the
// same row instead of all fading in at once.
const STAGGER_SELECTOR = '.service, .service-card, .step, .value-card, .employee-card, .project-card, .project-advantage';
const STAGGER_STEP_MS = 100;
const STAGGER_MAX_STEPS = 5;

export default class Reveal {
    init() {
        this.assignStaggerDelays();

        const elements = document.querySelectorAll(`${SELECTOR}, ${STAGGER_SELECTOR}`);

        if (!elements.length) {
            return;
        }

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion) {
            elements.forEach(el => el.classList.add('is-visible'));
            return;
        }

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -8% 0px'
        });

        elements.forEach(el => {
            // Elements already in (or above) the viewport on load are shown
            // immediately instead of animated, so nothing appears to flash
            // or fade in on first paint.
            const rect = el.getBoundingClientRect();
            const alreadyVisible = rect.top < window.innerHeight && rect.bottom > 0;

            if (alreadyVisible) {
                el.classList.add('is-visible');
                return;
            }

            observer.observe(el);
        });
    }

    // Groups repeated items (e.g. the 3 service-cards in a row) by their
    // nearest shared wrapper and gives each one an increasing transition
    // delay by its position in that group, so a row cascades in left to
    // right instead of appearing all at once.
    assignStaggerDelays() {
        const elements = document.querySelectorAll(STAGGER_SELECTOR);
        const groups = new Map();

        elements.forEach(el => {
            const group = el.closest('.wp-block-columns') || el.parentElement;

            if (!groups.has(group)) {
                groups.set(group, []);
            }

            groups.get(group).push(el);
        });

        groups.forEach(group => {
            group.forEach((el, index) => {
                el.style.transitionDelay = `${Math.min(index, STAGGER_MAX_STEPS) * STAGGER_STEP_MS}ms`;
            });
        });
    }
}
