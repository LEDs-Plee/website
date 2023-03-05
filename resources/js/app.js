import * as bootstrap from 'bootstrap'
import './bootstrap'
import utilities from "./utilities";

window.utilities = utilities;

const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

let pushToggle = document.getElementById('push-toggle');
let notifyAlert = document.getElementById('notify-alert');
let notifyWasher = document.getElementById('notify-washer');
let notifyToilet = document.getElementById('notify-toilet');

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
            pushToggle.innerText = ' Enabled';
            notifyAlert.hidden = true;
            notifyWasher.classList.remove('disabled');
            notifyToilet.classList.remove('disabled');
        }
    });
});

pushToggle.addEventListener('click', e => {
    e.preventDefault();
    if(e.target.classList.contains('bi-bell-fill')) {
        utilities.push.enablePushNotifications();
        pushToggle.classList.remove('bi-bell-fill');
        pushToggle.classList.add('bi-bell-slash-fill');
        pushToggle.innerText = ' Enabled';
        notifyAlert.hidden = true;
        notifyWasher.classList.remove('disabled');
        notifyToilet.classList.remove('disabled');
    } else {
        utilities.push.disablePushNotifications();
        pushToggle.classList.remove('bi-bell-slash-fill');
        pushToggle.classList.add('bi-bell-fill');
        pushToggle.innerText = ' Disabled';
        notifyAlert.hidden = false;
        notifyWasher.classList.add('disabled');
        notifyToilet.classList.add('disabled');
    }
});
