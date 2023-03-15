import axios from 'axios';

const getWoocommerceProduct = (id: string): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/woocommerce/product/read', { product_id: id })
  .then((response) => {
    console.log(response);
    return true;
  });

const createWoocommerceProduct = (id: string): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/woocommerce/product/create', { product_id: id })
  .then((response) => {
    console.log(response);
    return true;
  });

export {
  getWoocommerceProduct,
  createWoocommerceProduct,
};
