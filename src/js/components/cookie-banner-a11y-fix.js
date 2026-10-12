const CLOSE_BUTTON_SELECTOR = '.cky-btn-close';
const CORRECT_LABEL = 'Schliessen';

// The CookieYes preference-center close button ships with an aria-label
// misconfigured in the plugin's own banner content (picked up unrelated
// page text instead of a real "close" label). The plugin renders its
// banner asynchronously and outside our control, so we watch for the
// button to appear and correct the label in place rather than depending
// on a plugin setting.
export default class CookieBannerA11yFix {
    init() {
        const existing = document.querySelector(CLOSE_BUTTON_SELECTOR);

        if (existing) {
            this.fix(existing);
            return;
        }

        const observer = new MutationObserver(() => {
            const button = document.querySelector(CLOSE_BUTTON_SELECTOR);

            if (button) {
                this.fix(button);
                observer.disconnect();
            }
        });

        observer.observe(document.body, { childList: true, subtree: true });
    }

    fix(button) {
        button.setAttribute('aria-label', CORRECT_LABEL);
    }
}
