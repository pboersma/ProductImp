import axios from 'axios';

const getAllProducts = (): Promise<boolean> => axios.get(`${window.location.origin}/wp-json/productimp/v1/gatekeeper/authorized`)
  .then((response) => {
    if (response.data.status === 401) {
      return false;
    }
    return true;
  })
  .catch((error) => {
    console.debug(error);
    // Force True for now as we don't have any mock.
    return true;
  });

function placeholderFunc() {
  return false;
}

export {
  getAllProducts,
  placeholderFunc,
};
