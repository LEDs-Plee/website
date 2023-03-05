const csrfToken = document.querySelector('meta[name=csrf-token]').getAttribute('content');;
const vapidPubkey = document.querySelector('meta[name=vapid-pubkey]').getAttribute('content');;

export default {
    push: {
        enablePushNotifications: () => {
            navigator.serviceWorker.ready.then(registration => {
                registration.pushManager.getSubscription().then(subscription => {
                    if (subscription) {
                        return subscription;
                    }

                    const serverKey = urlBase64ToUint8Array(vapidPubkey);

                    return registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: serverKey
                    });
                }).then(subscription => {
                    if (!subscription) {
                        alert('Error occured while subscribing');
                        return;
                    }
                    subscribe(subscription);
                });
            });
        },
        disablePushNotifications: () => {
            navigator.serviceWorker.ready.then(registration => {
                registration.pushManager.getSubscription().then(subscription => {
                    if (!subscription) {
                        return;
                    }

                    subscription.unsubscribe().then(() => {
                        fetch('/push/unsubscribe', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                endpoint: subscription.endpoint
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Success:', data);
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                            });
                    })
                });
            });
        },

    }
}

function subscribe(sub) {
    const key = sub.getKey('p256dh')
    const token = sub.getKey('auth')
    const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0]

    const data = {
        endpoint: sub.endpoint,
        public_key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
        auth_token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
        encoding: contentEncoding,
    };

    console.log(data);

    fetch('/push/subscribe', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}
function urlBase64ToUint8Array(base64String) {
    var padding = "=".repeat((4 - (base64String.length % 4)) % 4);
    var base64 = (base64String + padding).replace(/\-/g, "+").replace(/_/g, "/");

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }

    return outputArray;
}
