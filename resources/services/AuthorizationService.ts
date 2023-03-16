import type { AxiosResponse } from 'axios'
import axios from "axios";

// TODO: Move to Interface Files?
interface AxiosCustomResponse extends AxiosResponse {
    data: AxiosCustomResponseData
}

interface AxiosCustomResponseData {
    status: number
}

export const getAuthorizationStatus = async (): Promise<boolean> => {
    return await axios.get(`/productimp/v1/authorization/authorized`)
        .then((response: AxiosCustomResponse) => {
            if (response.data.status === 401) {
                return false
            }

            return true
        })
        .catch(error => {
            throw error
        });
};

export const authorizeClient = async (): Promise<any> => {
    return await axios.get(`/productimp/v1/authorization/generate`)
        .then((response: AxiosCustomResponse) => {
            console.log(response);
        })
        .catch(error => {
            throw error
        });
}