<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
    <div class="px-4 py-5 sm:px-6">
      <div class="lg:flex lg:items-center lg:justify-between bg-white rounded-md p-5">
      <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:tracking-tight sm:truncate">Курсы в тренажере</h2>
        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
          <div class="mt-2 flex items-center text-sm text-gray-500">
            <AcademicCapIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
            Выберите нужный курс и запишитесь на него
          </div>
        </div> 
      </div>
      </div>
    </div>
    <div class="px-4 py-5 sm:p-6">
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 m-5">
      <li v-for="course in courses" :key="course.id" class="col-span-1 bg-white rounded-lg border-x border-t border-gray-300 shadow divide-y divide-gray-200">
        <div class="w-full flex items-center justify-between p-6 space-x-6">
          <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
              <h3 class="text-gray-900 text-md font-medium truncate">{{ course.name }}</h3>
              <!-- <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full"> ...</span> -->
            </div>
            <p class="mt-1 text-gray-500 text-sm truncate"> &nbsp;</p>
          </div>
          <AcademicCapIcon class="flex-shrink-0 mr-1.5 h-10 w-10 text-black-400" aria-hidden="true" />
        </div>
        <div>
          <div class="-mt-px flex divide-x divide-gray-200">
            <button @click="assign(course.id)" class="
                  w-full
                  px-6
                  py-2.5
                  bg-blue-600
                  text-white
                  font-medium
                  text-xs
                  leading-tight
                  uppercase
                  rounded
                  shadow-md
                  hover:bg-blue-700 hover:shadow-lg
                  focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                  active:bg-blue-800 active:shadow-lg
                  transition
                  duration-150
                  ease-in-out">
                  {{course.learning.length > 0 ? 'Продолжить': 'Записаться'}}</button>
            
          </div>
        </div>
      </li>
    </ul>
    </div>
  </div>
</template>

<script>
import { AcademicCapIcon } from '@heroicons/vue/solid'
import Swal from 'sweetalert2'

export default {
  components: {
    AcademicCapIcon
  },
  data(){
    return {
      courses: []
    }
  },
  mounted(){
    axios.get('/api/courses')
    .then(response => {
      this.courses = response.data.data
      })
    .catch (err =>{
      Swal.fire('Что-то пошло не так...', '', 'error')
      console.log(err)
    })
  },
  methods:{
    assign(id){
      let elem = this.courses.find((course) => course.id == id)
      if (elem.learning.length == 0)
      {
        Swal.fire({
          title: 'Записаться на курс "'+elem.name+'"?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Записаться',
          cancelButtonText: 'Отмена',
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post('/api/learnings',{"course_id": elem.id})
            .then(response => {
                elem.learning.push(response.data)
                this.$router.push('/learning/'+response.data.data.id)
              })
            .catch (err =>{
              Swal.fire('Что-то пошло не так...', '', 'error')
              console.log(err)
            })
          }
        })
      }
      this.$router.push('/learning/'+elem.learning[0].id)
    }
  }
 
}
</script>