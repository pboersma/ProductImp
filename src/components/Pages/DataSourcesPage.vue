<template>
  <div class="container mx-auto px-5 pt-10">
    <div class="mb-5 flex justify-between">
      <h2 class="text-2xl font-light">Data Sources</h2>
      <button
        data-modal-toggle="defaultModal"
        @click="toggleAddDataSourcesModal()"
        class="
          px-4
          py-2
          outline-none
          border-2 border-blue-400
          rounded
          text-blue-500
          font-medium
          active:scale-95
          hover:bg-blue-600 hover:text-white hover:border-transparent
          focus:bg-blue-600
          focus:text-white
          focus:border-transparent
          focus:ring-2
          focus:ring-blue-600
          focus:ring-offset-2
          disabled:bg-gray-400/80
          disabled:shadow-none
          disabled:cursor-not-allowed
          transition-colors
          duration-200
        "
      >
        Add
      </button>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="
            text-xs text-gray-700
            uppercase
            bg-gray-50
            dark:bg-gray-700 dark:text-gray-400
          "
        >
          <tr>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">URL</th>
            <th scope="col" class="px-6 py-3">Private</th>
            <th scope="col" class="px-6 py-3">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody v-if="!loading">
          <tr
            v-for="dataSource in dataSources"
            v-bind:key="dataSource.datasource_name"
            class="
              bg-white
              border-b
              dark:bg-gray-800 dark:border-gray-700
              hover:bg-gray-50
              dark:hover:bg-gray-600
            "
          >
            <th
              scope="row"
              class="
                px-6
                py-4
                font-medium
                text-gray-900
                dark:text-white
                whitespace-nowrap
              "
            >
              {{ dataSource.datasource_name }}
            </th>
            <td class="px-6 py-4">{{ dataSource.datasource_url }}</td>
            <td class="px-6 py-4">true</td>
            <td class="px-6 py-4 text-right">
              <button
                href="#"
                class="
                  font-medium
                  text-blue-600
                  dark:text-blue-500
                  hover:underline
                "
              >
                edit
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <AddDataSourceModal
    :visible="isAddDataSourcesModalVisible"
    @close-add-data-source-modal="toggleAddDataSourcesModal()"
  ></AddDataSourceModal>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import store from '@/store';
import AddDataSourceModal from '../Modals/AddDataSourceModal.vue';

const dataSources = computed(() => store.getters['datasources/allDataSources']);
const loading = ref(true);
const isAddDataSourcesModalVisible = ref(false);

const toggleAddDataSourcesModal = () => {
  isAddDataSourcesModalVisible.value = !isAddDataSourcesModalVisible.value;
};

onMounted(() => {
  const promises = [store.dispatch('datasources/fetchAll')];

  Promise.all(promises).then((response) => {
    loading.value = false;
  });
});
</script>
