<script setup lang="ts">
import Skeleton from "@/components/ui/skeleton/Skeleton.vue";
import { TableCell, TableHead, TableRow } from "@/components/ui/table";
import type { StudentTableDTO } from "@/dto/studentTableDTO";

defineProps<{
  students: StudentTableDTO[];
  loading: boolean;
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
  <template v-else-if="students.length > 0">
    <TableRow class="flex">
      <div class="grid grid-cols-4 w-full">
        <TableHead class="p-4"> Nombre </TableHead>
        <TableHead class="p-4"> Apellido </TableHead>
        <TableHead class="p-4"> N° Documento </TableHead>
        <TableHead class="p-4"> Curso </TableHead>
      </div>
    </TableRow>
    <TableRow v-for="(student, index) of students" :key="index" class="flex">
      <div class="grid grid-cols-4 w-full">
        <TableCell>
          {{ student.firstName }}
        </TableCell>
        <TableCell>
          {{ student.lastName }}
        </TableCell>
        <TableCell>
          {{ student.dni }}
        </TableCell>
        <TableCell>
          {{ student.course }}
        </TableCell>
      </div>
    </TableRow>
  </template>
  <template v-else>
    <TableCell>
      <span class="text-muted-foreground">Sin estudiantes cargados</span>
    </TableCell>
  </template>
</template>
