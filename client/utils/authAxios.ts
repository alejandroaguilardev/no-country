import axios from "axios";
import { useAuthStore } from "@/store/useAuthStore";

const { token } = useAuthStore();
const config = useRuntimeConfig();

const api = axios.create({
  baseURL: config.public.baseApiUrl,
  headers: {
    "Authorization": `Bearer ${token}`,
    "Content-Type": "application/json",
  },
});

export default api;
