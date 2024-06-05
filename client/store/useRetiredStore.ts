import { defineStore } from "pinia";
import api from "@/utils/authAxios";

export const useRetiredStore = defineStore("retiredStore", () => {
  const ENDPOINT = "/api/retireds";
  const API_URL = useRuntimeConfig().public.baseApiUrl + ENDPOINT;

  const retiredStudent = async (formData: any, idStudent: number) => {
    try {
      formData.presence = formData.get("status") || "0";

      await api.patch(`${API_URL}/${idStudent}`, {
        body: JSON.stringify(formData),
      });
    } catch (error) {
      console.error("Error updating student status:", error);
      throw error;
    }
  };

  const presenceStudent = async (formData: any, idStudent: number) => {
    try {
      formData.presence = formData.get("presence") || "0";

      await api.patch(`${API_URL}/${idStudent}`, {
        body: JSON.stringify(formData),
      });
    } catch (error) {
      console.error("Error updating student presence:", error);
      throw error;
    }
  };

  return {
    retiredStudent,
    presenceStudent,
  };
});
