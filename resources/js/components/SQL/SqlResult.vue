<template>
    <div v-if="sqlResult" class="flex flex-col h-48 w-full max-w-4xl overflow-auto">
        <div v-if="sqlResult.status=='success'" class="-my-2  ">
            <div class="p-2">
                <p>Столбцов: {{sqlResult.keys.length}}, Строк: {{sqlResult.results.length}}</p>
            </div>
            <div class="py-2 align-middle inline-block min-w-full ">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg table-auto    w-full">
               <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th v-for="key in sqlResult.keys" :key="key"  scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{key}}</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(row,index) in sqlResult.results" :key="'r'+index">
                <td v-for="key in sqlResult.keys" :key="index+key" class="px-1 py-1 whitespace-nowrap text-sm text-gray-500">{{row[key]}}</td>
                </tr>
            </tbody>
          </table>
            </div>
            </div>
        </div>
        <div v-if="sqlResult.status=='error'" class="text-red-600 border p-3">
           Ошибка: {{sqlResult.error}}
        </div>
    </div>
</template>

<script>
export default {
    props:['sqlResult']
}
</script>