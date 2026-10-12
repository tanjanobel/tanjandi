class Header {
    constructor() {
        this.headerElement = document.querySelector('.header') || document.querySelector('.site-header');
        this.lastScrollY = window.scrollY;
        this.scrollThreshold = 100;
    }

    init() {
        if (!this.headerElement) return;

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            const isScrollingUp = currentScrollY < this.lastScrollY;

            // Über dem Threshold: Fixed-Verhalten aktivieren
            if (currentScrollY > this.scrollThreshold) {
                if (isScrollingUp) {
                    // Falls der Header noch nicht fixiert ist, fügen wir die Klasse ohne Animation hinzu,
                    // damit er von opacity 0 aus einblendet (anstatt von 1 runter zu faden).
                    if (!this.headerElement.classList.contains('header--fixed')) {
                        const originalTransition = this.headerElement.style.transition;
                        this.headerElement.style.transition = 'none';
                        this.headerElement.classList.add('header--fixed');

                        // Force reflow
                        this.headerElement.offsetHeight;

                        this.headerElement.style.transition = originalTransition;
                    }
                    this.headerElement.classList.add('header--visible');
                } else {
                    // Beim Runterscrollen nur ausblenden, aber fixiert lassen (falls er es schon war),
                    // damit das Ausfaden sauber funktioniert.
                    this.headerElement.classList.remove('header--visible');
                }
            } else {
                // Unter dem Threshold: Fixed-Verhalten deaktivieren
                // Wir lassen es aber beim hochscrollen richtung 0 langsam ausblenden,
                // bevor wir die Klasse ganz entfernen.
                if (currentScrollY <= 10) {
                    this.headerElement.classList.remove('header--fixed');
                    this.headerElement.classList.remove('header--visible');
                } else if (!isScrollingUp) {
                     // Wenn wir unter den Threshold scrollen (nach unten),
                     // direkt ausblenden (falls es noch da war).
                     this.headerElement.classList.remove('header--visible');
                }
            }

            this.lastScrollY = currentScrollY;
        }, { passive: true });
    }
}

export default Header;
