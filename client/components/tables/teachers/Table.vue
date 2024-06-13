<script setup lang="ts" generic="TValue">
import type { ColumnDef } from "@tanstack/vue-table";
import { FlexRender, getCoreRowModel, useVueTable } from "@tanstack/vue-table";

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Skeleton } from "@/components/ui/skeleton";
import type { TeacherTableDTO } from "@/dto/teacherTableDTO";
import WithoutContent from "@/components/tables/WithoutContent.vue";

const props = defineProps<{
  columns: ColumnDef<TeacherTableDTO, TValue>[];
  data: TeacherTableDTO[];
  loading: boolean;
  failed: boolean;
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
</script>

<template>
  <div class="border rounded-md bg-white">
    <Table>
      <TableHeader>
        <TableRow
          v-for="headerGroup in table.getHeaderGroups()"
          :key="headerGroup.id"
        >
          <TableHead
            v-for="header in headerGroup.headers"
            :key="header.id"
            :class="`w-[${header.getSize()}px]`"
          >
            <FlexRender
              v-if="!header.isPlaceholder"
              :render="header.column.columnDef.header"
              :props="header.getContext()"
            />
          </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <template v-if="loading">
          <TableRow v-for="index in 10" :key="index">
            <TableCell>
              <Skeleton class="h-4 my-[2px] w-full bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-[2px] w-full bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-[2px] w-full bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-[2px] w-full bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 my-[2px] w-full bg-slate-300" />
            </TableCell>
          </TableRow>
        </template>
        <template v-else-if="table.getRowModel().rows?.length && !failed">
          <TableRow
            v-for="row in table.getRowModel().rows"
            :key="row.id"
            :data-state="row.getIsSelected() ? 'selected' : undefined"
          >
            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
              <FlexRender
                :render="cell.column.columnDef.cell"
                :props="cell.getContext()"
              />
            </TableCell>
          </TableRow>
        </template>
        <template v-else>
          <WithoutContent :failed="failed" :columns="columns.length" />
        </template>
      </TableBody>
    </Table>
  </div>
</template>
