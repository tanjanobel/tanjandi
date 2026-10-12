const BUTTON_SELECTOR = '.cart-item__quantity-button';
const INPUT_SELECTOR = '.cart-item__quantity-input';
const UPDATE_SELECTOR = '.cart-page__update';
const UPDATE_DELAY = 500;

// Plus/minus buttons of the cart quantity field. WooCommerce only ships a
// plain number input plus an "update cart" button; this steps the value and
// presses that button once the visitor stops clicking. Listeners are
// delegated because WooCommerce replaces the cart markup after each update.
class CartQuantity {
    init() {
        if (!document.querySelector('.cart-page')) return;

        this.timer = null;

        document.addEventListener('click', event => {
            const button = event.target.closest(BUTTON_SELECTOR);
            if (!button) return;

            const input = button.parentElement.querySelector(INPUT_SELECTOR);
            if (!input) return;

            const before = input.value;
            if (Number(button.dataset.step) > 0) {
                input.stepUp();
            } else {
                input.stepDown();
            }

            if (input.value !== before) {
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });

        document.addEventListener('change', event => {
            if (!event.target.matches(INPUT_SELECTOR)) return;

            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.update(), UPDATE_DELAY);
        });
    }

    update() {
        const button = document.querySelector(UPDATE_SELECTOR);
        if (!button) return;

        button.disabled = false;
        button.click();
    }
}

export default CartQuantity;
