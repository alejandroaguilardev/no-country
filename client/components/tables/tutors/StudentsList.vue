<script setup lang="ts">
import Skeleton from "@/components/ui/skeleton/Skeleton.vue";
import { TableCell, TableRow } from "@/components/ui/table";
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
    <TableRow v-for="(student, index) of students" :key="index">
      <TableCell>
        <span class="text-muted-foreground mr-1">Nombre:</span>
        {{ student.firstName }}
      </TableCell>
      <TableCell>
        <span class="text-muted-foreground mr-1">Apellido:</span>
        {{ student.lastName }}
      </TableCell>
      <TableCell>
        <span class="text-muted-foreground mr-1">DNI:</span>
        {{ student.dni }}
      </TableCell>
      <TableCell>
        <span class="text-muted-foreground mr-1">Curso:</span>
        {{ student.course }}
      </TableCell>
    </TableRow>
  </template>
  <template v-else>
    <TableCell>
      <span class="text-muted-foreground">Sin estudiantes cargados</span>
    </TableCell>
  </template>
</template>
