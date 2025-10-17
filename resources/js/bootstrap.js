import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;
window.Pusher = Pusher;

// Gunakan VITE_ prefix
const REVERB = {
    id: import.meta.env.VITE_REVERB_APP_ID ?? 'app-id-12345',
    key: import.meta.env.VITE_REVERB_APP_KEY ?? 'app-key-12345',
    secret: import.meta.env.VITE_REVERB_APP_SECRET ?? 'app-secret-12345', // Opsional, jarang dipakai di client
    host: import.meta.env.VITE_REVERB_HOST ?? '127.0.0.1',
    port: import.meta.env.VITE_REVERB_PORT ? Number(import.meta.env.VITE_REVERB_PORT) : 8080,
    scheme: import.meta.env.VITE_REVERB_SCHEME ?? 'http',
};

console.log('🔄 Initializing Laravel Echo with Reverb...', REVERB);

const baseUrl = `${REVERB.scheme}://${REVERB.host}${REVERB.port ? `:${REVERB.port}` : ''}`;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: REVERB.key,
    wsHost: REVERB.host,
    wsPort: REVERB.port,
    wssPort: REVERB.port,
    forceTLS: REVERB.scheme === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Debugging tetap sama
window.Echo.connector.pusher.bind('connected', () => {
    console.log('✅ WebSocket connected successfully to Reverb');
});

window.Echo.connector.pusher.bind('error', (err) => {
    console.error('❌ WebSocket connection error:', err);
});