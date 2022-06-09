<template>
  <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
      <h1 class="text-2xl font-semibold text-gray-900">Курсы</h1>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
      <div class="py-4">
        <button type="button" @click="createCourseModal=!createCourseModal" class="inline-flex items-center px-3 py-2 mb-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <i class="fas fa-plus mr-1"></i> Создать
        </button>
        <courses-list :courses="courses"></courses-list>
      </div>
    </div>
    <create-course-modal @close="createCourseModal=false" @courseAdded="courseAdded" v-if="createCourseModal"></create-course-modal>
  </div>
</template>


<script>
import CreateCourseModal from './CreateCourseModal.vue'
import CoursesList from './CoursesList.vue'


export default {
  components: {CreateCourseModal,CoursesList },
  data(){
    return {
      courses: [],
      createCourseModal: false
    }
  },
  methods:{
    courseAdded(data)
    {
      this.courses.push(data.data)
      this.createCourseModal=false
    }
  },
  mounted(){
    axios.get('/api/admin/courses')
    .then(response => {this.courses = response.data.data})
    .catch(error => console.error(error)) 
  }
}
</script>