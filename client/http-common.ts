import axios from "axios";
import { useAuthStore } from "./store/useAuthStore";

export const httpCommon = () => {
  const config = useNuxtApp().$config;
  const apiBaseUrl = config.public.baseApiUrl as string;

  const api = axios.create({
    baseURL: apiBaseUrl,
  });

  if (process.client === false) return { api };

  const token = localStorage.getItem("token");
  if (token != null) {
    const authHeader = "Bearer " + token;
    api.defaults.headers.common.Authorization = authHeader;
  }

  api.interceptors.response.use(
    (response) => {
      return response;
    },
    (error) => {
      if (error.response?.status === 401) {
        const { setNewToken } = useAuthStore();
        setNewToken();
      }
      return Promise.reject(error);
    },
  );

  return { api };
};
