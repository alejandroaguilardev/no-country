<script setup lang="ts" generic="TValue">
import type { ColumnDef } from "@tanstack/vue-table";
import { FlexRender, getCoreRowModel, useVueTable } from "@tanstack/vue-table";

import StudentsList from "./StudentsList.vue";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { Collapsible, CollapsibleTrigger } from "@/components/ui/collapsible";
import type { TutorTableDTO } from "@/dto/tutorTableDTO";
import { Skeleton } from "@/components/ui/skeleton";
import WithoutContent from "@/components/tables/WithoutContent.vue";

const props = defineProps<{
  columns: ColumnDef<TutorTableDTO, TValue>[];
  data: TutorTableDTO[];
  loading: boolean;
  failed: boolean;
}>();

const emit = defineEmits<{
  (e: "on:show-students", tutor: TutorTableDTO): void;
}>();

const table = useVueTable({
  get data() {
    return props.data;
  },
  get columns() {
    return props.columns;
  },
  getCoreRowModel: getCoreRowModel(),
});

function onShowStudents(tutor: TutorTableDTO) {
  if (tutor.students.length > 0) return;
  emit("on:show-students", tutor);
}
</script>

<template>
  <div class="border rounded-md bg-white">
    <Table>
      <TableHeader>
        <TableRow
          v-for="headerGroup in table.getHeaderGroups()"
          :key="headerGroup.id"
        >
          <TableHead v-for="header in headerGroup.headers" :key="header.id">
            <FlexRender
              v-if="!header.isPlaceholder"
              :render="header.column.columnDef.header"
              :props="header.getContext()"
            />
          </TableHead>
          <TableHead class="text-center"> Estudiantes </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <template v-if="loading">
          <TableRow v-for="index in 10" :key="index">
            <TableCell>
              <Skeleton class="h-4 my-2 w-16 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-2 w-38 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-2 w-38 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-2 w-38 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-2 w-38 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-2 w-38 bg-slate-300" />
            </TableCell>
          </TableRow>
        </template>
        <template v-else-if="table.getRowModel().rows?.length && !failed">
          <Collapsible
            v-for="row in table.getRowModel().rows"
            :key="row.id"
            class="w-full"
            as-child
          >
            <TableRow
              :data-state="row.getIsSelected() ? 'selected' : undefined"
            >
              <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                <FlexRender
                  :render="cell.column.columnDef.cell"
                  :props="cell.getContext()"
                />
              </TableCell>
              <TableCell class="text-center">
                <CollapsibleTrigger>
                  <Button @click="onShowStudents(row.original)">Ver</Button>
                </CollapsibleTrigger>
              </TableCell>
            </TableRow>
            <StudentsList
              :students="row.original.students"
              :loading="row.original.loadingStudents"
            />
          </Collapsible>
        </template>
        <template v-else>
          <WithoutContent :failed="failed" :columns="columns.length" />
        </template>
      </TableBody>
    </Table>
  </div>
</template>
