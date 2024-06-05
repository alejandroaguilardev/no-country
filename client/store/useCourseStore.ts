import { defineStore } from "pinia";
import api from "@/utils/authAxios";
import type { CourseType } from "@/types/models";

export const useCourseStore = defineStore("courseStore", () => {
  const ENDPOINT = "/api/courses";
  const API_URL = useRuntimeConfig().public.baseApiUrl + ENDPOINT;

  const getCourses = async () => {
    const res = await api.get<CourseType[]>(API_URL);

    return res.data.rows;
  };

  return {
    getCourses,
  };
});
