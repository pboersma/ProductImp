import axios from 'axios';

const getAll = (): Promise<boolean> => axios.get('https://boersma.dev/wp-json/productimp/v1/products/list')
  .then((response) => response.data.data)
  .catch((error) => {
    console.debug(error);
    // Force True for now as we don't have any mock.
    return true;
  });

function placeholderFunc() {
  return false;
}

export {
  getAll,
  placeholderFunc,
};
