import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;  

const echo = new Echo({  
    broadcaster: 'pusher',  
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    wsHost: import.meta.env.VITE_PUSHER_HOST,  
    wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
    forceTLS: false,
    disableStats: true,  
});  

export default echo;