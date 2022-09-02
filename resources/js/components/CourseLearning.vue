
<template>
  <div v-if="learning" class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
    <div class="px-4 py-5 sm:px-6">
      <!-- Content goes here -->
      <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:tracking-tight sm:truncate">{{learning.course.name}}</h2>
    </div>
    <div class="px-4 py-5 sm:p-6">
      <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 m-5 ">
      <li v-for="(elem) in learning.course.modules" :key="elem.id" :set="um=learning.user_modules.find(el => el.module_id==elem.id)"  class="col-span-1 bg-white rounded-lg border-x border-t border-gray-300 shadow divide-y divide-gray-200 ">
          <div  class="w-full flex items-center justify-between p-6 space-x-6">
            <div class="flex-1 truncate">
              <div class="flex items-center space-x-3">
                <h3 class="text-gray-900 text-md font-medium">{{ elem.name }} </h3>
              </div>

              <div v-if="um">
                <span class="flex-shrink-0 inline-block px-2 py-0.5 text-black-800 text-xs font-medium bg-blue-100 rounded-full"> 
                    Начат {{um.assigned_at}}
                </span>
                <span v-if="um.is_completed" class="flex-shrink-0 inline-block px-2 py-0.5 text-black-800 ml-2 text-xs font-medium bg-green-100 rounded-full"> 
                    Закончен {{um.completed_at}}
                </span>
                <span v-else class="flex-shrink-0 inline-block px-2 py-0.5 text-black-800 ml-2 text-xs font-medium bg-yellow-100 rounded-full"> 
                    Текущий модуль
                </span>
              </div>
            </div>
            
          </div>
          <div class="">
            <div class="-mt-px flex divide-x divide-gray-200 ">
              <button v-if="um" @click="goModule(elem.id)" class="
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
                    ПРОДОЛЖИТЬ</button>
              
            </div>
          </div>
      </li>
    </ul>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
   data(){
    return {
      learning_id: this.$route.params.id,
      learning : null
    }
  },
  methods:{
    goModule(id){
      let um = this.learning.user_modules.find(el => el.module_id==id)
      this.$router.push('/learnings/'+this.learning_id+'/lessons/'+um.current_lesson_id)
    }
  },
  created(){
   axios.get('/api/learnings/'+this.learning_id)
    .then(response => {
      this.learning = response.data.data
      })
    .catch (err =>{
      Swal.fire('Что-то пошло не так...', '', 'error')
      console.log(err)
    })
  }
}

</script>
