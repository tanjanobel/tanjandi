export default class TestimonialSlider {
    init() {
        const update = () => {
            document.querySelectorAll('.uc_quote_item .ue-text').forEach(ueText => {
                // Skip items the visitor currently has expanded - the button
                // must stay visible so they can collapse it again.
                if (ueText.classList.contains('ue-active')) {
                    return;
                }

                const p = ueText.querySelector('p');
                const btn = ueText.nextElementSibling;
                if (!p || !btn || !btn.classList.contains('ue-text-unfold-btn')) {
                    return;
                }

                const isTruncated = p.scrollHeight > p.clientHeight + 1;
                btn.style.display = isTruncated ? '' : 'none';
            });
        };

        update();
        window.addEventListener('resize', update);
    }
}
