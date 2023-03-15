import axios from 'axios';

const getAll = (): Promise<boolean> => axios.get('https://boersma.dev/wp-json/productimp/v1/products/list')
  .then((response) => response.data.data)
  .catch((error) => {
    console.debug(error);
    // Force True for now as we don't have any mock.
    return true;
  });

const saveMap = (id: string, mappings: any): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/products/map', { product_id: id, map: mappings })
  .then((response) => {
    console.log(response);
    return true;
  });

const getMap = (id: string): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/products/map/get', { product_id: id })
  .then((response) => {
    console.log(response);
    return true;
  });

const getMappings = (): Promise<boolean> => axios.get('https://boersma.dev/wp-json/productimp/v1/products/map')
  .then((response) => response.data.data)
  .catch((error) => {
    console.debug(error);
    // Force True for now as we don't have any mock.
    return true;
  });

export {
  getAll,
  saveMap,
  getMap,
  getMappings,
};
