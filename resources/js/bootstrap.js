import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;
window.Pusher = Pusher;

console.log('🔄 Initializing Laravel Echo with Reverb...');

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY ?? 'be9d9mdfxlzls3k7glzd',
    wsHost: import.meta.env.VITE_REVERB_HOST ?? 'gabahapi.test',
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'ws') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: `http://${import.meta.env.VITE_REVERB_HOST}/api/broadcasting/auth`,
    auth: {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
            Accept: 'application/json',
        },
    },
});

// === Debugging Listener
window.Echo.connector.pusher.bind('connected', () => {
    console.log('✅ WebSocket connected successfully to Reverb');
});

window.Echo.connector.pusher.bind('error', (err) => {
    console.error('❌ WebSocket connection error:', err);
});
