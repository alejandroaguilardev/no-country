<script setup lang="ts" generic="TValue">
import type { ColumnDef } from "@tanstack/vue-table";
import { FlexRender, getCoreRowModel, useVueTable } from "@tanstack/vue-table";
import AuthorizedsList from "../AuthorizedsList.vue";
import AuthorizedPhotoDialog from "../AuthorizedPhotoDialog.vue";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Skeleton } from "@/components/ui/skeleton";
import type { StudentTableDTO } from "@/dto/studentTableDTO";
import WithoutContent from "@/components/tables/WithoutContent.vue";
import {
  Collapsible,
  CollapsibleTrigger,
  CollapsibleContent,
} from "@/components/ui/collapsible";
import CollapsibleArrow from "@/components/tables/CollapsibleArrow.vue";

const props = defineProps<{
  columns: ColumnDef<StudentTableDTO, TValue>[];
  data: StudentTableDTO[];
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

const authorizedPhotoDialog: Ref<boolean> = ref(false);
const authorizedPhoto: Ref<string> = ref("");

function onShowAuthorizedPhoto(photo: string) {
  authorizedPhotoDialog.value = true;
  authorizedPhoto.value = photo;
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
          <TableHead class="text-center"> Autorizado </TableHead>
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
              <TableCell class="relative">
                <CollapsibleTrigger>
                  <CollapsibleArrow
                    v-model:open="row.original.collapseControl"
                  />
                </CollapsibleTrigger>
              </TableCell>
            </TableRow>
            <tr class="shadow-inner">
              <td colspan="8">
                <CollapsibleContent class="bg-slate-100">
                  <h4 class="text-lg ml-4 my-4">Autorizados</h4>
                  <AuthorizedsList
                    :authorizeds="[row.original.authorized]"
                    @on:show-photo="onShowAuthorizedPhoto"
                  />
                </CollapsibleContent>
              </td>
            </tr>
          </Collapsible>
        </template>
        <template v-else>
          <WithoutContent :failed="failed" :columns="columns.length" />
        </template>
      </TableBody>
    </Table>
  </div>
  <AuthorizedPhotoDialog
    v-model:visibility="authorizedPhotoDialog"
    :photo="authorizedPhoto"
  />
</template>
