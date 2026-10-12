const COUNT_SELECTOR = '.header__cart-count';
const EMPTY_CLASS = 'header__cart-count--empty';

// Keeps the header cart count in sync after a product was added to the cart
// without a page reload. WooCommerce only re-renders its own mini-cart block.
class CartCount {
    init() {
        this.countElements = document.querySelectorAll(COUNT_SELECTOR);
        if (!this.countElements.length) return;

        document.body.addEventListener('wc-blocks_added_to_cart', () => this.refresh());

        if (window.jQuery) {
            window.jQuery(document.body).on('added_to_cart removed_from_cart', () => this.refresh());
        }
    }

    async refresh() {
        try {
            const response = await fetch(`${window.location.origin}/?rest_route=/wc/store/v1/cart`, { credentials: 'same-origin' });
            if (!response.ok) return;

            const cart = await response.json();
            const count = Number(cart.items_count) || 0;

            this.countElements.forEach(element => {
                element.textContent = count;
                element.classList.toggle(EMPTY_CLASS, count === 0);
            });
        } catch (error) {
            // The count simply stays as rendered by the server.
        }
    }
}

export default CartCount;
