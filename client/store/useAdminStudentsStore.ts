import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { StudentApi } from "@/types/api/studentApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import type { StudentType } from "@/types/models";
import api from "@/utils/authAxios";

export const useAdminStudentsStore = defineStore("adminStudentsStore", () => {
  const ENDPOINT = "/api/students";

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

  async function getStudentsByCourse(id: number) {
    const res = await api.get<StudentType[]>(`${API_URL}/course/${id}`);

    return res.data;
  }

  return {
    getStudents,
    getStudentsByTutor,
    getStudentsByCourse,
  };
});
