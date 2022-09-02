require('./bootstrap');

import { Vue,createApp } from 'vue';
import router from './routes';
import axios from 'axios';

axios.defaults.withCredentials = true;
//axios.defaults.baseURL = 'http://127.0.0.1:8000';
axios.defaults.baseURL = 'https://simulator.emiit.ru';

axios.defaults.headers.common = {'Authorization': `${localStorage.getItem('token_type') || null} ${localStorage.getItem('access_token') || null}`}



import App from './components/App.vue'

import 'tw-elements';

import { library, dom } from "@fortawesome/fontawesome-svg-core";

import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas)
dom.watch();

import GuestLayout from './components/layouts/guest/Guest.vue'
import UserLayout from './components/layouts/user/User.vue'
import LearningLayout from './components/layouts/learning/Learning.vue'




const app = createApp (App)
app.component('guest-layout',GuestLayout);
app.component('user-layout',UserLayout);
app.component('learning-layout',LearningLayout);

app.use(router);

import CKEditor from '@ckeditor/ckeditor5-vue';

app.use(CKEditor)

axios.get('/api/user')
.then(response => {
    let user = response.data
    console.log(user);
    app.provide('user',user)
})
.catch (error =>{
    let user = ""
    app.provide('user',user)
})
.finally(response => {
    app.mount ("#app");
})

//app.mount ("#app");


