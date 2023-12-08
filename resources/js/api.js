import axios from "axios";
import router from "./router.js";

const api = axios.create();
//start request
api.interceptors.request.use(config => {
    if(localStorage.access_token){
        config.headers.authorization = `Bearer ${localStorage.access_token}`
    }
    return config
}, (error) => {
    return Promise.reject(error);
});
//end request

api.interceptors.response.use(config => {
    if(localStorage.access_token){
        config.headers.authorization = `Bearer ${localStorage.access_token}`
    }
    return config
},  function (error)  {
        if(error.response.data.message === 'Token has expired'){
            axios.post('/api/auth/refresh', {}, {
                headers: {
                    'authorization': `Bearer ${localStorage.access_token}`
                }
            })
                .then(res => {
                    localStorage.access_token = res.data.access_token;
                    error.config.headers.authorization = `Bearer ${localStorage.access_token}`
                    return api.request(error.config)
                })
        }
    if(error.response.data.message === 'Request failed with status code 401'){
        router.push({name: 'user.login'})
    }
    return Promise.reject(error);
});





export default api



