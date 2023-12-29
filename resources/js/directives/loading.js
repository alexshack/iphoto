export default (el, {value, newValue}) => {
    const spinnerClass = 'spinner-border';
    if (value) {
        if (el.querySelectorAll(`.${spinnerClass}`).length === 0) {
            let loadingSpinner = document.createElement('span');
            loadingSpinner.classList.add(spinnerClass);
            loadingSpinner.classList.add('spinner-border-sm');
            loadingSpinner.setAttribute('role', 'status');
            loadingSpinner.setAttribute('aria-hidden', 'true');
            el.prepend(loadingSpinner);
        }

        if (el.tagName === 'BUTTON') {
            el.setAttribute('disabled', '');
        }
    } else {
        let spinners = el.querySelectorAll(`.${spinnerClass}`);
        spinners.forEach((spinner) => {
            spinner.remove();
        });
        if (el.tagName === 'BUTTON') {
            el.removeAttribute('disabled');
        }
    }
};
