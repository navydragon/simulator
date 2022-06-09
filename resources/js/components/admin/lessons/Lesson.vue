<template>
  <div class="py-6">
    <breadcrumbs :pages="pages"></breadcrumbs>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
      <div class="py-4">
          <tabs @switch-tab="onSwitchTab" :tabs="tabs"></tabs>
      </div>
    </div>
    <div>
      <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
    </div>
  </div>
</template>


<script>
import CreateLessonModal from './CreateLessonModal.vue'
import LessonsList from './LessonsList.vue'
import Breadcrumbs from '../../admin/AdminBreadcrumbs.vue'
import Tabs from '../../admin/AdminTabs.vue'
import ClassicEditor from '../../ckeditor/build/';
import CodeBlock from '@ckeditor/ckeditor5-code-block/src/codeblock';
export default {
  components: {LessonsList, CreateLessonModal,Breadcrumbs,Tabs,ClassicEditor },
  data(){
    return {
      lesson: {},
      lesson_id: this.$route.params.id,
      createLessonModal: false,
      pages: [],
      tabs : [
        { name: 'Редактирование текста', href: '#', current: true },
        { name: 'Предпросмотр', href: '#', current: false },
        { name: 'Задачи', href: '#', current: false },
      ],
      currentTab: 'Редактирование текста',
       editor: ClassicEditor,
        editorData: '<p>Content of the editor.</p>',
        editorConfig: {
            plugins: [CodeBlock]
        }
    }
  },
  methods:{
    taskAdded(data)
    {
      this.lesson.tasks.push(data.data)
      this.createLessonModal=false
    },
    onSwitchTab(text){    
      this.currentTab = text
    }
  },
  mounted(){
    axios.get('/api/admin/lessons/'+this.lesson_id)
    .then(response => {
        this.lesson = response.data.data
        this.pages = [
             { name: this.lesson.module.name, href: '/admin/modules/'+this.lesson.module.id, current: false },
             { name: this.lesson.name, href: '#', current: true },
        ]
    })
    .catch(error => console.error(error)) 
  }
}
</script>