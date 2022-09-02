import { createRouter, createWebHistory } from "vue-router";

import Login from './components/auth/Login.vue'
import Logout from './components/auth/Logout.vue'
import ForgotPassword from './components/auth/ForgotPassword.vue'
import ResetPassword from './components/auth/ResetPassword.vue'
import Registration from './components/auth/Registration.vue'

import Home from './components/Home.vue'
import CourseCatalog from './components/CourseCatalog.vue'
import Profile from './components/Profile.vue'
import CourseLearning from './components/CourseLearning.vue'
import LessonLearning from './components/LessonLearning.vue'
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
        {path:'/logout', component: Logout, name: 'logout',meta:{layout: "guest"}},
        {path:'/forgot_password', component: ForgotPassword, name: 'forgot-password',meta:{layout: "guest"}},
        {path:'/reset-password', component: ResetPassword, name: 'reset-password',meta:{layout: "guest"}},
        {path:'/register', component: Registration, name: 'register',meta:{layout: "guest"}},
        {path:'/home', component: CourseCatalog, name: 'home'},
        {path:'/profile', component: Profile, name: 'profile'},
        {path:'/catalog', component: CourseCatalog, name: 'course-catalog'},
        {path:'/learnings/:learning/lessons/:lesson', component: LessonLearning, name: 'lesson',meta:{layout: "learning"}},
        {path:'/learning/:id', component: CourseLearning, name: 'course-learning'},
        {path:'/admin/courses', component: AdminCourses, name: 'admin-courses'},
        {path:'/admin/courses/:id', component: AdminModules, name: 'admin-modules'},
        {path:'/admin/modules/:id', component: AdminLessons, name: 'admin-lessons'},
        {path:'/admin/lessons/:id', component: AdminLesson, name: 'admin-lesson'},
        {path: '/:pathMatch(.*)*', component: NotFound,meta:{layout: "guest"} },
    ]
})

export default router;