import axios from "axios";

const baseUrl = "http://0.0.0.0:8088/"
const api = axios.create({  
    baseURL: baseUrl,
});  

export default api;