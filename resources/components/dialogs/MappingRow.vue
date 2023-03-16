<script setup lang="ts">
import { reactive, ref } from 'vue'

const wooCommerceFields = reactive([
  {
    key: 'id',
    value: 'Id'
  },
  {
    key: 'name',
    value: 'Name'
  },
  {
    key: 'slug',
    value: 'Slug'
  },
  {
    key: 'status',
    value: 'Status'
  },
  {
    key: 'description',
    value: 'Description'
  },
  {
    key: 'short_description',
    value: 'Short Description'
  },
  {
    key: 'sku',
    value: 'Sku'
  },
  {
    key: 'price',
    value: 'Price'
  },
  {
    key: 'regular_price',
    value: 'Regular Price'
  },
  {
    key: 'sale_price',
    value: 'Sale Price'
  },
  {
    key: 'manage_stock',
    value: 'Manage Stock'
  },
  {
    key: 'stock_quantity',
    value: 'Stock Quantity'
  },
  {
    key: 'stock_status',
    value: 'Stock Status'
  },
  {
    key: 'backorders',
    value: 'Backorders'
  },
  {
    key: 'images',
    value: 'Images'
  }
])

const emit = defineEmits(['mappingRowSaved', 'mappingRowRemoved'])

const editMode = ref(false)

const props = defineProps({
  mappingData: Object
})

const pairing: any = ref({ ...props.mappingData })

const remove = () => {
  emit('mappingRowRemoved', pairing)
}

const edit = () => {
  editMode.value = true
}

const save = () => {
  emit('mappingRowSaved', pairing)
  editMode.value = false
}
</script>
<template>
  <tr>
    <td>
      <v-text-field
        v-model="pairing.product_field_id"
        label="Product Field"
        variant="underlined"
        :disabled="!editMode"
      ></v-text-field>
    </td>
    <td class="text-center"><v-icon icon="mdi-arrow-right"></v-icon></td>
    <td>
      <v-select
        :disabled="!editMode"
        v-model="pairing.woocommerce_field_id"
        label="WooCommerce Field"
        :items="wooCommerceFields"
        item-title="value"
        item-value="key"
        variant="underlined"
      ></v-select>
    </td>
    <td class="text-right">
      <v-btn
        v-if="editMode"
        @click="save()"
        color="primary"
        title="Synchronize"
        variant="tonal"
        class="me-3"
        size="small"
        icon="mdi-content-save"
      ></v-btn>
      <v-btn
        v-if="!editMode"
        @click="edit()"
        color="primary"
        title="Synchronize"
        variant="tonal"
        class="me-3"
        size="small"
        icon="mdi-pencil"
      ></v-btn>
      <v-btn
        @click="remove()"
        color="primary"
        title="Configure"
        variant="tonal"
        size="small"
        icon="mdi-delete"
      ></v-btn>
    </td>
  </tr>
</template>
