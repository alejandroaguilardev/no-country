import axios from "axios";
import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import type { TeacherApi } from "@/types/api/teacherApi";

export const useAdminTeachersStore = defineStore("adminTeachersStore", () => {
  const ENDPOINT = "/api/teachers";
  const API_URL = useRuntimeConfig().public.baseApiUrl + ENDPOINT;

  async function getTeachers(
    offset: number = 0,
    limit: number = 10,
    filters: FilterApi[] = [],
  ) {
    const res = await axios.get<ResponseApi<TeacherApi>>(API_URL, {
      params: { offset, limit, filters },
    });

    return res.data;
  }

  return {
    getTeachers,
  };
});
