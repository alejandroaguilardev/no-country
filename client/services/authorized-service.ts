import type { UserType } from "../types/models/user";

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
  const cargaImagen = async (formData: any) => {
    try {
      // formData.status = formData.get("status") || "0";

      await fetch(`${baseApiUrl}/api/updad-image`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });
    } catch (error) {
      console.log("error", error);
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
        body: JSON.stringify(payload),
      });
    } catch (error) {
      console.log("error en datosAuthorizedForWithdrawal", error);
    }
  };
  return {
    getCargasApoderado,
    datosAuthorizedForWithdrawal,
    cargaImagen,
  };
};
