<!-- eslint-disable camelcase -->
<!-- eslint-disable camelcase -->
<!-- eslint-disable vuejs-accessibility/label-has-for -->
<template>
  <div
    id="defaultModal"
    tabindex="-1"
    aria-hidden="true"
    :class="{'hidden': !visible }"
    class="
    bgblackopacitied
      fixed
      z-50
      top-0
      pt-20
      w-full
      h-full
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
            Add Data Source
          </h3>
          <button
            type="button"
            @click="$emit('closeAddDataSourceModal')"
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
            data-modal-toggle="defaultModal"
          >
            x
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-6 space-y-6">
          <form>
            <div class="mb-6">
              <label
                for="datasource_name"
                class="
                  block
                  mb-2
                  text-sm
                  font-medium
                  text-gray-900
                  dark:text-gray-300
                "
                >Name
                </label
              >
              <input
                type="text"
                id="datasource_name"
                v-model="data.datasource_name"
                class="
                  bg-gray-50
                  border border-gray-300
                  text-gray-900 text-sm
                  rounded-lg
                  focus:ring-blue-500 focus:border-blue-500
                  block
                  w-full
                  p-2.5
                  dark:bg-gray-700
                  dark:border-gray-600
                  dark:placeholder-gray-400
                  dark:text-white
                  dark:focus:ring-blue-500
                  dark:focus:border-blue-500
                "
                placeholder="De Eekhoorn"
                required
              />
            </div>
            <div class="mb-6">
              <label
                for="datasource_url"
                class="
                  block
                  mb-2
                  text-sm
                  font-medium
                  text-gray-900
                  dark:text-gray-300
                "
                >URL</label
              >
              <input
                type="text"
                id="datasource_url"
                class="
                  bg-gray-50
                  border border-gray-300
                  text-gray-900 text-sm
                  rounded-lg
                  focus:ring-blue-500 focus:border-blue-500
                  block
                  w-full
                  p-2.5
                  dark:bg-gray-700
                  dark:border-gray-600
                  dark:placeholder-gray-400
                  dark:text-white
                  dark:focus:ring-blue-500
                  dark:focus:border-blue-500
                "
                placeholder="https://www.google.nl/"
                  v-model="data.datasource_url"
                required
              />
            </div>
            <div class="flex justify-between">
              <div class="mb-6">
                <label
                  for="datasource_username"
                  class="
                    block
                    mb-2
                    text-sm
                    font-medium
                    text-gray-900
                    dark:text-gray-300
                  "
                  >Username</label
                >
                <input
                  type="text"
                  id="datasource_username"
                  class="
                    bg-gray-50
                    border border-gray-300
                    text-gray-900 text-sm
                    rounded-lg
                    focus:ring-blue-500 focus:border-blue-500
                    block
                    w-max
                    p-2.5
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:placeholder-gray-400
                    dark:text-white
                    dark:focus:ring-blue-500
                    dark:focus:border-blue-500
                  "
                  v-model="data.datasource_credentials.username"
                  placeholder="johndoe@gmail.com"
                  required
                />
              </div>
              <div class="mb-6">
                <label
                  for="datasource_password"
                  class="
                    block
                    mb-2
                    text-sm
                    font-medium
                    text-gray-900
                    dark:text-gray-300
                  "
                  >Password</label
                >
                <input
                  type="password"
                  id="datasource_password"
                  v-model="data.datasource_credentials.password"
                  class="
                    bg-gray-50
                    border border-gray-300
                    text-gray-900 text-sm
                    rounded-lg
                    focus:ring-blue-500 focus:border-blue-500
                    block
                    w-max
                    p-2.5
                    dark:bg-gray-700
                    dark:border-gray-600
                    dark:placeholder-gray-400
                    dark:text-white
                    dark:focus:ring-blue-500
                    dark:focus:border-blue-500
                  "
                  required
                />
              </div>
            </div>
          </form>
        </div>
        <!-- Modal footer -->
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
            @click="createDataSource()"
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
            Save
          </button>
          <button
            data-modal-toggle="defaultModal"
            @click="$emit('closeAddDataSourceModal')"
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
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';
import store from '@/store';
import { DataSource } from '../../services/DataSourceService';

const emit = defineEmits(['closeAddDataSourceModal', 'refetchDataSources']);

const props = defineProps({
  visible: Boolean,
});

const modalActive = ref(false);
const data = ref<DataSource>({
  datasource_name: null,
  datasource_url: null,
  datasource_credentials: {
    username: null,
    password: null,
  },
});

const createDataSource = () => {
  store.dispatch('datasources/create', data.value);
  // TODO: Can be cleaner.
  data.value = {
    datasource_name: null,
    datasource_url: null,
    datasource_credentials: {
      username: null,
      password: null,
    },
  };
  emit('refetchDataSources');
  emit('closeAddDataSourceModal');
};
</script>

<style lang="less">
.bgblackopacitied {
  background-color: rgba(0, 0, 0, 0.4);
}
</style>
