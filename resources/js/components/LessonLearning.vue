<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-gray-100">
    <body class="h-full">
    ```
  -->
  <div>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="fixed inset-0 flex z-40 md:hidden" @close="sidebarOpen = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>
        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
          <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                  <span class="sr-only">Close sidebar</span>
                  <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                </button>
              </div>
            </TransitionChild>
            <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
              <div class="flex-shrink-0 flex items-center px-4">
                <div class="flex flex-row">
                  <a href="#" @click.prevent="courseActive=true" :class="[courseActive ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'inline-flex items-center px-1 pt-1 border-b-2 font-medium pb-2']" >
                    Курс 
                  </a>
                  <div v-if="!courseActive" class="inline-flex items-center ml-2"> 
                    <ArrowNarrowRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    <a :class="[courseActive== false ? 'border-indigo-500 text-gray-900' : 'text-gray-500', 'inline-flex items-center px-1 pt-1 border-b-2 font-medium pb-2']" >
                      Темы 
                    </a>
                  </div> 
                </div>
              </div>
              <nav class="mt-5 px-2 space-y-1">
                <div v-if="courseActive">
                       <h2 class="text-xl ml-2 font-bold leading-7 text-gray-900 sm:text-xl sm:tracking-tight sm:truncate">{{course.name}}</h2>
                       <p class="text-gray-500 text-base ml-2 mt-2 font-lignt">Темы курса</p>
                      <ul  role="list" class="divide-y divide-gray-200 mt-3">
                        <li v-for="theme,theme_index in course.modules" :key="'t'+theme.id">
                          <a href="#" class="block hover:bg-gray-50">
                            <div :set="um=user_modules.find(el => el.module_id==theme.id)" @click="viewModule(theme.id)" class="px-4 py-4 flex items-center sm:px-6">
                              <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="truncate">
                                  <div class="flex">
                                    <p 
                                    :class="[um ? 'text-black' : 'text-gray-500', 'font-medium truncate']"
                                    
                                     >{{theme_index+1}}. {{ theme.name }}</p>
                                  </div>
                                </div>
                              </div>
                              <div class="ml-5 flex-shrink-0 flex flex-row">
                                <CheckIcon v-if="um&&um.is_completed" class="h-5 w-5 mr-3 text-green-400" aria-hidden="true" />
                                <ChevronRightIcon v-if="um" class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                <LockClosedIcon v-else  class="h-5 w-5 text-gray-400" aria-hidden="true" />
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
                    <div v-else class="h-full">
                       <h2 class="text-xl ml-2 font-bold leading-7 text-gray-900 sm:text-xl sm:tracking-tight sm:truncate">{{current_module.name}}</h2>
                       <p class="text-gray-500 text-base ml-2 mt-2 font-lignt">Уроки</p>
                      <ul  role="list" class="divide-y divide-gray-200 mt-3 overflow-y-scroll" style="height:550px">
                        <li v-for="lesson,lesson_index in current_module.lessons" :key="'l'+lesson.id" >
                          <span :set="ul=current_user_module.user_lessons.find(el => el.lesson_id==lesson.id)"></span>
                          <a href="#" v-if="ul" @click.prevent="goLesson(lesson.id)" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 flex items-center sm:px-6">
                              <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="truncate">
                                  <div class="flex">
                                    <p 
                                    :class="[ul ? 'text-black' : 'text-gray-500', 'font-medium truncate']"
                                    
                                     >{{lesson_index+1}}. {{ lesson.name }}</p>
                                  </div>
                                </div>
                              </div>
                              <div class="ml-5 flex-shrink-0 flex flex-row">
                                <CheckIcon v-if="ul&&ul.is_completed" class="h-5 w-5 mr-3 text-green-400" aria-hidden="true" />
                                <ChevronRightIcon v-if="ul" class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                <LockClosedIcon v-else  class="h-5 w-5 text-gray-400" aria-hidden="true" />
                              </div>
                            </div>
                          </a>
                          <a href="#" v-else @click.prevent="" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 flex items-center sm:px-6">
                              <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="truncate">
                                  <div class="flex">
                                    <p 
                                    :class="[ul ? 'text-black' : 'text-gray-500', 'font-medium truncate']"
                                    
                                     >{{lesson_index+1}}. {{ lesson.name }}</p>
                                  </div>
                                </div>
                              </div>
                              <div class="ml-5 flex-shrink-0 flex flex-row">
                                <CheckIcon v-if="ul&&ul.is_completed" class="h-5 w-5 mr-3 text-green-400" aria-hidden="true" />
                                <ChevronRightIcon v-if="ul" class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                <LockClosedIcon v-else  class="h-5 w-5 text-gray-400" aria-hidden="true" />
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
              </nav>
            </div>
            <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
              <a href="#" class="flex-shrink-0 group block">
                <div class="flex items-center">
                  <div class="ml-3">
                    <router-link :to="'/learning/'+learning_id" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">Назад к курсу</router-link>>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </TransitionChild>
        <div class="flex-shrink-0 w-14">
          <!-- Force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:w-96 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
          <div class="flex items-center flex-shrink-0 px-4">
            <div class="flex flex-row">
              <a href="#" @click.prevent="courseActive=true" :class="[courseActive ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'inline-flex items-center px-1 pt-1 border-b-2 font-medium pb-2']" >
                Курс 
              </a>
              <div v-if="!courseActive" class="inline-flex items-center ml-2"> 
                <ArrowNarrowRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                <a :class="[courseActive== false ? 'border-indigo-500 text-gray-900' : 'text-gray-500', 'inline-flex items-center px-1 pt-1 border-b-2 font-medium pb-2']" >
                  Темы 
                </a>
              </div> 
            </div>
          </div>
          <nav class="mt-5 flex-1 px-2 bg-white space-y-1">
            <div v-if="courseActive">
                <h2 class="text-xl ml-2 font-bold leading-7 text-gray-900 sm:text-xl sm:tracking-tight sm:truncate">{{course.name}}</h2>
                <p class="text-gray-500 text-base ml-2 mt-2 font-lignt">Темы курса</p>
              <ul  role="list" class="divide-y divide-gray-200 mt-3">
                <li v-for="theme,theme_index in course.modules" :key="'t'+theme.id">
                  <a href="#" class="block hover:bg-gray-50">
                    <div :set="um=user_modules.find(el => el.module_id==theme.id)" @click="viewModule(theme.id)" class="px-4 py-4 flex items-center sm:px-6">
                      <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                        <div class="truncate">
                          <div class="flex">
                            <p 
                            :class="[um ? 'text-black' : 'text-gray-500', 'font-medium truncate']"
                            
                              >{{theme_index+1}}. {{ theme.name }}</p>
                          </div>
                        </div>
                      </div>
                      <div class="ml-5 flex-shrink-0 flex flex-row">
                        <CheckIcon v-if="um&&um.is_completed" class="h-5 w-5 mr-3 text-green-400" aria-hidden="true" />
                        <ChevronRightIcon v-if="um" class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        <LockClosedIcon v-else  class="h-5 w-5 text-gray-400" aria-hidden="true" />
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <div v-else class="h-full">
                <h2 class="text-xl ml-2 font-bold leading-7 text-gray-900 sm:text-xl sm:tracking-tight sm:truncate">{{current_module.name}}</h2>
                <p class="text-gray-500 text-base ml-2 mt-2 font-lignt">Уроки</p>
              <ul  role="list" class="divide-y divide-gray-200 mt-3 " style="height:550px">
                <li v-for="lesson,lesson_index in current_module.lessons" :key="'l'+lesson.id" >
                  <span :set="ul=current_user_module.user_lessons.find(el => el.lesson_id==lesson.id)"></span>
                  <a href="#" v-if="ul" @click.prevent="goLesson(lesson.id)" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 flex items-center sm:px-6">
                      <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                        <div class="truncate">
                          <div class="flex">
                            <p 
                            :class="[ul ? 'text-black' : 'text-gray-500', 'font-medium truncate']"
                            
                              >{{lesson_index+1}}. {{ lesson.name }}</p>
                          </div>
                        </div>
                      </div>
                      <div class="ml-5 flex-shrink-0 flex flex-row">
                        <CheckIcon v-if="ul&&ul.is_completed" class="h-5 w-5 mr-3 text-green-400" aria-hidden="true" />
                        <ChevronRightIcon v-if="ul" class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        <LockClosedIcon v-else  class="h-5 w-5 text-gray-400" aria-hidden="true" />
                      </div>
                    </div>
                  </a>
                  <a href="#" v-else @click.prevent="" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 flex items-center sm:px-6">
                      <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                        <div class="truncate">
                          <div class="flex">
                            <p 
                            :class="[ul ? 'text-black' : 'text-gray-500', 'font-medium truncate']"
                            
                              >{{lesson_index+1}}. {{ lesson.name }}</p>
                          </div>
                        </div>
                      </div>
                      <div class="ml-5 flex-shrink-0 flex flex-row">
                        <CheckIcon v-if="ul&&ul.is_completed" class="h-5 w-5 mr-3 text-green-400" aria-hidden="true" />
                        <ChevronRightIcon v-if="ul" class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        <LockClosedIcon v-else  class="h-5 w-5 text-gray-400" aria-hidden="true" />
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
        <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
          <a href="#" class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
              <div class="ml-3">
                <router-link :to="'/learning/'+learning_id" type="button" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">Назад к курсу</router-link>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div class="md:pl-96 flex flex-col flex-1">
      <div class="sticky top-0 z-10 md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-gray-100">
        <button type="button" class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <MenuIcon class="h-6 w-6" aria-hidden="true" />
        </button>
      </div>
      <main class="flex-1">
        <div v-if="lesson" class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Тема: {{lesson.name}}</h1>
          </div>
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <!-- Replace with your content -->
            <div class="py-4">
              <div class="hidden sm:block mb-3">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
              <a href="#" @click="switchTab('theory')" :class="[tab=='theory' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab=='theory' ? 'page' : undefined">Теория</a>
              <a href="#" v-if="lesson.tasks.length > 0" @click="switchTab('tasks')" :class="[tab=='tasks' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab=='tasks' ? 'page' : undefined">Задачи</a>
              <!-- <a v-for="tab in tabs" :key="tab.name" href="#" :class="[tab.current ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200', 'whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm']" :aria-current="tab.current ? 'page' : undefined">
                {{ tab.name }}
                <span v-if="tab.count" :class="[tab.current ? 'bg-indigo-100 text-indigo-600' : 'bg-gray-100 text-gray-900', 'hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block']">{{ tab.count }}</span>
              </a> -->
            </nav>
          </div>
        </div>
         <div v-show="tab=='theory'" >
            <div class="lessontext" v-html="lessonText">
            </div> 
           <button type="button" v-if="lesson.tasks.length > 0" @click="switchTab('tasks')" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-5">Перейти к задачам</button>
           <button type="button" v-else-if="lesson.next_lesson_id != null" @click="completeLesson(current_user_lesson_id)" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-5">Перейти к следующей теме</button>
           <button type="button" v-else @click="completeModule(current_user_lesson_id)" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-5">Завершить модуль</button>
         </div>
         
         <div class="flex" v-if="tab=='tasks'">
            <div class="flex-none w-48 h-full border border-gray-500">
                <nav class="space-y-1" aria-label="Sidebar">
                  <div v-for="item in lesson.tasks" :set="ut=user_tasks.find(el => el.task_id==item.id)" :key="'task'+item.id">
                    <a href="#" @click.prevent="changeTask(item.id)" v-if="ut" :class="[current_task == item ? 'bg-indigo-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                      <span class="truncate">
                        Задача № {{ item.position }}
                      </span>
                      <span v-if="ut && ut.is_completed" class="bg-green-100 text-gray-600 group-hover:bg-green-200 ml-auto inline-block py-0.5 px-3 text-xs rounded-full">
                        <div class="flex-shrink-0">
                          <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                        </div>
                      </span>
                    </a>
                    <a v-else :class="[current_task == item ? 'bg-indigo-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                      <span class="truncate">
                        Задача № {{ item.position }}
                      </span>
                      <span v-if="!ut" class="text-gray-600 ml-auto inline-block py-0.5 px-3 text-xs rounded-full">
                        <div class="flex-shrink-0">
                          <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </div>
                      </span>
                    </a>
                  </div>
                  </nav>
            </div>
            <div class="grow ml-5 px-5 h-full  border">
              <h2>Задача № {{current_task.position }}</h2>
              <div class="my-3" v-html="current_task.description"></div>
              <div class="my-5">
                <label class="block text-sm font-medium text-gray-900">Код</label>
                <div class="h-48">
                    <MonacoEditor class="border w-full overscroll-none"  theme="vs" :options="options" v-model:value="current_user_task.current_code"  :language="type_name" />
                </div>
                <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                  <button @click="tryCode()" type="button" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">Запустить код</button>
                  <button @click="testCode()" v-if="!current_user_task.is_completed" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">Проверить код</button>
                  <button @click="resetCode()" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">Сбросить</button>
                  <button v-if="current_user_task.is_completed&&current_task.next_task_id" @click="changeTask(current_task.next_task_id)" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-green-500 text-sm font-medium text-white hover:bg-green-300 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">Следующая задача</button>
                  <button v-if="current_user_task.is_completed&&!current_task.next_task_id&&lesson.next_lesson_id" @click="completeLesson(current_user_lesson_id)" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-green-500 text-sm font-medium text-white hover:bg-green-300 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">Перейти к следующей теме</button>
                  <button v-if="current_user_task.is_completed&&!current_task.next_task_id&&!lesson.next_lesson_id" @click="completeModule(current_user_lesson_id)" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-green-500 text-sm font-medium text-white hover:bg-green-300 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">Завершить модуль</button>
  
                </span>
              </div>
              </div>
              <div v-if="current_user_task.is_completed==1" class="rounded-md bg-green-50 p-4">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <CheckCircleIcon class="h-5 w-5 text-green-400" aria-hidden="true" />
                  </div>
                  <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">Задание решено верно!</h3>
                  </div>
                </div>
              </div>
              <div v-if="showFeedback==true&&current_user_task.is_completed==0" class="rounded-md bg-red-50 p-4">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true" />
                  </div>
                  <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Задание решено неверно. Проверьте Ваш результат и сравните его с ожидаемым.</h3>
                  </div>
                </div>
              </div>
              <div class="my-5 w-lg">
                <label class="block text-sm font-medium text-gray-700">Результаты</label>
                <div class="mt-3 mb-5">
                  <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                      <a href="#" @click="switchResultTab('user')" :class="[resultTab=='user' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700', 'px-3 py-2 font-medium text-sm rounded-md']">
                        Ваш результат
                      </a>
                      <a href="#" @click="switchResultTab('right')" :class="[resultTab=='right' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500 hover:text-gray-700', 'px-3 py-2 font-medium text-sm rounded-md']">
                        Ожидаемый результат
                      </a>
                    </nav>
                  </div>
                </div>
                <div>
                  <sql-result :sqlResult="current_user_task.current_output" v-if="current_user_task.current_output && resultTab=='user'"></sql-result>
                </div>
                <div>
                  <sql-result :key="'result'" :sqlResult="current_task.right_output" v-if="current_task.right_output && resultTab=='right'"></sql-result>
                </div>
                
              </div>
            </div>
         </div> 
            </div>
            <!-- /End replace -->
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
  import { ref } from 'vue'
  import { Dialog, DialogOverlay, TransitionChild, TransitionRoot } from '@headlessui/vue'
  import {
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    MenuIcon,
    UsersIcon,
    XIcon,
  } from '@heroicons/vue/outline'

  import Swal from 'sweetalert2'
  import Prism from './prism/prism.js';
  import "./prism/prism.css"; 
  import { ChevronRightIcon,ArrowNarrowRightIcon, LockClosedIcon,CheckIcon,XCircleIcon,CheckCircleIcon } from '@heroicons/vue/solid'
  import MonacoEditor from 'monaco-editor-vue3'
  import SqlResult from './SQL/SqlResult.vue'

  const navigation = [
    { name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
    { name: 'Team', href: '#', icon: UsersIcon, current: false },
    { name: 'Projects', href: '#', icon: FolderIcon, current: false },
    { name: 'Calendar', href: '#', icon: CalendarIcon, current: false },
    { name: 'Documents', href: '#', icon: InboxIcon, current: false },
    { name: 'Reports', href: '#', icon: ChartBarIcon, current: false },
  ]

export default {
  components: {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
    MenuIcon,
    XIcon,
    ChevronRightIcon,ArrowNarrowRightIcon,LockClosedIcon,CheckIcon,XCircleIcon,CheckCircleIcon,MonacoEditor,SqlResult
  },
  setup() {
    const sidebarOpen = ref(false)

    return {
      navigation,
      sidebarOpen,
    }
  },
  data() {
    return {
      learning_id: this.$route.params.learning,
      lesson_id: this.$route.params.lesson,
      lesson: null,
      open: false,
      dimmer: true,
      right: false,
      courseActive: false,
      course: {},
      user_modules: [],
      user_tasks: [],
      current_module: {},
      current_user_module: {},
      current_task: {},
      current_user_task:{},
      current_task_id: null,
      current_user_lesson_id: null,
      current_user_module_id: null,
      lessonText: "",
      tab: "theory",
      resultTab: "user",
      showFeedback: false,
      options:{
        minimap: {enabled:false}
      },
    };
  },
  methods: {
    toggle() {
      this.open = !this.open;
    },
    viewModule(module_id) {
      this.current_module = this.course.modules.find(el => el.id == module_id)
      this.current_user_module = this.user_modules.find(el => el.module_id == module_id) || {'user_lessons': []}
      this.$nextTick(() => {this.courseActive = false });
    },
    switchTab(elem)
    {
        this.tab = elem
        this.$nextTick(() => {this.$refs.start.scrollIntoView({ behavior: "smooth" }) });
        
    },
    switchResultTab(elem)
    {
      this.resultTab = elem
    },
    tryCode(){
      this.showFeedback = false
      axios.post('/api/code/try/'+this.type_name,{code: this.current_user_task.current_code,user_task_id:this.current_user_task.id })
      .then(response => {
        this.resultTab = 'user'
        this.current_user_task.current_output = response.data
      })
      .catch(error => {
        console.log(error.response)
        this.resultTab = 'user'
        this.current_user_task.current_output = error.response.data
      })
    },
    testCode(){
      this.showFeedback = false
      let user_task_id = this.current_user_task.id
      axios.post('/api/code/test/'+this.type_name,{code: this.current_user_task.current_code,user_task_id:this.current_user_task.id })
      .then(response => {
        this.resultTab = 'user'
        this.user_tasks = response.data.user_tasks
        this.$nextTick(() => {
          this.current_user_task = this.user_tasks.find(el => el.id == user_task_id)
          this.showFeedback = true
        })
      })
      .catch(error => {
        console.log(error.response)
        this.resultTab = 'user'
        this.current_user_task.current_output = error.response.data
      })
    },
    changeTask (id)
    {
      this.current_user_task = this.user_tasks.find(el => el.task_id == id)
      this.current_task = this.lesson.tasks.find(el => el.id == id)
      if (this.current_user_task.is_completed == 1)
      { this.showFeedback = true }else{this.showFeedback = false}
    },
    resetCode() {
      Swal.fire({
          title: 'Вернуть исходный код??',
          text: "Сделанные вами изменения будут отменены. Задание вернется в исходное состояние.",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Вернуть',
          cancelButtonText: 'Отмена',
        }).then((result) => {
          if (result.isConfirmed) {
             axios.post('/api/code/reset',{user_task_id:this.current_user_task.id })
            .then(response => {
              this.resultTab = 'user'
              this.current_user_task.current_code = response.data
              this.current_user_task.current_output = null
            })
            .catch(error => {
              console.log(error.response)
              this.current_user_task.current_code = error.response.data
            })
          }
        })
    },
    completeLesson(id)
    {
      axios.post('/api/learning/complete_lesson/'+id)
      .then(response => {
        console.log (response.data)
        this.goLesson(response.data)
      })
      .catch(error => {
        Swal.fire('Что-то пошло не так...', '', 'error')
        console.log(error)
      })
    },
    completeModule(id)
    {
      axios.post('/api/learning/complete_module/'+id)
      .then(response => {
        console.log (response.data)
        this.$router.push('/learning/'+this.learning_id)
      })
      .catch(error => {
        Swal.fire('Что-то пошло не так...', '', 'error')
        console.log(error)
      })
    },
    goLesson(lesson_id)
    {
  
      this.$router.push('/learnings/'+this.learning_id+'/lessons/'+lesson_id)
        .then(() => {
          console.log('Updated route', this.$route)
          this.$router.go(this.$route.path)
        })
    },
  },
  computed: {
    type_name() {
      if (this.current_task.task_type.id == 1) {return "sql"}
      if (this.current_task.task_type.id == 2) {return "python"}
      return ""
    }
  },
  mounted() {
        axios.get('/api/learnings/'+this.learning_id+'/lessons/'+this.lesson_id)
    .then(response => {
      this.course = response.data.data.learning.course
      this.user_modules = response.data.data.learning.user_modules
      this.current_user_module = response.data.data.learning.user_modules.find(el => el.id == response.data.data.user_module_id)
      this.lessonText = response.data.data.text
      this.user_tasks = response.data.data.user_tasks
      this.lesson = response.data.data.lesson
      this.current_task_id = response.data.data.current_task_id
      this.current_user_lesson_id = response.data.data.id
      this.current_user_module_id = response.data.data.user_module_id
      this.$nextTick(() => {
        this.current_module = this.course.modules.find(el => el.id == this.current_user_module.module_id)
        if(this.current_task_id != null)
        {
          this.current_task = this.lesson.tasks.find(el => el.id == this.current_task_id)
          this.current_user_task = this.user_tasks.find(el => el.task_id == this.current_task_id)
        }
        window.Prism = window.Prism || {};
        window.Prism.manual = true;
        Prism.highlightAll(); 
      })
      
      })
    .catch (err =>{
      Swal.fire('Что-то пошло не так...', '', 'error')
      console.log(err)
    })
    },
}
</script>
<style>
  code {
    background: #f7f9fc;
    display: inline;
    box-sizing: border-box;
    min-width: 1.86em;
    padding: 0.35em 0.55em;
    text-align: center;
    white-space: pre;
    border-radius: 4px;
    font-family: "Menlo","Ubuntu Mono",consolas,source-code-pro,monospace;
    font-size: 0.9em;
    line-height: 1.86em;
  }
  img {
  max-width: 640px;
  margin: 0px auto;
  }
  .image {
   display: inline;
   margin-top: 20px; 
  }
  
  .table {
  display: inline;
  }
  table {
  margin: 1em auto;
  table-layout: auto;
  border-collapse: collapse;
  min-width: 50%;
  max-width: 75%;
  }
  tr,th,td {
  border: 1px solid;
  padding: 5px;
  text-align: left;
  }
  .lessontext p{
  margin-bottom: 1em;
  text-align: justify;
  line-height: 1.85714285714286;
  }
  
  h2{
  font-weight: 800;
  margin-block: 1em;
  }
  
  .lessontext ul {
  margin: 10px;
  list-style-type: square;
  }
  
  
  .fade-enter-active,
  .fade-leave-active {
  transition: opacity 1s ease-out;
  }
  
  .fade-enter,
  .fade-leave-to {
  opacity: 0;
  }
  
  blockquote {
  background-color: #e0e7ff;
  border-left: 5px solid #312e81;
  padding: 1.2em;
  margin: 1.5em 1em 1.5em 3em;
  font-size: 1.1em;
  line-height: inherit;
  position: relative;
  }
</style>