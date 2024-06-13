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
import { Collapsible, CollapsibleTrigger } from "@/components/ui/collapsible";
import type { TutorTableDTO } from "@/dto/tutorTableDTO";
import { Skeleton } from "@/components/ui/skeleton";
import WithoutContent from "@/components/tables/WithoutContent.vue";
import AuthorizedPhotoDialog from "@/components/tables/AuthorizedPhotoDialog.vue";
import AuthorizedsList from "@/components/tables/AuthorizedsList.vue";
import CollapsibleArrow from "@/components/tables/CollapsibleArrow.vue";

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

const authorizedPhotoDialog: Ref<boolean> = ref(false);
const authorizedPhoto: Ref<string> = ref("");

function onShowAuthorizedPhoto(photo: string) {
  authorizedPhotoDialog.value = true;
  authorizedPhoto.value = photo;
}

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
          <TableHead class="text-center"> Cargas </TableHead>
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
            <TableCell>
              <Skeleton class="h-4 my-[2px] w-full bg-slate-300" />
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
                    @click="onShowStudents(row.original)"
                  />
                </CollapsibleTrigger>
              </TableCell>
            </TableRow>
            <tr class="shadow-inner">
              <td class="p-0" colspan="8">
                <CollapsibleContent class="bg-slate-100">
                  <h4 class="text-lg ml-4 my-4">Estudiantes</h4>
                  <StudentsList
                    :students="row.original.students"
                    :loading="row.original.loadingStudents"
                  />
                  <h4 class="text-lg ml-4 my-4">Autorizados</h4>
                  <AuthorizedsList
                    :authorizeds="row.original.authorizeds"
                    :loading="row.original.loadingStudents"
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
