import type { StudentType } from "@/types/models";

export const authorizedService = () => {
  const runtimeConfig = useRuntimeConfig();

  const baseApiUrl = runtimeConfig.public.baseApiUrl;

  const getCargasApoderado = async (): Promise<StudentType[]> => {
    try {
      const data = await useFetch(`${baseApiUrl}/api/authorizeds`);
      console.log("get Cargas", data);
      return data;
    } catch (error) {
      console.error("Error :", error);
    }
  };
  const datosAuthorizedForWithdrawal = async (
    formData: any,
    idTutor: number,
  ) => {
    try {
      formData.status = formData.get("status") || "0";

      await fetch(`${baseApiUrl}/api/retireds/${idTutor}`, {
        method: "PATCH",
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
