import type { StudentType } from "@/types/models";

export const teacherService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const getAllStudents = async (): Promise<StudentType[]> => {
    const { data } = await useFetch(`${baseApiUrl}/api/students`, {
      method: "GET",
    });
    return data._rawValue.rows || [];
    // return data.value || null;
  };

  return {
    getAllStudents,
  };
};
