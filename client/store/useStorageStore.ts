import { defineStore } from "pinia";

import api from "@/utils/authAxios";

export const useStorageStore = defineStore("courseStore", () => {
  const UPLOAD_IMAGE_ENPOINT = "api/upload-image";
  const IMAGE_ENDPOINT = "api/image";
  const API_URL = useRuntimeConfig().public.baseApiUrl;

  const uploadImage = async () => {
    await api.post<any>(`${API_URL}/${UPLOAD_IMAGE_ENPOINT}`);
  };

  const getImage = async (name: string) => {
    const res = await api.get<any>(`${API_URL}/${IMAGE_ENDPOINT}/${name}`);

    return res.data;
  };

  return {
    uploadImage,
    getImage,
  };
});
