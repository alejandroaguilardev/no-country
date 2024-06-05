<template>
  <TableRow>
    <td :colspan="100" class="h-96 text-center text-lg text-slate-700">
      <div class="flex h-full gap-2 items-center justify-center">
        <CircleX v-if="failed" />
        {{ failed ? "Hubo un error al cargar los datos" : "No hay resultados" }}
      </div>
    </td>
  </TableRow>
</template>

<script setup lang="ts">
import { CircleX } from "lucide-vue-next";
import TableRow from "@/components/ui/table/TableRow.vue";

defineProps<{
  columns: number;
  failed: boolean;
}>();
</script>
