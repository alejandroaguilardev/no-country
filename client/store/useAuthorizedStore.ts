import { defineStore } from "pinia";
import api from "@/utils/authAxios";
import type { StudentType } from "@/types/models";

export const useAuthorizedStore = defineStore("authorizedStore", () => {
  const ENDPOINT = "/api/tutors/students";
  const API_URL = useRuntimeConfig().public.baseApiUrl + ENDPOINT;

  const getCargasApoderado = async () => {
    const res = await api.get<StudentType[]>(API_URL);

    return res.data;
  };

  return {
    getCargasApoderado,
  };
});
