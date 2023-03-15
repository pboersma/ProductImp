<!-- eslint-disable camelcase -->
<!-- eslint-disable camelcase -->
<!-- eslint-disable vuejs-accessibility/label-has-for -->
<template>
  <div
    id="sync-data-modal"
    tabindex="-1"
    aria-hidden="true"
    :class="{ hidden: !visible }"
    class="
      bgblackopacitied
      absolute
      top-0
      right-0
      left-0
      z-50
      w-full
      md:inset-0
      h-screen
      md:h-screen
      pt-20
    "
  >
    <div class="mx-auto p-4 w-full max-w-2xl h-full md:h-auto">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div
          class="
            flex
            justify-between
            items-start
            p-4
            rounded-t
            border-b
            dark:border-gray-600
          "
        >
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Sync Data Source
          </h3>
          <button
            type="button"
            @click="$emit('closeSyncDataSourceModal')"
            class="
              text-gray-400
              bg-transparent
              hover:bg-gray-200 hover:text-gray-900
              rounded-lg
              text-sm
              p-1.5
              ml-auto
              inline-flex
              items-center
              dark:hover:bg-gray-600 dark:hover:text-white
            "
            data-modal-toggle="syncDataSourceModal"
          >
            x
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- TODO: Use monospace font -->
        <div class="p-1 space-y-6">
          <div
            class="rounded-lg w-100 text-white bg-black p-3"
            style="
            height: 25em;
            "
            >
            <ul class="text-sm">
            </ul>
          </div>
        </div>
        <div
          class="
            flex
            items-center
            p-6
            space-x-2
            rounded-b
            border-t border-gray-200
            dark:border-gray-600
          "
        >
          <button
            data-modal-toggle="defaultModal"
            type="button"
            @click="syncDataSource()"
            class="
              text-white
              bg-blue-700
              hover:bg-blue-800
              focus:ring-4 focus:outline-none focus:ring-blue-300
              font-medium
              rounded-lg
              text-sm
              px-5
              py-2.5
              text-center
              dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800
            "
          >
            Sync
          </button>
          <button
            data-modal-toggle="defaultModal"
            @click="$emit('closeSyncDataSourceModal')"
            type="button"
            class="
              text-gray-500
              bg-white
              hover:bg-gray-100
              focus:ring-4 focus:outline-none focus:ring-blue-300
              rounded-lg
              border border-gray-200
              text-sm
              font-medium
              px-5
              py-2.5
              hover:text-gray-900
              focus:z-10
              dark:bg-gray-700
              dark:text-gray-300
              dark:border-gray-500
              dark:hover:text-white
              dark:hover:bg-gray-600
              dark:focus:ring-gray-600
            "
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {
  ref, defineProps, defineEmits, onMounted,
} from 'vue';
import store from '@/store';
import { DataSource, sync } from '../../services/DataSourceService';

const emit = defineEmits(['closeSyncDataSourceModal', 'refetchDataSources']);

const props = defineProps({
  visible: Boolean,
  currentDatasource: String,
});

const modalActive = ref(false);

const isSyncing = ref(false);

const syncDataSource = () => {
  sync(props.currentDatasource ?? '');
  isSyncing.value = true;
};

</script>

<style lang="less">
.bgblackopacitied {
  background-color: rgba(0, 0, 0, 0.4);
}
</style>
