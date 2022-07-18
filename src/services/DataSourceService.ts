import axios from 'axios';

const getAllDataSources = (): Promise<boolean> => axios.get('https://boersma.dev/wp-json/productimp/v1/datasources/list')
  .then((response) => response.data.data)
  .catch((error) => {
    console.debug(error);
  });

function placeholderFunc() {
  return false;
}

export {
  getAllDataSources,
  placeholderFunc,
};
