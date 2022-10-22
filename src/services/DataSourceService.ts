/* eslint-disable camelcase */
import axios from 'axios';

// TODO: Move to seperate interfaces file

interface DataSourceCredentials {
  username: string | null,
  password: string | null
}

interface DataSource {
  datasource_name?: string | null,
  datasource_url: string | null,
  datasource_credentials: DataSourceCredentials
}

const getAll = (): Promise<Array<DataSource>> => axios.get('https://boersma.dev/wp-json/productimp/v1/datasources/list')
  .then((response) => {
    console.log('RECALL', response);
    return response.data.data;
  })
  .catch((error) => {
    console.debug(error);
  });

// TODO: add error handling.
const create = (payload: DataSource): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/datasources/store', payload)
  .then((response) => true);

export {
  DataSourceCredentials,
  DataSource,
  getAll,
  create,
};
