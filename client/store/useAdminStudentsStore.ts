import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { StudentApi } from "@/types/api/studentApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import { httpCommon } from "@/http-common";

export const useAdminStudentsStore = defineStore("adminStudentsStore", () => {
  const ENDPOINT = "/api/students";
  const { api } = httpCommon();

  async function getStudents(
    offset: number = 0,
    limit: number = 10,
    filters: FilterApi[] = [],
  ) {
    const res = await api.get<ResponseApi<StudentApi>>(ENDPOINT, {
      params: { offset, limit, filters },
    });

    return res.data;
  }

  async function getStudentsByTutor(id: number) {
    const res = await api.get<ResponseApi<StudentApi>>(ENDPOINT, {
      params: { filters: [{ field: "tutor.id", value: id }] },
    });

    return res.data;
  }

  return {
    getStudents,
    getStudentsByTutor,
  };
});
