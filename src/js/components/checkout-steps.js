const STEP_SELECTOR = '[data-step]';
const INDICATOR_SELECTOR = '[data-step-target]';
const FIELD_SELECTOR = '.checkout-field';
const INVALID_CLASS = 'woocommerce-invalid';

// Shows WooCommerce's single checkout form in three steps. All fields stay
// in one form, so WooCommerce's own validation, recalculation and order
// placement keep working; this only decides which part is visible.
class CheckoutSteps {
    init() {
        this.form = document.querySelector('.checkout-page__form');
        if (!this.form) return;

        this.steps = [...this.form.querySelectorAll(STEP_SELECTOR)];
        this.indicators = [...this.form.querySelectorAll(INDICATOR_SELECTOR)];
        this.order = this.steps.map(step => step.dataset.step);
        this.current = this.order[0];
        this.reached = 0;

        this.form.addEventListener('click', event => {
            const next = event.target.closest('[data-step-next]');
            const prev = event.target.closest('[data-step-prev]');
            const indicator = event.target.closest(INDICATOR_SELECTOR);

            if (next) {
                if (this.validate(this.current)) this.show(next.dataset.stepNext);
            } else if (prev) {
                this.show(prev.dataset.stepPrev);
            } else if (indicator && this.order.indexOf(indicator.dataset.stepTarget) <= this.reached) {
                this.show(indicator.dataset.stepTarget);
            }
        });

        // Enter in a field moves on to the next step instead of placing the order.
        this.form.addEventListener('keydown', event => {
            if (event.key !== 'Enter' || !event.target.matches('input')) return;
            if (this.current === this.order[this.order.length - 1]) return;

            event.preventDefault();
            const next = this.order[this.order.indexOf(this.current) + 1];
            if (this.validate(this.current)) this.show(next);
        });

        // The shipping list is re-rendered after every recalculation.
        if (window.jQuery) {
            window.jQuery(document.body).on('updated_checkout', () => this.fillRecap());
        }

        // WooCommerce reports errors after "place order" and names the
        // fields concerned: mark them and go back to the step of the first.
        if (window.jQuery) {
            window.jQuery(document.body).on('checkout_error', () => {
                const fields = [...this.form.querySelectorAll('.woocommerce-NoticeGroup [data-id]')]
                    .map(item => document.getElementById(`${item.dataset.id}_field`))
                    .filter(Boolean);

                fields.forEach(field => field.classList.add(INVALID_CLASS));

                const first = fields[0] || this.form.querySelector(`.${INVALID_CLASS}`);
                const step = first ? first.closest(STEP_SELECTOR) : null;
                if (step && step.dataset.step !== this.current) this.show(step.dataset.step, false);
            });
        }
    }

    // Uses WooCommerce's own field validation and adds a check for empty
    // required fields, which WooCommerce only reports on submit.
    validate(name) {
        const step = this.steps.find(item => item.dataset.step === name);
        const fields = [...step.querySelectorAll(FIELD_SELECTOR)];

        fields.forEach(field => {
            const input = field.querySelector('input, select, textarea');
            if (!input) return;

            if (window.jQuery) window.jQuery(input).trigger('validate');

            const empty = field.classList.contains('validate-required') && !input.value.trim();
            const badEmail = input.type === 'email' && input.value.trim() && !input.checkValidity();
            if (empty || badEmail) {
                field.classList.add(INVALID_CLASS);
                input.setAttribute('aria-invalid', 'true');
            }
        });

        const firstInvalid = step.querySelector(`.${INVALID_CLASS} input, .${INVALID_CLASS} select, .${INVALID_CLASS} textarea`);
        if (firstInvalid) {
            firstInvalid.focus();
            return false;
        }

        return true;
    }

    // Repeats the entered address and the chosen shipping method in the
    // later steps.
    fillRecap() {
        const value = id => {
            const field = this.form.querySelector(`#${id}`);
            return field ? field.value.trim() : '';
        };
        const setLine = (box, key, parts) => {
            const line = box.querySelector(`[data-recap-line="${key}"]`);
            if (line) line.textContent = parts.filter(Boolean).join(' ');
        };
        const country = this.form.querySelector('select#billing_country');

        this.form.querySelectorAll('[data-recap="address"]').forEach(box => {
            setLine(box, 'name', [value('billing_first_name'), value('billing_last_name')]);
            setLine(box, 'street', [value('billing_address_1')]);
            setLine(box, 'place', [value('billing_postcode'), value('billing_city')]);
            setLine(box, 'country', [country ? country.options[country.selectedIndex].text : box.dataset.country]);
        });

        const chosen = this.form.querySelector('.checkout-shipping .checkout-options__input:checked');
        const option = chosen ? chosen.closest('.checkout-options__item') : null;
        const text = selector => {
            const element = option ? option.querySelector(selector) : null;
            return element ? element.textContent.trim() : '';
        };

        this.form.querySelectorAll('[data-recap="shipping"]').forEach(box => {
            const line = box.querySelector('[data-recap-line="shipping"]');
            if (line) line.textContent = [text('.checkout-options__name'), text('.checkout-options__price')].filter(Boolean).join(' · ');
        });
    }

    show(name, moveFocus = true) {
        const index = this.order.indexOf(name);
        if (index === -1) return;

        this.current = name;
        this.reached = Math.max(this.reached, index);

        this.steps.forEach(step => {
            step.hidden = step.dataset.step !== name;
        });

        this.indicators.forEach((indicator, position) => {
            const button = indicator.querySelector('button');
            indicator.classList.toggle('is-active', position === index);
            indicator.classList.toggle('is-done', position < index);
            button.disabled = position > this.reached;
            if (position === index) {
                button.setAttribute('aria-current', 'step');
            } else {
                button.removeAttribute('aria-current');
            }
        });

        this.fillRecap();

        // The address decides which shipping methods and totals apply.
        if (index > 0 && window.jQuery) window.jQuery(document.body).trigger('update_checkout');

        const top = this.form.getBoundingClientRect().top + window.scrollY - 24;
        if (window.scrollY > top) window.scrollTo({ top, behavior: 'auto' });

        if (moveFocus) {
            const heading = this.steps[index].querySelector('.checkout-page__heading');
            if (heading && heading.hasAttribute('tabindex')) heading.focus({ preventScroll: true });
        }
    }
}

export default CheckoutSteps;
