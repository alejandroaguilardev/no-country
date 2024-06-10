import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import type { TeacherApi } from "@/types/api/teacherApi";
import api from "@/utils/authAxios";

export const useAdminTeachersStore = defineStore("adminTeachersStore", () => {
  const ENDPOINT = "/api/teachers";

  async function getTeachers(
    offset: number = 0,
    limit: number = 10,
    filters: FilterApi[] = [],
  ) {
    const res = await api.get<ResponseApi<TeacherApi>>(ENDPOINT, {
      params: { offset, limit, filters },
    });

    return res.data;
  }

  return {
    getTeachers,
  };
});
