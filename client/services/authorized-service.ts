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

  const datosAuthorizedForWithdrawal = async (
    payload: any,
    tutorId: number,
    studentsId: number[],
  ) => {
    console.log("payload function", payload);
    const formdata = new FormData();
    formdata.append("name", payload.fullName);
    formdata.append("last_name", payload.fullName);
    formdata.append("document_number", payload.dni);
    formdata.append("phone", payload.phoneNumber);
    formdata.append("photo", payload.tutorPhoto);
    formdata.append("tutor_id", tutorId.toString());
    studentsId.forEach((studentId) => {
      formdata.append("student_id[]", studentId.toString());
    });

    const data = await api.post(`/api/authorizeds`, formdata, {
      headers: {
        "Content-Type": "multipart/form-data",
        "Authorization": `Bearer ${tokenSaved}`,
      },
    });

    return data;
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
  const leaveAlone = async (payload: any) => {
    await api.post(`/api/authorizeds/leave-alone`, payload);
  };
  return {
    getCargasApoderado,
    datosAuthorizedForWithdrawal,
    cargaImagen,
    leaveAlone,
  };
};
