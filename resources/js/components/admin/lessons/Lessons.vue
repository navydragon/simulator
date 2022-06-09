<template>
  <div v-if="module.course" class="py-6">

    <breadcrumbs :pages="pages"></breadcrumbs>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
      <div class="py-4">
        <button type="button" @click="createLessonModal=!createLessonModal" class="inline-flex items-center px-3 py-2 mb-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <i class="fas fa-plus mr-1"></i> Создать тему
        </button>
        <lessons-list :lessons="module.lessons"></lessons-list>
      </div>
    </div>
    <create-lesson-modal :moduleId="module.id" @close="createLessonModal=false" @lessonAdded="lessonAdded" v-if="createLessonModal"></create-lesson-modal>
  </div>
</template>


<script>
import CreateLessonModal from './CreateLessonModal.vue'
import LessonsList from './LessonsList.vue'
import Breadcrumbs from '../../admin/AdminBreadcrumbs.vue'

export default {
  components: {LessonsList, CreateLessonModal,Breadcrumbs },
  data(){
    return {
      module: {},
      module_id: this.$route.params.id,
      createLessonModal: false,
      pages: []
    }
  },
  methods:{
    lessonAdded(data)
    {
      this.module.lessons.push(data.data)
      this.createLessonModal=false
    }
  },
  mounted(){
    axios.get('/api/admin/modules/'+this.module_id)
    .then(response => {
        this.module = response.data.data
        this.pages = [
            { name: this.module.course.name, href: '/admin/courses/'+this.module.course.id, current: false },
            { name: this.module.name, href: '#', current: true },
        ]
    })
    .catch(error => console.error(error)) 
  }
}
</script>