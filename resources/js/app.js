/**
 * Lightweight interactions for the UI prototype (tabs, modals, live values).
 */
document.addEventListener('click', (event) => {
    const tabButton = event.target.closest('[data-tab]');

    if (tabButton) {
        const group = tabButton.closest('[data-tabs]');

        group.querySelectorAll('[data-tab]').forEach((button) => {
            button.setAttribute('aria-selected', String(button === tabButton));
        });

        group.querySelectorAll('[data-panel]').forEach((panel) => {
            panel.hidden = panel.dataset.panel !== tabButton.dataset.tab;
        });
    }

    const opener = event.target.closest('[data-open]');

    if (opener) {
        document.getElementById(opener.dataset.open)?.showModal();
    }

    const closer = event.target.closest('[data-close]');

    if (closer) {
        closer.closest('dialog')?.close();
    }
});

const formatMoney = (value) => new Intl.NumberFormat('vi-VN').format(Math.round(value)) + 'đ';

const splitForm = document.querySelector('[data-split-form]');

if (splitForm) {
    const inputs = [...splitForm.querySelectorAll('[data-split]')];

    const update = () => {
        const percents = Object.fromEntries(inputs.map((input) => [input.dataset.split, Math.max(0, Number(input.value) || 0)]));
        const total = Object.values(percents).reduce((sum, value) => sum + value, 0);
        const isValid = total === 100;
        const output = splitForm.querySelector('[data-split-total]');

        output.textContent = `${total}%`;
        output.classList.toggle('text-emerald-600', isValid);
        output.classList.toggle('text-rose-600', !isValid);
        splitForm.querySelector('[data-split-error]')?.classList.toggle('hidden', isValid);
        splitForm.querySelector('[data-split-save]')?.toggleAttribute('disabled', !isValid);

        Object.entries(percents).forEach(([key, value]) => {
            splitForm.querySelector(`[data-split-bar="${key}"]`)?.style.setProperty('width', `${Math.min(value, 100)}%`);
            document.querySelectorAll(`[data-split-label="${key}"]`).forEach((label) => {
                label.textContent = `${value}%`;
            });
        });

        document.querySelectorAll('[data-profit-row]').forEach((row) => {
            const profit = Number(row.dataset.profit);

            row.querySelectorAll('[data-share]').forEach((cell) => {
                cell.textContent = formatMoney((profit * (percents[cell.dataset.share] ?? 0)) / 100);
            });
        });
    };

    splitForm.addEventListener('input', update);
    splitForm.addEventListener('reset', () => setTimeout(update));
    update();
}
