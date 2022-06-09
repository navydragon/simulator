require('./bootstrap');

import { Vue,createApp } from 'vue';
import router from './routes';
import axios from 'axios';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://127.0.0.1:8000';

axios.defaults.headers.common = {'Authorization': `${localStorage.getItem('token_type') || null} ${localStorage.getItem('access_token') || null}`}



import App from './components/App.vue'

import 'tw-elements';

import { library, dom } from "@fortawesome/fontawesome-svg-core";

import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas)
dom.watch();

import GuestLayout from './components/layouts/guest/Guest.vue'
import UserLayout from './components/layouts/user/User.vue'





const app = createApp (App)
app.component('guest-layout',GuestLayout);
app.component('user-layout',UserLayout);

app.use(router);

import CKEditor from '@ckeditor/ckeditor5-vue';
app.use(CKEditor)
axios.get('/api/user')
.then(response => {
    console.log(response.data);
    let user = response.data
    app.provide('user',user)
})
.catch (error =>{
    let user = null
    app.provide('user',user)
})
.finally(response => {
    app.mount ("#app");
})

//app.mount ("#app");


