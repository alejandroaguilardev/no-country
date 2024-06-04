import type { CourseType } from "@/types/models";

export const courseService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const getAllCourses = async (): Promise<CourseType[]> => {
    try {
      const { data } = await useFetch(`${baseApiUrl}/api/courses`, {
        method: "GET",
      });
      return data._rawValue.rows || [];
    } catch (error) {
      console.error("Error fetching courses:", error);
      throw error;
    }
  };

  return {
    getAllCourses,
  };
};
