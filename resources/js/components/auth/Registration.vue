<template>
    <section class="md:flex md:justify-center mb-6 mt-6 mx-6 ">
          <div class="block p-6 rounded-lg shadow-lg bg-white w-full md:w-1/2 ">
            <form @submit.prevent="register" class="">
                <div class="grid  gap-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Регистрация</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Внимательно заполните все поля!</p>
                    </div>
                    <div class="form-group">
                        <input v-model="new_user.lastname" required type="text" placeholder="Фамилия" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input v-model="new_user.firstname" required type="text" placeholder="Имя" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input v-model="new_user.fathername" required type="text" placeholder="Отчество" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input v-model="new_user.email" required type="email" placeholder="E-mail" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input v-model="new_user.password" required type="password" placeholder="Пароль" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div class="form-group">
                        <input  v-model="new_user.confirm_password"  required type="password" placeholder="Повторите пароль" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                    </div>
                    <div v-if="passwordError" class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
                        Введенные пароли не совпадают
                    </div>
                     <div class="mb-3 xl:w-96 ">
                        <select required v-model="new_user.group_id" class="form-select appearance-none
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
                            <option value="" selected>Выберите группу</option>
                            <option v-for="group in groups" :key="group.id" :value="group.id">{{group.name}}</option>
                        </select>
                    </div>
                </div>

                <button type="submit"  class="
                w-full
                mt-4
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
                ease-in-out">Зарегистрироваться</button>
            </form>
          </div>
    </section>

</template>

<script>
import Swal from 'sweetalert2'
export default ({
    data () {
      return {
        groups: [],
        new_user: {
            lastname: "",
            firstname: "",
            fathername: "",
            email: "",
            password: "",
            confirm_password: "",
            group_id: "",
        },
        passwordError: false
      }
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
      register() {
        this.passwordError = false
        if (this.new_user.password !== this.new_user.confirm_password )
        {
          this.passwordError = true
        }else {
          axios.post('/api/register',{user: this.new_user})
          .then (res => {
            localStorage.access_token = res.data.access_token;
            localStorage.token_type = res.data.token_type;
            this.$router.go('/home')
          })
          .catch (err =>{
            Swal.fire('Что-то пошло не так...', '', 'error')
            console.log(error)
          })
        }
      }
    }
    
})
</script>
