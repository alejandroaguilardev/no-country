<script setup lang="ts">
<<<<<<< HEAD
import { Button } from "@/components/ui/button";
import { useRouter } from "vue-router";
=======
import { useRouter } from "vue-router";
import { useAuthStore } from "@/store/useAuthStore";
import { RoleEnum } from "@/types/models";
>>>>>>> origin/dev

onMounted(() => {
  const { push } = useRouter();
  const { user } = useAuthStore();
  switch (user?.role) {
    case RoleEnum.ADMIN:
      push("/admin/teachers");
      break;
    case RoleEnum.TEACHER:
      push("/teacher");
      break;
    case RoleEnum.AUTHORIZED:
      push("/authorized/register");
      break;
  }
});
</script>

<template>
  <NuxtLayout name="main-layout" as="main"> </NuxtLayout>
</template>
