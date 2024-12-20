import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// window.Echo.channel('messages').listen(
//     'pusher:subscribe',

//     (event) => {
//         console.log('New message:', event.message);
//     },
// );

// window.Echo.channel('messages').listen(
//     '.message.sent', // Match the custom event name
//     (event) => {
//         console.log('New message:', event.message); // Logs the received message
//     },
// );
// window.Echo.private('chat.1').listen(
//     '.message.sent', // Match the custom event name
//     (event) => {
//         console.log('user message:', event.message); // Logs the received message
//     },
// );

// window.Echo.private(`chat.1`)
//     .listen('.message.sent', (response) => {
//         console.log("Event received from echo js:", response);
//     });




