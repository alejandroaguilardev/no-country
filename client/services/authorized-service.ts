import type { UserType } from "../types/models/user";
import api from "../utils/authAxios";
export const authorizedService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const user = ref<UserType | null>(null);

  console.log("user", user.value);

  const tokenSaved = localStorage.getItem("token");
  console.log("token", tokenSaved);
  const getCargasApoderado = async (): Promise<UserType[]> => {
    try {
      const data = await useFetch(`${baseApiUrl}/api/tutors/students`, {
        method: "GET",
        headers: {
          "Authorization": `Bearer ${tokenSaved}`,
          "Content-Type": "application/json",
        },
      });
      console.log("get Cargas", data.data.value);
      return data.data.value || [];
    } catch (error) {
      console.error("Error :", error);
    }
  };

  const datosAuthorizedForWithdrawal = async (payload) => {
    console.log("payload function", payload);
    try {
      await fetch(`${baseApiUrl}/api/authorizeds`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": `Bearer ${tokenSaved}`,
        },
        body: payload,
      });
    } catch (error) {
      console.log("error en datosAuthorizedForWithdrawal", error);
    }
  };
  const cargaImagen = async (image: any) => {
    const formdata = new FormData();
    try {
      formdata.append("image", image);

      await api.post(`/api/upload-image`, formdata, {
        headers: { "Content-Type": "multipart/form-data" },
      });
    } catch (error) {
      console.log("error", error);
    }
  };
  return {
    getCargasApoderado,
    datosAuthorizedForWithdrawal,
    cargaImagen,
  };
};
