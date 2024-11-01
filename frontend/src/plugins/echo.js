import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;  

const echo = new Echo({  
    broadcaster: 'pusher',  
    key: process.env.VUE_APP_PUSHER_APP_KEY,
    cluster: process.env.VUE_APP_PUSHER_APP_CLUSTER,
    encrypted: true,
    wsHost: 'localhost',  
    wsPort: process.env.VUE_APP_PUSHER_PORT || 6001,  
    forceTLS: false,
    disableStats: true,  
});  

export default echo;