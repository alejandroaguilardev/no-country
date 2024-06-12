import { toast } from "vue-sonner";
import api from "../utils/authAxios";

export const authorizedService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const tokenSaved = localStorage.getItem("token");

  const getCargasApoderado = async (): Promise<UserType[]> => {
    try {
      const data = await useFetch(`${baseApiUrl}/api/tutors/students`, {
        method: "GET",
        headers: {
          "Authorization": `Bearer ${tokenSaved}`,
          "Content-Type": "application/json",
        },
      });
      console.log("es JSON?", data.data.value);
      return data.data.value || [];
    } catch (error) {
      console.error("Error :", error);
    }
  };

  const datosAuthorizedForWithdrawal = async (payload: any) => {
    console.log("payload function", payload);
    const formdata = new FormData();
    formdata.append("name", payload.fullName);
    formdata.append("last_name", payload.fullName);
    formdata.append("document_number", payload.dni);
    formdata.append("phone", payload.phoneNumber);
    formdata.append("photo", payload.tutorPhoto);
    formdata.append("tutor_id", payload.tutorId.id);
    [1].forEach((value, index) => {
      formdata.append(`student_id[${index}]`, value.toString());
    });
    try {
      const data = await api.post(`/api/authorizeds`, formdata, {
        headers: {
          "Content-Type": "multipart/form-data",
          "Authorization": `Bearer ${tokenSaved}`,
        },
      });
      if (data.status === 200) {
        toast("Registro Exitoso", {
          description: `Autorizado ${payload.fullName} registrado correctamente.`,
          action: {
            label: "Cerrar",
            onClick: () => console.log("Undo"),
          },
        });
      }
      return data;
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
  const leaveAlone = async (formdata: any) => {
    try {
      await api.post(`/api/authorizeds/leave-alone`, formdata, {
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
    leaveAlone,
  };
};
