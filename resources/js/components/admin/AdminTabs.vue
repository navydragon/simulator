<template>
  <div class="sm:hidden">
    <label for="tabs" class="sr-only">Select a tab</label>
    <select id="tabs" name="tabs" @change="switchTab($event)" v-model="currentTab" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
      <option v-for="tab in tabs" :key="tab.name" :value="tab.name" :selected="tab.name == currentTab">{{ tab.name }}</option>
    </select>
  </div>
  <div class="hidden sm:block">
    <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">
      <a v-for="(tab, tabIdx) in tabs" :key="tab.name" @click.prevent="switchTab($event,tab.name)" :class="[tab.current ? 'text-gray-900' : 'text-gray-500 hover:text-gray-700', tabIdx === 0 ? 'rounded-l-lg' : '', tabIdx === tabs.length - 1 ? 'rounded-r-lg' : '', 'group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10']" :aria-current="tab.current ? 'page' : undefined">
          <span>{{ tab.name }}</span>
          <span aria-hidden="true" :class="[tab.name == currentTab ? 'bg-indigo-500' : 'bg-transparent', 'absolute inset-x-0 bottom-0 h-0.5']" />
      </a>
    </nav>
  </div>
</template>

<script>
  export default {
    props:['tabs'],
    emits:['switchTab'],
    data(){
      return {
        currentTab: this.tabs[0].name
      }
    },
    methods:{
      switchTab(event,name)
      {
        if (name) {
          this.currentTab = name
        }else{
          this.currentTab = event.target.value
        }
        this.$emit('switchTab', this.currentTab)
      }
    }
  }
</script>