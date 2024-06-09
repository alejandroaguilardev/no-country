<script setup lang="ts">
import { Eye } from "lucide-vue-next";
import Skeleton from "@/components/ui/skeleton/Skeleton.vue";
import { TableCell, TableHead, TableRow } from "@/components/ui/table";
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
    <TableRow class="flex">
      <div class="grid grid-cols-5 w-full">
        <TableHead class="p-4"> Nombre </TableHead>
        <TableHead class="p-4"> Apellido </TableHead>
        <TableHead class="p-4"> N° Documento </TableHead>
        <TableHead class="p-4"> N° Telefono </TableHead>
        <TableHead class="p-4"> Foto </TableHead>
      </div>
    </TableRow>
    <TableRow
      v-for="(authorized, index) of authorizeds"
      :key="index"
      class="flex"
    >
      <div class="grid grid-cols-5 w-full">
        <TableCell>
          {{ authorized.firstName }}
        </TableCell>
        <TableCell>
          {{ authorized.lastName }}
        </TableCell>
        <TableCell>
          {{ authorized.dni }}
        </TableCell>
        <TableCell>
          {{ authorized.phone }}
        </TableCell>
        <TableCell class="flex gap-2 items-center">
          <Eye
            class="cursor-pointer"
            :size="22"
            @click="emit('on:show-photo', authorized.photo)"
          />
        </TableCell>
      </div>
    </TableRow>
  </template>
  <template v-else>
    <TableCell>
      <span class="text-muted-foreground">Sin autorizados cargados</span>
    </TableCell>
  </template>
</template>
