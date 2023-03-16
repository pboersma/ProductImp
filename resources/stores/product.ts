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
            console.log(item);

            return {
                datasource: item.datasource_id,
                name: product.name
            }
        })
    }

    return {
        products,
        fetchAll,
    }
})
