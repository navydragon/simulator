<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="bg-white shadow  sm:rounded-md">
    <ul class="divide-y divide-gray-200">
      <li v-for="(course,index) in courses" :key="course.id">
        <a href="#" class="block hover:bg-gray-50">
          <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
              <p class="text-sm font-medium text-indigo-600 truncate">
                <router-link :to="'/admin/courses/'+course.id">{{ course.name }}</router-link>
              </p>
              <div class="ml-2 flex-shrink-0 flex">
                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  {{course.active ? 'Активный' : 'Неактивный'}}
                </p>
              </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
              <div class="sm:flex">
                <p class="flex items-center text-sm text-gray-500">
                  <UsersIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                  {{course.usersCount}}
                </p>
                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                  <BookOpenIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                  {{course.modules.length}}
                </p>
              </div>
              <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 ">
                <course-actions :courseId="course.id" :courseIndex="index" @delete="onDelete"></course-actions>
              </div>
            </div>
          </div>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
import {BookOpenIcon, UsersIcon } from '@heroicons/vue/solid'
import CourseActions from './CourseActions.vue'
import Swal from 'sweetalert2'
import Axios from 'axios'

export default {
  components: {
    BookOpenIcon,
    UsersIcon,
    CourseActions,
    Swal
  },
  props:['courses'],
  methods: {
    onDelete(courseId,index)
    {
      let item = this.courses.find(el => el.id == courseId)
      Swal.fire({
        title: 'Удалить курс «'+item.name+'»?',
        showCancelButton: true,
        confirmButtonText: 'Удалить',
        cancelButtonText: 'Отмена',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete('/api/admin/courses/'+courseId)
          .then(response => {
            this.courses.splice(index, 1);
            Swal.fire('Курс удален!', '', 'success')
          })
          .catch(error =>{
            Swal.fire('Что-то пошло не так...', '', 'error')
            console.log(error)
          })
          
        }
      })
    }
  }
}
</script>