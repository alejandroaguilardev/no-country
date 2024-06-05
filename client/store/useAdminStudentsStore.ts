import axios from "axios";
import { defineStore } from "pinia";
import type { ResponseApi } from "@/types/api/responseApi";
import type { StudentApi } from "@/types/api/studentApi";
import type { FilterApi } from "@/types/api/filters/filterApi";
import type { StudentType } from "@/types/models";
import api from "@/utils/authAxios";

export const useAdminStudentsStore = defineStore("adminStudentsStore", () => {
  const ENDPOINT = "/api/students";
  const API_URL = useRuntimeConfig().public.baseApiUrl + ENDPOINT;

  async function getStudents(
    offset: number = 0,
    limit: number = 10,
    filters: FilterApi[] = [],
  ) {
    const res = await axios.get<ResponseApi<StudentApi>>(API_URL, {
      params: { offset, limit, filters },
    });

    return res.data;
  }

  async function getStudentsByTutor(id: number) {
    const res = await axios.get<ResponseApi<StudentApi>>(API_URL, {
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
