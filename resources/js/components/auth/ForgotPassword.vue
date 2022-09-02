<template>
    <section class="md:flex md:justify-center mb-6 mt-6 mx-6 ">
          <div class="block p-6 rounded-lg shadow-lg bg-white w-full md:w-1/2 ">
            <form @submit.prevent="restore_password" class="">
                <div class="grid  gap-4">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Восстановление пароля</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Введите Ваш e-mail</p>
                    </div>

                    <div class="form-group">
                        <input v-model="email" required type="email" placeholder="E-mail" class=" mb-1 form-control block w-full py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300
                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
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
                ease-in-out">Восстановить пароль</button>
            </form>
          </div>
    </section>

</template>

<script>
import Swal from 'sweetalert2'
export default ({
    data () {
      return {
        email: "",
      }
    },
    methods: {
      restore_password() {
          axios.post('/api/password/forgot',{email: this.email})
          .then (res => {
            Swal.fire(res.data.status, '', 'success')
          })
          .catch (err =>{
            Swal.fire('Что-то пошло не так... '+err.response.data.message, '', 'error')
            //console.log(err.toJSON())
          })
        }
    }
    
})
</script>
