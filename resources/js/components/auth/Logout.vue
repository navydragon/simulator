<template>
    
</template>

<script>
import Swal from 'sweetalert2'
export default {
    inject: ['user'],
    created() {
        if (this.user !== "") {
           axios.post('/api/logout')
          .then(response => {
            localStorage.access_token = ""
            localStorage.token_type = ""
          })
          .catch(error =>{
            Swal.fire('Что-то пошло не так...', '', 'error')
            console.log(error)
          })
          .finally((response) => {
             this.$router.go('/')
          })
        }else{
            this.$router.go('/')
        }
    },
}
</script>