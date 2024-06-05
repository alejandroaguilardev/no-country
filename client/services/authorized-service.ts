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

  const datosAuthorizedForWithdrawal = async (payload: any) => {
    console.log("payload function", payload);
    const formdata = new FormData();
    formdata.append("name", payload.name);
    formdata.append("last_name", payload.last_name);
    formdata.append("document_number", payload.document_number);
    formdata.append("phone", payload.phone);
    formdata.append("photo", payload.photo);
    formdata.append("tutor_id", payload.tutor_id);

    [1].forEach((value, index) => {
      formdata.append(`student_id[${index}]`, value.toString());
    });
    console.log("este funciona!!!", formdata);
    try {
      await api.post(`/api/authorizeds`, formdata, {
        headers: {
          "Content-Type": "multipart/form-data",
          "Authorization": `Bearer ${tokenSaved}`,
        },
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
