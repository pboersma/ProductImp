/* eslint-disable camelcase */
import axios from 'axios';
import { DataSource } from '../interfaces/DataSource';

const getAll = (): Promise<Array<DataSource>> => axios.get('https://boersma.dev/wp-json/productimp/v1/datasources/list')
  .then((response) => response.data.data)
  .catch((error) => {
    console.debug(error);
  });

const getSingle = (id: string): Promise<Array<DataSource>> => axios.post('https://boersma.dev/wp-json/productimp/v1/datasources/read', { id })
  .then((response) => response.data.data)
  .catch((error) => {
    console.debug(error);
  });

// TODO: add error handling.
const create = (payload: DataSource): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/datasources/create', payload)
  .then((response) => true);

const destroy = (id: string): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/datasources/delete', {
  id,
}).then((response) => true);

const sync = (id: string): Promise<boolean> => axios.post('https://boersma.dev/wp-json/productimp/v1/datasources/sync', id)
  .then((response) => {
    console.log(response);
    return true;
  });

export {
  DataSource,
  // Actions
  getAll,
  getSingle,
  create,
  destroy,
  sync,
};
