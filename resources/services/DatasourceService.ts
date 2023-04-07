import type { AxiosResponse } from 'axios'
import axios from "axios";

// TODO: Move to Interface Files?
interface AxiosCustomResponse extends AxiosResponse {
    data: AxiosCustomResponseData
}

interface AxiosCustomResponseData {
    status: number
}

export const getDatasources = async (): Promise<any> => {
    return await axios.get(`/productimp/v1/datasources`)
        .then((response: AxiosCustomResponse) => {
            return response.data;
        })
        .catch(error => {
            throw error
        });
};

export const syncDatasource = async (id: any): Promise<any> => {
    return await axios.post(`/productimp/v1/synchronize`, {
        resource: 'DataSource',
        id: id
    })
        .then((response: AxiosCustomResponse) => {
            return response.data;
        })
        .catch(error => {
            throw error
        });
};