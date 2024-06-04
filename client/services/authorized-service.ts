import type { StudentType } from "@/types/models";

export const authorizedService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const getCargasApoderado = async () => {
    try {
      const data = await useFetch(`${baseApiUrl}/api/authorizeds`, {
        method: "GET",
      });
      console.log("get Cargas", data);
      return data.data._rawValue.rows || [];
    } catch (error) {
      console.error("Error :", error);
    }
  };
  const cargaImagen = async () => {
    try {
      const data = await useFetch(`${baseApiUrl}/api/upload-image`, payload);
      return data.data;
    } catch (error) {
      console.log("error", error);
    }
  };
  const datosAuthorizedForWithdrawal = async (formData: any) => {
    try {
      formData.status = formData.get("status") || "0";

      await fetch(`${baseApiUrl}/api/update-authorized`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
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
