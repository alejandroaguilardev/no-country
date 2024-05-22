<script setup lang="ts">
import { ref } from 'vue'
import { CollapsibleContent } from '@/components/ui/collapsible'
import { TableCell, TableRow, } from "@/components/ui/table"

const props = defineProps<{
  students: any[]
}>()

</script>

<template>
  <tr class="shadow-inner">
    <td colspan="8">
      <CollapsibleContent class="bg-slate-100">
        <template v-if="students.length > 0">
          <TableRow v-for="student of students">
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
              <span class="text-muted-foreground mr-1">Edad:</span>
              {{ student.age }}
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
      </CollapsibleContent>
    </td>
  </tr>
</template>