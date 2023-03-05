import * as bootstrap from 'bootstrap'
import './bootstrap'
import utilities from "./utilities";

window.utilities = utilities;

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

let pushToggle = document.getElementById('push-toggle');

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/sw.js');
    });
}

navigator.serviceWorker.ready.then(registration => {
    registration.pushManager.getSubscription().then(subscription => {
        if (subscription) {
            pushToggle.classList.remove('bi-bell-fill');
            pushToggle.classList.add('bi-bell-slash-fill');
        }
    });
});

pushToggle.addEventListener('click', e => {
    e.preventDefault();
    if(e.target.classList.contains('bi-bell-fill')) {
        utilities.push.enablePushNotifications();
        pushToggle.classList.remove('bi-bell-fill');
        pushToggle.classList.add('bi-bell-slash-fill');
    } else {
        utilities.push.disablePushNotifications();
        pushToggle.classList.remove('bi-bell-slash-fill');
        pushToggle.classList.add('bi-bell-fill');
    }
});
