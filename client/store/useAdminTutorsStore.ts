import axios from "axios";
import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import type { TutorApi } from "@/types/api/tutorApi";

export const useAdminTutorsStore = defineStore("adminTutorsStore", () => {
  const ENDPOINT = "/api/tutors";
  const API_URL = useRuntimeConfig().public.baseApiUrl + ENDPOINT;

  async function getTutors(
    offset: number = 0,
    limit: number = 10,
    filters: FilterApi[] = [],
  ) {
    const res = await axios.get<ResponseApi<TutorApi>>(API_URL, {
      params: { offset, limit, filters },
    });

    return res.data;
  }

  return {
    getTutors,
  };
});
