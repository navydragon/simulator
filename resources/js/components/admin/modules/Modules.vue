<template>
  <div class="py-6">
    <breadcrumbs :pages="pages"></breadcrumbs>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
      <div class="py-4">
        <button type="button" @click="createModuleModal=!createModuleModal" class="inline-flex items-center px-3 py-2 mb-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <i class="fas fa-plus mr-1"></i> Создать модуль
        </button>
        <modules-list :modules="course.modules"></modules-list>
      </div>
    </div>
    <create-module-modal :courseId="course.id" @close="createModuleModal=false" @moduleAdded="moduleAdded" v-if="createModuleModal"></create-module-modal>
  </div>
</template> 


<script>
import CreateModuleModal from './CreateModuleModal.vue'
import ModulesList from './ModulesList.vue'
import Breadcrumbs from '../../admin/AdminBreadcrumbs.vue'

export default {
  components: {ModulesList, CreateModuleModal,Breadcrumbs },
  data(){
    return {
      course: {},
      course_id: this.$route.params.id,
      createModuleModal: false,
      pages: []
    }
  },
  methods:{
    moduleAdded(data)
    {
      this.course.modules.push(data.data)
      this.createModuleModal=false
    }
  },
  mounted(){
    axios.get('/api/admin/courses/'+this.course_id)
    .then(response => {
      this.course = response.data.data
      this.pages = [
        {name: this.course.name, href: '#', current: true}
      ]
      })
    .catch(error => console.error(error)) 
  }
}
</script>