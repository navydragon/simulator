<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <TransitionRoot as="template" :show="true" >
    <Dialog as="div" static class="fixed z-10 inset-0 overflow-y-auto"  :open="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
          <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-5/6 sm:p-6">
            <div>
              <!-- <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <CheckIcon class="h-6 w-6 text-green-600" aria-hidden="true" />
              </div> -->
              <div class="sm:mt-2">
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                  <span v-if="currentTask==null">Новая задача</span>
                  <span v-else>Редактирование задачи</span>  
                </DialogTitle>
                <hr>
                <div class="mt-2">
                  <label class="block text-sm font-medium text-gray-700">Тип задания</label>
                  <select v-model="task.typeId" id="location" name="location" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option v-for="elem in task_types" :key="elem.id" :value="elem.id">{{elem.name}}</option>
                  </select>
                </div>
                <div class="mt-2">
                  <label class="block text-sm font-medium text-gray-700">Описание</label>
                  <ckeditor :editor="editor" v-model="task.description" :config="editorConfig"></ckeditor>
                </div>
                <div class="mt-2">
                  <label class="block text-sm font-medium text-gray-700">Пре-код</label>
                   <div class="h-48">
                     <MonacoEditor class="h-full border w-full"  theme="vs" :options="options" v-model:value="task.preCode"  :language="type_name" />
                  </div>
                </div>
                <div class="mt-2">
                  <label class="block text-sm font-medium text-gray-700">Пост-код</label>
                   <div class="h-48">
                     <MonacoEditor class="h-full border w-full"  theme="vs" :options="options" v-model:value="task.postCode"  :language="type_name" />
                  </div>
                </div>
                <div class="mt-2">
                  <label class="block text-sm font-medium text-gray-700">Стартовый код</label>
                   <div class="h-48">
                     <MonacoEditor class="h-full border w-full"  theme="vs" :options="options" v-model:value="task.startCode"  :language="type_name" />
                  </div>
                </div>
                <div class="mt-2">
                  <label class="block text-sm font-medium text-gray-700">Правильный код</label>
                   <div class="h-48">
                      <MonacoEditor class="border w-full overscroll-none	"  theme="vs" :options="options" v-model:value="task.rightCode"  :language="type_name" />
                  </div>
                  <button @click="tryRightCode" type="button" class=" inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                    Try
                  </button>
                </div>
                <div class="mt-2">
                  <label class="block text-sm font-medium text-gray-700">Результат</label>
                  <sql-result :sqlResult="task.rightOutput" v-if="task.rightOutput"></sql-result>
                  
                </div>
                <div class="mt-4">
                  <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                      <input v-model="task.active" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />
                    </div>
                    <div class="ml-3 text-sm">
                      <label for="comments" class="font-medium text-gray-700">Активный</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
              <button @click="goTask" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
                {{currentTask == null ? 'Создать' : 'Сохранить'}}
              </button>
              <button @click="$emit('close')" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm" ref="cancelButtonRef">
                Закрыть
              </button>
            </div>
          </div>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>

import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { CheckIcon } from '@heroicons/vue/outline'
import { ExclamationCircleIcon } from '@heroicons/vue/solid'
import SqlResult from '../../SQL/SqlResult.vue'
import MonacoEditor from 'monaco-editor-vue3'
import ClassicEditor from '../../ckeditor/build/ckeditor.js';
import Swal from 'sweetalert2'
export default {
  components: {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
    MonacoEditor,
    SqlResult,
    CheckIcon,ExclamationCircleIcon,
    ClassicEditor
  },
  props:['lessonId','currentTask'],
  data(){
    return {
      task: {
        startCode: "2"
      },
      task_types:[],
      options:{
        minimap: {enabled:false}
      },
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
  computed: {
    type_name() {
      if (this.task.typeId == 1) {return "sql"}
      if (this.task.typeId == 2) {return "python"}
      return ""
    }
  },
  methods:{
    goTask() {
      if (this.currentTask == null) 
      {
        this.addTask()
      }else{
        this.updateTask()
      }
    },
    addTask(){
      axios.post('/api/admin/tasks',{task:this.task,lessonId: this.lessonId})
      .then(response => {
        this.$emit('taskAdded',response.data)
      })
      .catch(error =>{
        Swal.fire('Что-то пошло не так...', '', 'error')
        console.log(error)
      })    
    },
    updateTask(){
      axios.patch('/api/admin/tasks/'+this.task.id,{task:this.task})
      .then(response => {
        this.$emit('taskUpdated',response.data)
      })
      .catch(error =>{
        Swal.fire('Что-то пошло не так...', '', 'error')
        console.log(error)
      })    
    },
    tryRightCode(){
      axios.post('/api/code/'+this.type_name,{
        code: this.task.rightCode,
        preCode: this.task.preCode,
        postCode: this.task.postCode,
        task_type_id: this.task.typeId})
      .then(response => {
        this.task.rightOutput = response.data
      })
      .catch(error => {
        console.log(error.response)
        this.task.rightOutput = error.response.data
      })
    },
    readTask()
    {
      if (this.currentTask == null)
      {
        this.task = {
          description: "description",
          startCode: "# напишите Ваш код здесь",
          rightCode: "SELECT * FROM users",
          rightOutput: null,
          active: true,
          typeId: 1
        }

      }else{
        this.task = this.currentTask
        console.log(this.task.startCode)
      }
    }
  },
  beforeMount()
  {
    this.readTask()
  },
  mounted() {
   
    axios.get('/api/admin/task_types')
    .then (response =>{
      this.task_types = response.data.data
    })
    
  }
}
</script>