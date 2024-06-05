import { defineStore } from "pinia";
import api from "@/utils/authAxios";

export const useRetiredStore = defineStore("retiredStore", () => {
  const RETIREDS_ENDPOINT = "api/retireds";
  const AUSENT_ENDPOINT = "api/ausent";
  const API_URL = useRuntimeConfig().public.baseApiUrl;

  const retiredStudent = async (formData: any, idStudent: number) => {
    try {
      formData.status = formData.get("status") || "0";

      await api.patch(`${API_URL}/${RETIREDS_ENDPOINT}/${idStudent}`, formData);
    } catch (error) {
      console.error("Error updating student status:", error);
      throw error;
    }
  };

  const presenceStudent = async (formData: any, idStudent: number) => {
    try {
      formData.presence = formData.get("presence") || "0";
      console.log(formData);

      await api.patch(`${API_URL}/${AUSENT_ENDPOINT}/${idStudent}`, formData);
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
