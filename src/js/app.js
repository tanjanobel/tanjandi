import Header from './components/header';
import CartCount from './components/cart-count';
import CartQuantity from './components/cart-quantity';
import CheckoutSteps from './components/checkout-steps';
import ContactForm from './components/contact-form';
import TestimonialSlider from './components/testimonial-slider';
import Reveal from './components/reveal';
import CookieBannerA11yFix from './components/cookie-banner-a11y-fix';

document.addEventListener('DOMContentLoaded', () => {
    // Initialize components
    const header = new Header();
    header.init();

    const cartCount = new CartCount();
    cartCount.init();

    const cartQuantity = new CartQuantity();
    cartQuantity.init();

    const checkoutSteps = new CheckoutSteps();
    checkoutSteps.init();

    const contactForm = new ContactForm();
    contactForm.init();

    const testimonialSlider = new TestimonialSlider();
    testimonialSlider.init();

    const reveal = new Reveal();
    reveal.init();

    const cookieBannerA11yFix = new CookieBannerA11yFix();
    cookieBannerA11yFix.init();
});
