import { reactive, type Ref } from 'vue';
import { ref } from 'vue'
import { defineStore } from 'pinia'
import { getProducts } from '@/services/ProductService';

export const useProductStore = defineStore('products', () => {
    const products: any = ref({})

    const fetchAll = async () => {
        const response = await getProducts()

        products.value = response[0].map((item: any) => {
            const product = JSON.parse(item.product);

            return {
                datasource: item.datasource_id,
                id: item.id,
                mapped: false,
                mapping: [],
                synced: false,
                name: product.name,
                product: product
            }
        })
    }

    return {
        products,
        fetchAll,
    }
})
