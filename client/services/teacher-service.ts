import type { StudentType } from "@/types/models";

export const teacherService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const getAllStudents = async (): Promise<StudentType[]> => {
    try {
      const { data } = await useFetch(`${baseApiUrl}/api/students`, {
        method: "GET",
      });
      return data._rawValue.rows || [];
    } catch (error) {
      console.error("Error fetching students:", error);
      throw error;
    }
  };

  const retiredStudent = async (formData: any, idStudent: number) => {
    try {
      formData.status = formData.get("status") || "0";

      await fetch(`${baseApiUrl}/api/retireds/${idStudent}`, {
        method: "PATCH",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });
    } catch (error) {
      console.error("Error updating student status:", error);
      throw error;
    }
  };

  return {
    getAllStudents,
    retiredStudent,
  };
};
