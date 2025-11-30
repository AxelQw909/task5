import './bootstrap';
import 'flowbite';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';

Alpine.plugin(mask);

window.Alpine = Alpine;

Alpine.start();

const selectElements = document.querySelectorAll('.status-form #status_id');
for (let elem of selectElements) {
    const currentStatus = parseInt(elem.dataset.currentStatus);
    if ([2, 3].includes(currentStatus)) {
        elem.disabled = true;
    }
    elem.addEventListener('change', function () {
        if ([2, 3].includes(currentStatus)) {
            return;
        }
        this.form.submit();
    });
}