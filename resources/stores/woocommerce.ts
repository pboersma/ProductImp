import { ref } from 'vue'
import { defineStore } from 'pinia'
import { store, getAll } from '@/services/WooCommerceService'

export const useWoocommerceStore = defineStore('woocommerce', () => {
    const woocommerceProducts: any = ref([])

    const save = async (product_id: any) => {
        await store({
            product_id: product_id
        })
    }

    const fetchAll = async () => {
        const response = await getAll();

        woocommerceProducts.value = response[0];
    }

    return {
        // State
        woocommerceProducts,
        // Actions
        save,
        fetchAll
    }
})
