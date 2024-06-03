import type { StudentType } from "@/types/models";

export const authorizedService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const getCargasApoderado = async () => {
    try {
      const data = await fetch(`${baseApiUrl}/api/authorizeds`, {
        method: "GET",
      });
      console.log("get Cargas", data);
    } catch (error) {
      console.error("Error :", error);
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
  };
};
