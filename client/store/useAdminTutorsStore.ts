import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import type { TutorApi } from "@/types/api/tutorApi";
import api from "@/utils/authAxios";

export const useAdminTutorsStore = defineStore("adminTutorsStore", () => {
  const ENDPOINT = "/api/tutors";

  async function getTutors(
    offset: number = 0,
    limit: number = 10,
    filters: FilterApi[] = [],
  ) {
    const res = await api.get<ResponseApi<TutorApi>>(ENDPOINT, {
      params: { offset, limit, filters },
    });

    return res.data;
  }

  return {
    getTutors,
  };
});
