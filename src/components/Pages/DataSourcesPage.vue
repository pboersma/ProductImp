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
        <font-awesome-icon icon="fa-solid fa-plus" />
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
            <th scope="col" class="px-6 py-3">Actions</th>
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
            <td class="px-6 py-4 flex">
              <button
                href="#"
                @click="toggleSyncDataSourceModal(dataSource.id)"
                class="
                  font-medium
                  text-blue-600
                  dark:text-blue-500
                  hover:underline
                  mr-2
                "
              >
                <font-awesome-icon icon="fa-solid fa-rotate" />
              </button>
              <button
                href="#"
                disabled
                class="
                  disabled
                  font-medium
                  text-blue-600
                  dark:text-blue-500
                  hover:underline
                  mr-2
                "
              >
                <font-awesome-icon icon="fa-solid fa-pen-to-square" />
              </button>
              <button
                @click="deleteRecord(dataSource.id)"
                class="
                  font-medium
                  text-blue-600
                  dark:text-blue-500
                  hover:underline
                  mr-2
                "
              >
                <font-awesome-icon icon="fa-solid fa-trash" />
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
    @refetch-data-sources="fetchAll()"
  ></AddDataSourceModal>
  <SyncDataSourceModal
    :current-datasource="currentDatasource"
    :visible="isSyncDataSourceModalVisible"
    @close-sync-data-source-modal="toggleSyncDataSourceModal()"
  ></SyncDataSourceModal>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import Swal from 'sweetalert2';
import store from '@/store';
import AddDataSourceModal from '../Modals/AddDataSourceModal.vue';
import SyncDataSourceModal from '../Modals/SyncDataSourceModal.vue';

const loading = ref(true);

// Datasource list fetching logic
const dataSources = computed(() => store.getters['datasources/allDataSources']);

const fetchAll = () => {
  const promises = [store.dispatch('datasources/fetchAll')];

  // TODO: Do something with the response & error.
  Promise.all(promises).then((response) => {
    loading.value = false;
    Promise.resolve();
  });
};

// Datasource actions logic
const currentDatasource = ref();

// Modal visibility logic
const isAddDataSourcesModalVisible = ref(false);
const isSyncDataSourceModalVisible = ref(false);

/**
 * Toggle the visibility of the add data sources modal.
 *
 * @return void
 */
const toggleAddDataSourcesModal = () => {
  isAddDataSourcesModalVisible.value = !isAddDataSourcesModalVisible.value;
};

/**
 * Toggle the syncing data source (or close).
 *
 * @param dataSourceId string | null Can be either null for closing or
 * string for setting the current data source
 *
 * @return void
 */
const toggleSyncDataSourceModal = (dataSourceId: string | null = null) => {
  currentDatasource.value = dataSourceId;
  isSyncDataSourceModalVisible.value = !isSyncDataSourceModalVisible.value;
};

/**
 * Delete a record
 *
 * @param id
 *
 * @return void
 */
const deleteRecord = (id: string): void => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  }).then((result) => {
    if (result.isConfirmed) {
      Promise.all([store.dispatch('datasources/delete', id)])
        .catch((error) => {
          Swal.fire(
            'Error!',
            'Something went wrong deleting the record',
            'error',
          );
        })
        .then((response) => {
          if (response) {
            Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
            fetchAll();
          }
        });
    }
  });
};

onMounted(() => {
  fetchAll();
});
</script>

<style scoped>
.disabled {
  color: rgba(37, 99,235, 0.4)
}
</style>
