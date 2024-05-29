<script setup lang="ts" generic="TData, TValue">
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

const props = defineProps<{
  columns: ColumnDef<TData, TValue>[];
  data: TData[];
  loading: boolean;
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
          <TableHead v-for="header in headerGroup.headers" :key="header.id">
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
              <Skeleton class="h-4 w-16 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 w-38 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 w-38 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 w-38 bg-slate-300" />
            </TableCell>
            <TableCell>
              <Skeleton class="h-4 w-12 bg-slate-300" />
            </TableCell>
          </TableRow>
        </template>
        <template v-else-if="table.getRowModel().rows?.length">
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
          <TableRow>
            <td
              :colspan="columns.length"
              :rowspan="10"
              class="h-96 text-center"
            >
              Sin resultados.
            </td>
          </TableRow>
        </template>
      </TableBody>
    </Table>
  </div>
</template>
