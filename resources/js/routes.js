import { createRouter, createWebHistory } from "vue-router";

import Login from './components/auth/Login.vue'
import Registration from './components/auth/Registration.vue'

import Home from './components/Home.vue'
import AdminCourses from './components/admin/courses/Courses.vue'
import AdminModules from './components/admin/modules/Modules.vue'
import AdminLessons from './components/admin/lessons/Lessons.vue'
import AdminLesson from './components/admin/lessons/Lesson.vue'
import NotFound from './components/layouts/NotFound.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path:'/', component: Login,meta:{layout: "guest"}},
        {path:'/login', component: Login, name: 'login',meta:{layout: "guest"}},
        {path:'/register', component: Registration, name: 'register',meta:{layout: "guest"}},
        {path:'/home', component: Home, name: 'home'},
        {path:'/admin/courses', component: AdminCourses, name: 'admin-courses'},
        {path:'/admin/courses/:id', component: AdminModules, name: 'admin-modules'},
        {path:'/admin/modules/:id', component: AdminLessons, name: 'admin-lessons'},
        {path:'/admin/lessons/:id', component: AdminLesson, name: 'admin-lesson'},
        {path: '/:pathMatch(.*)*', component: NotFound,meta:{layout: "guest"} },
    ]
})

export default router;