<script setup lang="ts">
import { Eye } from "lucide-vue-next";
import Skeleton from "@/components/ui/skeleton/Skeleton.vue";
import { TableCell, TableRow } from "@/components/ui/table";
import type { AuthorizedTableDTO } from "@/dto/authorizedTableDTO";

defineProps<{
  authorizeds: AuthorizedTableDTO[];
  loading?: boolean;
}>();

const emit = defineEmits<{
  (e: "on:show-photo", photo: string): void;
}>();
</script>

<template>
  <template v-if="loading">
    <TableRow>
      <TableCell v-for="index in 4" :key="index">
        <Skeleton class="h-4 w-28 bg-slate-300" />
      </TableCell>
    </TableRow>
  </template>
  <template v-else-if="authorizeds.length > 0">
    <TableRow v-for="(authorized, index) of authorizeds" :key="index">
      <TableCell>
        <span class="text-muted-foreground mr-1">Nombre:</span>
        {{ authorized.firstName }}
      </TableCell>
      <TableCell>
        <span class="text-muted-foreground mr-1">Apellido:</span>
        {{ authorized.lastName }}
      </TableCell>
      <TableCell>
        <span class="text-muted-foreground mr-1">DNI:</span>
        {{ authorized.dni }}
      </TableCell>
      <TableCell>
        <span class="text-muted-foreground mr-1">N° Telefono:</span>
        {{ authorized.phone }}
      </TableCell>
      <TableCell class="flex gap-2 items-center">
        <span class="text-muted-foreground mr-1">Foto:</span>
        <Eye
          class="cursor-pointer"
          :size="22"
          @click="emit('on:show-photo', authorized.photo)"
        />
      </TableCell>
    </TableRow>
  </template>
  <template v-else>
    <TableCell>
      <span class="text-muted-foreground">Sin autorizados cargados</span>
    </TableCell>
  </template>
</template>
