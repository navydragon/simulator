<template>
  <div class="bg-white shadow  sm:rounded-md">
    <ul class="divide-y divide-gray-200">
      <li v-for="(task,index) in tasks" :key="task.id">
        <a href="#" class="block hover:bg-gray-50">
          <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
              <p class="text-sm font-medium text-gray-600 truncate">
                {{ task.description }}
              </p>
              <div class="ml-2 flex-shrink-0 flex">
                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  {{task.active ? 'Активный' : 'Неактивный'}}
                </p>
              </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
              <div class="sm:flex">
                <p class="flex items-center text-sm text-gray-500">
                  <SwitchVerticalIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                  {{index+1}}
                </p>
                <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                  <BookOpenIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                  {{task.type.name}}
                </p>
              </div>
              <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 ">
                <task-actions :task="task" :index="index" @editTask="$emit('editTask',task,index)" @delete="onDelete"></task-actions>
              </div>
            </div>
          </div>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
import {BookOpenIcon, SwitchVerticalIcon } from '@heroicons/vue/solid'
import TaskActions from './TaskActions.vue'
import Swal from 'sweetalert2';
export default {
      components: {
        SwitchVerticalIcon,
        BookOpenIcon,
        TaskActions
    },
    props: ['tasks'],
    mounted() {
      
    },
    methods: {
      onDelete(taskId,index)
      {
        Swal.fire({
          title: 'Удалить задание «'+parseInt(index+1)+'»?',
          showCancelButton: true,
          confirmButtonText: 'Удалить',
          cancelButtonText: 'Отмена',
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete('/api/admin/tasks/'+taskId)
            .then(response => {
              this.tasks.splice(index, 1);
              Swal.fire('Задание удалено!', '', 'success')
            })
            .catch(error =>{
              Swal.fire('Что-то пошло не так...', '', 'error')
              console.log(error)
            })
            
          }
        })
      }
    }
}
</script>
