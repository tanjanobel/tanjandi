export default class ContactForm {
    init() {
        this.initAutoResize();
    }

    initAutoResize() {
        const textareas = document.querySelectorAll('.contact-form textarea');

        textareas.forEach(textarea => {
            // Set initial height
            this.resize(textarea);

            textarea.addEventListener('input', () => {
                this.resize(textarea);
            });
        });
    }

    resize(textarea) {
        textarea.style.height = ''; // Reset height to allow shrinking
        const offset = textarea.offsetHeight - textarea.clientHeight;
        const newHeight = textarea.scrollHeight + offset;

        // Only apply height if it's greater than the initial height (48px)
        if (newHeight > 48) {
            textarea.style.height = newHeight + 'px';
        } else {
            textarea.style.height = '48px';
        }
    }
}
