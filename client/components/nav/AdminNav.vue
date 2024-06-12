<template>
  <nav
    class="w-lvw bg-white shadow-md fixed top-0 left-0 flex items-center px-28 z-50"
  >
    <ul class="flex gap-2 items-end">
      <li v-for="(item, i) in navItems" :key="i" class="flex box-content">
        <NuxtLink
          class="p-4 py-6 opacity-50 hover:opacity-100 box-content"
          :to="item.url"
          >{{ item.label }}</NuxtLink
        >
      </li>
    </ul>
    <div class="ml-auto">
      <DropdownMenu v-model:open="currentUserDropdown">
        <DropdownMenuTrigger
          class="text-slate-800 text-sm flex gap-1 justify-center"
        >
          <CircleUserRound :size="18" />
          {{ currentUser?.name }}
          <ChevronDown
            :size="18"
            class="dropdown-arrow"
            :style="currentUserDropdown ? 'transform: rotate(-180deg)' : ''"
          />
        </DropdownMenuTrigger>
        <DropdownMenuContent>
          <!--          <DropdownMenuLabel>Mi cuenta</DropdownMenuLabel>
          <DropdownMenuSeparator /> -->
          <DropdownMenuItem @click="onLogout">Cerrar sesión</DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ChevronDown, CircleUserRound } from "lucide-vue-next";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  // DropdownMenuLabel,
  // DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { useAuthStore } from "@/store/useAuthStore";
import type { UserType } from "@/types/models";

const currentUser: Ref<UserType | null> = ref(null);
const currentUserDropdown: Ref<boolean> = ref(false);
const navItems = [
  {
    label: "Maestros",
    url: "/admin/teachers",
  },
  {
    label: "Apoderados",
    url: "/admin/tutors",
  },
  {
    label: "Estudiantes",
    url: "/admin/students",
  },
  {
    label: "Historial de retiros",
    url: "/admin/historical",
  },
];

const onLogout = () => {
  useAuthStore().logout();
};

onMounted(() => {
  const { user } = useAuthStore();
  currentUser.value = user;
});
</script>

<style scoped>
.dropdown-arrow {
  transition: all 0.2s ease-in-out;
}

.router-link-active {
  @apply opacity-100;
  position: relative;
}

.router-link-active::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background-color: #000;
}
</style>
