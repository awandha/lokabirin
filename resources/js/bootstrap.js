import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Laravel Echo + Pusher
 */
import Echo from 'laravel-echo';

// If you installed pusher-js:
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

console.log('🔵 Bootstrap JS loaded');
console.log('🔵 Echo:', window.Echo);