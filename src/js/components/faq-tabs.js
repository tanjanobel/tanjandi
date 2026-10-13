const ROOT_SELECTOR = '.faq';
const GROUP_SELECTOR = '.faq__group';
const LINK_SELECTOR = '[data-faq-nav] .side-nav__link';
const READY_CLASS = 'faq--ready';
const ACTIVE_CLASS = 'faq__group--active';
const CURRENT_CLASS = 'side-nav__link--current';

// Turns the FAQ groups into tabs: the navigation shows one group at a time.
// Without this script all groups are listed below each other and the
// navigation jumps to them.
class FaqTabs {
    init() {
        this.root = document.querySelector(ROOT_SELECTOR);
        if (!this.root) return;

        this.groups = Array.from(this.root.querySelectorAll(GROUP_SELECTOR));
        this.links = Array.from(document.querySelectorAll(LINK_SELECTOR));
        if (!this.groups.length || !this.links.length) return;

        this.links.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const id = link.hash.slice(1);
                this.show(id);
                window.history.replaceState(null, '', `#${id}`);
            });
        });

        // A link to one of the groups, also when followed on the page itself.
        window.addEventListener('hashchange', () => this.showRequested());

        this.showRequested();
        this.root.classList.add(READY_CLASS);
    }

    showRequested() {
        const requested = window.location.hash.slice(1);
        const known = this.groups.some(group => group.id === requested);

        if (known) {
            this.show(requested);
        } else if (!this.root.querySelector(`.${ACTIVE_CLASS}`)) {
            this.show(this.groups[0].id);
        }
    }

    show(id) {
        this.groups.forEach(group => {
            group.classList.toggle(ACTIVE_CLASS, group.id === id);
        });

        this.links.forEach(link => {
            const isCurrent = link.hash.slice(1) === id;

            link.classList.toggle(CURRENT_CLASS, isCurrent);

            if (isCurrent) {
                link.setAttribute('aria-current', 'true');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }
}

export default FaqTabs;
