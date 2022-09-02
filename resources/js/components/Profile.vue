<template>
  <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
    <div class="px-4 py-5 sm:px-6">
      <div class="lg:flex lg:items-center lg:justify-between bg-white rounded-md p-5">
      <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:tracking-tight sm:truncate">Профиль</h2>
        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
          <div class="mt-2 flex items-center text-sm text-gray-500">
            <InformationCircleIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
            Изменение данных, группы и пароля
          </div>
        </div> 
      </div>
      </div>
    </div>
    <div class="px-4 py-5 sm:p-6">
      <div class="block p-6 rounded-lg shadow-lg bg-white w-full ">
          <div class="sm:hidden mb-5">
            <label class="text-sm">Выберите вкладку</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select v-model="tab" id="tabs" name="tabs" class="block w-full pl-3 pr-10 py-2 text-base  border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
              <option value="data" >Данные</option> 
              <option value="password" >Пароль</option> 
            </select>
          </div>
        <div class="hidden sm:block mb-5">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 " aria-label="Tabs">
              <a href="#" @click.prevent="switchTab('data')" :class="[tab=='data' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab=='data' ? 'page' : undefined">Данные</a>
              <a href="#"  @click.prevent="switchTab('password')" :class="[tab=='password' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab=='password' ? 'page' : undefined">Пароль</a>
            </nav>
          </div>
        </div>
        <div v-if="tab=='data'">
          <form @submit.prevent="updateProfile" class="">
                <div class="grid  gap-4">
                    <div class="form-group">
                        <input v-model="user.lastname" required type="text" placeholder="Фамилия" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input v-model="user.firstname" required type="text" placeholder="Имя" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input v-model="user.fathername" required type="text" placeholder="Отчество" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input v-model="user.email" required type="email" placeholder="E-mail" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    
                     <div class="mb-3 xl:w-96 ">
                        <select required v-model="user.group_id" class="form-select appearance-none
                        block
                        w-full
                        px-3
                        py-1.5
                        text-base
                        font-normal
                        text-gray-700
                        bg-white bg-clip-padding bg-no-repeat
                        border border-solid border-gray-300
                        rounded
                        transition
                        ease-in-out
                        m-0
                        form-group
                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example">
                            <option value="null" selected>Выберите группу</option>
                            <option v-for="group in groups" :key="group.id" :value="group.id">{{group.name}}</option>
                        </select>
                    </div>
                </div>
                <button type="submit"  class=" w-full mt-4  px-6
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
                ease-in-out">Сохранить данные</button>
            </form>
        </div>
            
      </div>
    </div>
  </div>
</template>



<script>
import Swal from 'sweetalert2'
import { InformationCircleIcon } from '@heroicons/vue/solid'
export default ({
    components: {InformationCircleIcon},
    data () {
      return {
        groups: [],
        user: {},
        tab: 'data',
        passwordError: false
      }
    },
    mounted() {
      axios.get('/api/user_profile')
      .then (response => {
         this.user = response.data.data
      })
      .catch (err =>{
        Swal.fire('Что-то пошло не так...', '', 'error')
        console.log(err)
      })
    },
    created() {
      axios.get('/api/registration_groups')
        .then (res => {
          this.groups = res.data
          console.log(res.data)
        })
        .catch (err =>{
          console.log(err)
        })
    },
    methods: {
      updateProfile()
      {
        axios.post('/api/update_profile',{user:this.user})
          .then (response => {
          Swal.fire('Сохранено', '', 'success')
          })
          .catch(error =>{
            Swal.fire('Что-то пошло не так...',)
            console.log(error)
          })
      },
      switchTab(elem)
      {
          this.tab = elem          
      },
    }
    
})
</script>
