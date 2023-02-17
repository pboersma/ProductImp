<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<template>
  <tr
    class="
      mapping-row
      bg-white
      border-b
      dark:bg-gray-800 dark:border-gray-700
      hover:bg-gray-50
      dark:hover:bg-gray-600
    "
  >
    <td
      class="
        px-6
        py-4
        font-medium
        text-gray-900
        dark:text-white
        whitespace-nowrap
      "
    >
      <input
        :disabled="!editMode"
        :class="{ 'cursor-no-drop': !editMode }"
        type="text"
        v-model="pairing.product_field_id"
        id="product_field_id"
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
        placeholder="Product Field"
        required
      />
    </td>
    <td
      class="
        px-6
        py-4
        font-medium
        text-gray-900
        dark:text-white
        whitespace-nowrap
      "
    >
      <font-awesome-icon icon="fa-solid fa-arrow-right-long" />
    </td>
    <td
      class="
        px-6
        py-4
        font-medium
        text-gray-900
        dark:text-white
        whitespace-nowrap
      "
    >
      <input
        :disabled="!editMode"
        :class="{ 'cursor-no-drop': !editMode }"
        type="text"
        id="woocommerce_field_id"
        v-model="pairing.woocommerce_field_id"
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
        placeholder="Woocommerce Field"
        required
      />
    </td>
    <td
      class="
        px-6
        py-4
        font-medium
        text-gray-900
        dark:text-white
        whitespace-nowrap
      "
    >
      <div class="-mx-2">
        <button v-if="editMode" @click="save()" class="mx-2">
          <font-awesome-icon icon="fa-solid fa-floppy-disk" />
        </button>
        <button v-if="!editMode" @click="edit()" class="mx-2">
          <font-awesome-icon icon="fa-solid fa-pen-to-square" />
        </button>
        <button @click="remove()" class="mx-2">
          <font-awesome-icon icon="fa-solid fa-times" />
        </button>
      </div>
    </td>
  </tr>
</template>
<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';

const emit = defineEmits(['mappingRowSaved', 'mappingRowRemoved']);
const editMode = ref(false);

const props = defineProps({
  mappingData: Object,
});

const pairing: any = ref({ ...props.mappingData });

const remove = () => {
  emit('mappingRowRemoved', pairing);
};

const edit = () => {
  editMode.value = true;
};

const save = () => {
  emit('mappingRowSaved', pairing);
  editMode.value = false;
};
</script>
