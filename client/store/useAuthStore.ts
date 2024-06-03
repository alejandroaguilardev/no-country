import { defineStore } from "pinia";
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import type { UserType } from "../types/models/user";
import type { LoginRes } from "../types/queries/LoginQuery";

export const useAuthStore = defineStore("auth", () => {
  const ENDPOINT = "/auth/login";
  const API_URL = useRuntimeConfig().public.baseApiUrl + ENDPOINT;
  // Declaring states for user store
  const token = ref<string>("");
  const user = ref<UserType | null>(null);

  // Initial store w/app
  const userSaved = localStorage.getItem("user");
  const tokenSaved = localStorage.getItem("token");
  if (userSaved && tokenSaved) {
    user.value = JSON.parse(userSaved);
    token.value = tokenSaved;
  }

  // Store watcher to update in localStorage when the store is updated
  watch(
    user,
    (userVal) => {
      localStorage.setItem("user", userVal ? JSON.stringify(userVal) : "");
      localStorage.setItem("token", token.value);
    },
    { deep: true },
  );

  const router = useRouter();

  function login(data: LoginRes) {
    const { token: newToken, user: newUser } = data;
    if (newToken && user) {
      token.value = newToken;
      user.value = newUser;
      router.push("/dashboard");
    }
  }
  function logout() {
    token.value = "";
    user.value = null;
    router.push("/login");
  }

  async function setNewToken() {
    const { data } = await axios.get<{ newToken: string }>(API_URL, {
      headers: { Authorization: token.value },
    });
    token.value = data.newToken;
    localStorage.setItem("token", data.newToken);
  }
  return { token, user, login, logout, setNewToken };
});
