<template>
  <div class="py-6">
    <breadcrumbs :pages="pages"></breadcrumbs>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
      <div class="py-4">
        <tabs @switch-tab="onSwitchTab" :tabs="tabs"></tabs>
        <div v-show="currentTab === 'Редактирование текста'">
          <ckeditor :editor="editor" v-model="lesson.text" :config="editorConfig"></ckeditor>
          <button type="button" @click="saveText" class="inline-flex my-2 items-center px-3 py-2 mb-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-save mr-1"></i> Сохранить
          </button>
        </div>
        <div v-show="currentTab === 'Предпросмотр'" class="bg-white p-5 lessontext">
          <div v-html="lesson.text">

          </div> 
        </div>
        <div v-show="currentTab === 'Задачи'" >
            <h4 class="my-2">Задачи в теме </h4>
            <button type="button" @click="createTask" class="inline-flex items-center px-3 py-2 mb-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <i class="fas fa-plus mr-1"></i> Создать задачу
            </button>
            <task-modal :currentTask="currentTask" :lessonId="lesson.id" @close="taskModal=false"  @taskAdded="taskAdded" @taskUpdated="taskUpdated" v-if="taskModal"></task-modal>
            <tasks-list :tasks="lesson.tasks" @editTask="editTask"></tasks-list>
        </div> 
      </div>
    </div>
    
  </div>
</template>


<script>
import TaskModal from '../tasks/TaskModal.vue'
import TasksList from '../tasks/TasksList.vue'
import Breadcrumbs from '../../admin/AdminBreadcrumbs.vue'
import Tabs from '../../admin/AdminTabs.vue'
import ClassicEditor from '../../ckeditor/build/ckeditor.js';
import Prism from '../../prism/prism.js';
import "../../prism/prism.css"; 
import Swal from 'sweetalert2'
//import CodeBlock from '@ckeditor/ckeditor5-code-block/src/codeblock';
export default {
  components: {TasksList, TaskModal,Breadcrumbs,Tabs,ClassicEditor,Prism },
  data(){
    return {
      lesson: {tasks:[]},
      lesson_id: this.$route.params.id,
      taskModal: false,
      currentTask: {}, 
      currentTaskIndex: "",
      pages: [],
      tabs : [
        { name: 'Редактирование текста', href: '#', current: true },
        { name: 'Предпросмотр', href: '#', current: false },
        { name: 'Задачи', href: '#', current: false },
      ],
      currentTab: 'Редактирование текста',
      editor: ClassicEditor,
      editorConfig: {
        codeBlock: {
            languages: [
                { language: 'sql', label: 'SQL' },
                { language: 'python', label: 'python' }
            ]}
      }
    }
  },
  methods:{
    createTask() {
      this.currentTask = null
      this.$nextTick(() => {this.taskModal = true });
      
    },
    editTask(task,index) {
      this.currentTaskIndex = index
      this.currentTask = task
      this.$nextTick(() => {this.taskModal = true });
    },
    taskAdded(data)
    {
      this.lesson.tasks.push(data.data)
      Swal.fire('Задание добавлено', '', 'success')
      this.taskModal=false
    },
    taskUpdated(data)
    {
      Swal.fire('Задание обновлено', '', 'success')
      this.lesson.tasks.splice(this.currentTaskIndex, 1, data.data)
      this.taskModal=false
    },
    onSwitchTab(text){    
      this.currentTab = text
      Prism.highlightAll();
    },
    saveText() {
      axios.patch('/api/admin/lessons/'+this.lesson_id,{lesson: this.lesson})
      .then (response => {
        console.log(response)
        Swal.fire('Сохранено', '', 'success')
      })
      .catch(error =>{
        Swal.fire('Что-то пошло не так...', '', 'error')
        console.log(error)
      })
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
    window.Prism = window.Prism || {};
    window.Prism.manual = true;
    Prism.highlightAll(); 
  }
}
</script>